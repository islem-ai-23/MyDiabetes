<?php
session_start();
require 'config.php';

// تمكين عرض الأخطاء للتdebug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// التحقق من تسجيل الدخول
if (!isset($_SESSION['id'])) {
    die(json_encode(['status' => 'error', 'message' => 'غير مصرح به']));
}

// الحصول على البيانات المرسلة
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['code'])) {
    die(json_encode(['status' => 'error', 'message' => 'بيانات غير صالحة']));
}

$user_id = $_SESSION['id'];
$code = (int)$data['code'];

// التحقق من صحة الكود
if ($code < 1 || $code > 9) {
    die(json_encode(['status' => 'error', 'message' => 'كود النظام غير صالح']));
}

// التحقق من وجود المستخدم في user_regime
$sql = "SELECT * FROM user_regime WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

try {
    if ($result->num_rows > 0) {
        // تحديث السجل الموجود
        $update = "UPDATE user_regime SET regime_id = ?, start_date = CURDATE() WHERE user_id = ?";
        $stmt = $conn->prepare($update);
        $stmt->bind_param("ii", $code, $user_id);
    } else {
        // إنشاء سجل جديد
        $insert = "INSERT INTO user_regime (user_id, regime_id, start_date) VALUES (?, ?, CURDATE())";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param("ii", $user_id, $code);
    }
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        throw new Exception("فشل في تنفيذ الاستعلام");
    }
} catch (Exception $e) {
    die(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
}
?>