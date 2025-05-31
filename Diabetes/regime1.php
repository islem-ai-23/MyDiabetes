<?php
session_start();
require 'config.php';

// تحديد اللغة
$lang = isset($_GET['lang']) && $_GET['lang'] === 'ar' ? 'ar' : 'en';

// التحقق من دخول المستخدم
$loggedIn = false;
$username = 'Unknown';
$email = 'No email';

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT username, email FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();

    $username = $userData['username'] ?? 'Unknown';
    $email = $userData['email'] ?? 'No email';
    $loggedIn = true;

    $stmt->close();
}

// التحقق من user_id في الرابط
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
if ($user_id <= 0) {
    die("Invalid user ID");
}

// جلب بيانات الرجيم
$sql = "SELECT r.* 
        FROM regime r
        JOIN user_regime ur ON r.id = ur.regime_id
        WHERE ur.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// التحقق من وجود بيانات
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($lang === 'ar') {
        // أسماء الوجبات بالعربية
        $breakfast1 = $row['breakfast1_ar'];
        $breakfast2 = $row['breakfast2_ar'];
        $breakfast3 = $row['breakfast3_ar'];
        $lunch1 = $row['lunch1_ar'];
        $lunch2 = $row['lunch2_ar'];
        $lunch3 = $row['lunch3_ar'];
        $snack1 = $row['snack1_ar'];
        $snack2 = $row['snack2_ar'];
        $snack3 = $row['snack3_ar'];
        $dinner1 = $row['dinner1_ar'];
        $dinner2 = $row['dinner2_ar'];
        $dinner3 = $row['dinner3_ar'];

        $b1 = $row['b1_ar']; 
        $b2 = $row['b2_ar']; 
        $b3 = $row['b3_ar'];
        $l1 = $row['l1_ar']; 
        $l2 = $row['l2_ar']; 
        $l3 = $row['l3_ar'];
        $s1 = $row['s1_ar']; 
        $s2 = $row['s2_ar']; 
        $s3 = $row['s3_ar'];
        $d1 = $row['d1_ar']; 
        $d2 = $row['d2_ar']; 
        $d3 = $row['d3_ar'];
    } else {
        // أسماء الوجبات بالفرنسية أو الإنجليزية
        $breakfast1 = $row['breakfast1'];
        $breakfast2 = $row['breakfast2'];
        $breakfast3 = $row['breakfast3'];
        $lunch1 = $row['lunch1'];
        $lunch2 = $row['lunch2'];
        $lunch3 = $row['lunch3'];
        $snack1 = $row['snack1'];
        $snack2 = $row['snack2'];
        $snack3 = $row['snack3'];
        $dinner1 = $row['dinner1'];
        $dinner2 = $row['dinner2'];
        $dinner3 = $row['dinner3'];

        $b1 = $row['b1']; 
        $b2 = $row['b2']; 
        $b3 = $row['b3'];
        $l1 = $row['l1']; 
        $l2 = $row['l2']; 
        $l3 = $row['l3'];
        $s1 = $row['s1']; 
        $s2 = $row['s2']; 
        $s3 = $row['s3'];
        $d1 = $row['d1']; 
        $d2 = $row['d2']; 
        $d3 = $row['d3'];
    }

} else {
    echo "<script>
        alert('No diet plan registered for this user.');
        window.location.href = 'Test.php';
    </script>";
}

$stmt->close();
$conn->close();
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Information</title>
    <link rel="stylesheet" href="regime1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="Home.php"><img src="logo.png" alt="XtraClinic Logo"></a>
            <a href="Home.php"><span class="clinic-name">My<span class="highlight">Diabetes</span></span></a>
        </div>
        <div class="search-user-container">
            <div class="search">
        <form action="search.php" method="GET" class="search-form">
    <input class="search-input" type="text" name="query" placeholder="Search...">
    <button class="btn" type="submit">Search</button>
</form>



            </div>
            
            <div class="user-dropdown">
    <a href="<?php echo $loggedIn ? '#' : 'loginn.php'; ?>" id="user-icon" class="user-icon">
        <i class="fas fa-user-circle"></i>
    </a>
    <?php if ($loggedIn): ?>
        <div id="dropdown-content" class="dropdown-content">
            <p><strong><?php echo htmlspecialchars($username); ?></strong></p>
            <p><?php echo htmlspecialchars($email); ?></p>
            <hr>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    <?php endif; ?>
