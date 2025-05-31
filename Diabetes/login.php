<?php
require 'config.php';
session_start();

// تحقق من الطلب POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);  // إزالة المسافات الزائدة من البريد الإلكتروني
    $password = $_POST["password"];

    // التحقق من الحقول الفارغة
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // إعداد استعلام SQL
        $stmt = $conn->prepare("SELECT * FROM `user` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // تحقق من كلمة المرور المخزنة
            echo "Password entered: " . $password . "<br>";
            echo "Hashed password from DB: " . $user["password"] . "<br>";

            // التحقق من كلمة المرور
            if (password_verify($password, $user["password"])) {
                // تحديث بيانات الجلسة
                $_SESSION["id"] = $user["id"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["username"] = $user["username"];
                header("Location: Home.php");
                exit();
            } else {
                $error = "Incorrect email or password.";
                header("Location: loginn.php?error=" . urlencode($error));
                exit();
            }
        } else {
            // المستخدم غير موجود
            $error = "User not found.";
            header("Location: loginn.php?error=" . urlencode($error));
            exit();
        }

        $stmt->close();
    }

    // إغلاق الاتصال بقاعدة البيانات
    $conn->close();
}
?>
