

<?php
session_start();
require 'config.php';

// Initialize variables
$loggedIn = false;
$username = 'Unknown';
$email = 'No email';
$stmt = null;

// Check if user is logged in
if (isset($_SESSION['id'])) {
    // Get user ID from session
    $userId = $_SESSION['id'];

    // Fetch user data from DB
    $stmt = $conn->prepare("SELECT username, email FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();

    // Assign username and email
    $username = $userData['username'] ?? 'Unknown';
    $email = $userData['email'] ?? 'No email';

    $loggedIn = true;
}

if ($stmt) {
    $stmt->close();  // Close the prepared statement if it was initialized
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacte</title>
    <link rel="stylesheet" href="contacte2.css">
    
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
    <!--la baree de navigateur-->
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
            <li class="dropdown">
    <a href="#">Balanced Diet <i class="fas fa-caret-down"></i></a>
    <ul class="submenu">
        <li>
            <a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>">
                Start the Test
            </a>
        </li>
        <li>
            <a href="<?= $loggedIn ? 'regime1.php?user_id=' . $userId : 'Loginn.php' ?>">
                Show My Plan
            </a>
        </li>
    </ul>
</li>
            
            <li><a href="FAQ.php">FAQ's</a></li>
            <li><a href="Contacte.php">Contact</a></li>
        </ul>
    </nav>
    <!--la barre de home_about diabete-->
    <div class="breadcrumb-container"></div>
    <div class="breadcrumb">
        <a href="Home.php">Home</a> &gt; <span>Contact</span>
    </div>
     <!--Div de titre aboute diabete et l'image-->
     <section class="hero-section">
        <div class="text-p">
            <h5>CONTACT US</h5>
            <h1>Need Help? Reach Out to Our Support Team Today</h1>
</div>

    </section>

    <div class="couleur">
    <div class="symptoms">
        
        <div class="text-symptoms">
            <h2>We are here to help.</h2>

            <p>Our mission is to empower those living with diabetes to take control of their health and achieve a diabetes–free life. Join us today and start your journey to better health!</p>
        </div>
        <div class="image-symptoms">
            <img src="gestationel3.jpg" alt="People walking">
        </div>
    </div>
    <div class="contact">
    <h1>If you need assistance, feel free to contact MyDiabetes:</h1>
    <main>
        <section class="contact-options">
         
    
            <!-- Phone -->
            <div class="option center-call">
                <i class="fas fa-phone-alt"></i> 
                <h2>Call Me Directly</h2>
                <a href="tel:+33672925950" class="contact-btn">06 72 92 59 50</a>
                <p>Happy to hear from you! 📞</p>
            </div>
    
            <!-- Email -->
            <div class="option email-option">
                <i class="fas fa-envelope"></i>
                <h2>Send Me an Email</h2>
                <a href="mailto:contact@diabetes-info.com" class="contact-btn">contact@diabetes-info.com</a>
                <p>I’ll reply as soon as possible 📬</p>
            </div>
        </section>
    </main>
    </div>
   
   
   
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
                    <li><a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>" >Balanced diet</a></li>
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