</div>
<div style="text-align: center; margin: 20px -40px; margin-left:30px; gap:15px">
    <?php if ($lang === 'ar'): ?>
        <a href="?user_id=<?php echo $user_id; ?>&lang=en" class="btn-lang" style="padding: 6px 10px; font-size: 15px; background-color: #005F86; color: white; border: none; border-radius: 5px; text-decoration: none; ">EN</a>
    <?php else: ?>
        <a href="?user_id=<?php echo $user_id; ?>&lang=ar" class="btn-lang" style="padding: 6px 10px; font-size: 15px; background-color: #005F86; color: white; border: none; border-radius: 5px; text-decoration: none;">AR</a>
    <?php endif; ?>
</div>

        </div>
        
    </header>
    <script>
    document.getElementById('user-icon').addEventListener('click', function(e) {
        e.preventDefault();
        if (<?php echo $loggedIn ? 'true' : 'false'; ?>) {
            const dropdown = document.getElementById('dropdown-content');
            dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        } else {
            window.location.href = 'loginn.php';
        }
    });

    document.addEventListener('click', function(e) {
        const icon = document.getElementById('user-icon');
        const dropdown = document.getElementById('dropdown-content');
        if (!icon.contains(e.target) && dropdown && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>

    <nav>
        <ul class="nav-links">
            <li><a href="Home.php" class="active">Home</a></li>
            <li class="dropdown">
                <a href="diabete.php">About Diabetes <i class="fas fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="type1.php">Type 1</a></li>
                    <li><a href="type2.php">Type 2</a></li>
                    <li><a href="type3.php">gestational diabetes</a></li>
                    <li><a href="warning-signs.php">warning signs and symptoms</a></li>
                    <li><a href="prevention.php">diabetes prevention</a></li>
                    <li><a href="Complications.php">diabetes complications</a></li>


                </ul>
            </li>
            <li><a href="FAQ.php">FAQ's</a></li>
            <li><a href="Contacte.php">Contact</a></li>
        </ul>
    </nav>

    <div class="breadcrumb">
        <a href="Home.php">Home</a> &gt; <span>Diet Plan</span>
    </div>

    <section class="hero-banner">
        <div class="hero-overlay">
            <h1 class="hero-title">Your Diabetes-Friendly Diet</h1>
        </div>
    </section>


<h1 style="text-align: center; direction: <?php echo ($lang === 'ar') ? 'rtl' : 'ltr'; ?>;">
    <?php echo $lang === 'ar' ? 'نظام غذائي متوازن لمرضى السكري' : 'Your Balanced Meal Plan for Diabetes'; ?>
</h1>

<!-- Petit Déjeuner / Breakfast -->
<h2 class="section-title" style="text-align: center; direction: <?php echo ($lang === 'ar') ? 'rtl' : 'ltr'; ?>;">
    <?php echo ($lang === 'ar') ? 'فطور' : 'Breakfast'; ?> :
</h2>
<div class="container" style="display: flex; gap: 20px; <?php echo ($lang === 'ar') ? 'direction: rtl; text-align: right;' : 'direction: ltr; text-align: left;'; ?>">
    <div class="card" style="flex: 1;">
        <h3>1. <?php echo htmlspecialchars($b1); ?> </h3>
        <ul>
            <?php
            if (isset($breakfast1)) {
                $items = explode(',', $breakfast1);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
    <div class="card" style="flex: 1;">
        <h3>2. <?php echo htmlspecialchars($b2); ?> </h3>
        <ul>
            <?php
            if (isset($breakfast2)) {
                $items = explode(',', $breakfast2);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
    <div class="card" style="flex: 1;">
        <h3>3. <?php echo htmlspecialchars($b3); ?> </h3>
        <ul>
            <?php
            if (isset($breakfast3)) {
                $items = explode(',', $breakfast3);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
</div>

<!-- Déjeuner / Lunch -->
<h2 class="section-title" style="text-align: center; direction: <?php echo ($lang === 'ar') ? 'rtl' : 'ltr'; ?>;">
    <?php echo ($lang === 'ar') ? 'غداء' : 'Lunch'; ?> :
</h2>
<div class="container" style="display: flex; gap: 20px; <?php echo ($lang === 'ar') ? 'direction: rtl; text-align: right;' : 'direction: ltr; text-align: left;'; ?>">
    <div class="card" style="flex: 1;">
        <h3>1. <?php echo htmlspecialchars($l1); ?> </h3>
        <ul>
            <?php
            if (isset($lunch1)) {
                $items = explode(',', $lunch1);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
    <div class="card" style="flex: 1;">
        <h3>2. <?php echo htmlspecialchars($l2); ?> </h3>
        <ul>
            <?php
            if (isset($lunch2)) {
                $items = explode(',', $lunch2);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
    <div class="card" style="flex: 1;">
        <h3>3. <?php echo htmlspecialchars($l3); ?> </h3>
        <ul>
            <?php
            if (isset($lunch3)) {
                $items = explode(',', $lunch3);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
</div>

<!-- Snacks -->
<h2 class="section-title" style="text-align: center; direction: <?php echo ($lang === 'ar') ? 'rtl' : 'ltr'; ?>;">
    <?php echo ($lang === 'ar') ? 'وجبات خفيفة' : 'Snacks'; ?> :
</h2>
<div class="container" style="display: flex; gap: 20px; <?php echo ($lang === 'ar') ? 'direction: rtl; text-align: right;' : 'direction: ltr; text-align: left;'; ?>">
    <div class="card" style="flex: 1;">
        <h3><?php echo htmlspecialchars($s1); ?> </h3>
        <ul>
            <?php
            if (isset($snack1)) {
                $items = explode(',', $snack1);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
    <div class="card" style="flex: 1;">
        <h3> <?php echo htmlspecialchars($s2); ?> </h3>
        <ul>
            <?php
            if (isset($snack2)) {
                $items = explode(',', $snack2);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
    <div class="card" style="flex: 1;">
        <h3><?php echo htmlspecialchars($s3); ?> </h3>
        <ul>
            <?php
            if (isset($snack3)) {
                $items = explode(',', $snack3);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
</div>

<!-- Dîner / Dinner -->
<h2 class="section-title" style="text-align: center; direction: <?php echo ($lang === 'ar') ? 'rtl' : 'ltr'; ?>;">
    <?php echo ($lang === 'ar') ? 'عشاء' : 'Dinner'; ?> :
</h2>
<div class="container" style="display: flex; gap: 20px; <?php echo ($lang === 'ar') ? 'direction: rtl; text-align: right;' : 'direction: ltr; text-align: left;'; ?>">
    <div class="card" style="flex: 1;">
        <h3>1. <?php echo htmlspecialchars($d1); ?> </h3>
        <ul>
            <?php
            if (isset($dinner1)) {
                $items = explode(',', $dinner1);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
    <div class="card" style="flex: 1;">
        <h3>2. <?php echo htmlspecialchars($d2); ?> </h3>
        <ul>
            <?php
            if (isset($dinner2)) {
                $items = explode(',', $dinner2);
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars(trim($item)) . "</li>\n";
                }
            }
            ?>
        </ul>
    </div>
</div>

<div style="text-align: center; margin: 30px;">
    <button onclick="window.print()" style="padding: 10px 20px; font-size: 23px; background-color: #005F86; color: white; border: none; border-radius: 5px; cursor: pointer;">
        <i class="fas fa-print"></i> Print Meal Plan
    </button>
</div>

<style>
@media print {
    header, nav, .breadcrumb, .search-user-container, footer, button {
        display: none !important;
    }
}
</style>





    
    
    <!--Footer-->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Contact</h3>
                <ul>
                    <li><a href="mailto:islemdiaf633@gmail.com">Email : contact@diabetes-info.com</a></li>
                    <li><a href="tel:+213672925950">Phone : +213 672925950</a></li>
                    <li>Adress: annaba23</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Quik link</h3>
                <ul>
                    <li><a href="Home.php">Home</a></li>
                    <li><a href="diabete.php">About diabets</a></li>
                    <li><a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>">Balanced diet</a></li>
                    <li><a href="FAQ.php">FAQ'S</a></li>
                    <li><a href="Contacte.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>follow us</h3>
                <a href="https://www.facebook.com/profile.php?id=61576556904786" target="_blank"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="https://www.instagram.com/mydiabetes20028/"><i class="fab fa-instagram fa-2x"target="_blank"></i></a>
                <a href="https://twitter.com"><i class="fab fa-twitter fa-2x" target="_blank"></i></a>
                <a href="https://www.linkedin.com"><i class="fab fa-linkedin fa-2x"target="_blank"></i></a>
            </div>
        </div>
        <p class="copyright">© 2025 Diabète Info - Tous droits réservés</p>
    </footer>
</body>
</html>
