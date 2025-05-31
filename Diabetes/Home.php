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
    <title>Home</title>
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <!--la barre de titre et search-->
    <header>
        <div class="logo">
            <a href="Home.php"><img src="logo.png" alt="XtraClinic Logo"></a>
            <a href="Home.php"><span class="clinic-name">My<span class="highlight">Diabeties</span></span></a>
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
            e.preventDefault(); // Prevent default link behavior

            // If user is logged in, toggle the dropdown
            if (<?php echo $loggedIn ? 'true' : 'false'; ?>) {
                const dropdown = document.getElementById('dropdown-content');
                dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
            } else {
                // Redirect to loginn.php if not logged in
                window.location.href = 'loginn.php';
            }
        });

        document.addEventListener('click', function(e) {
            const icon = document.getElementById('user-icon');
            const dropdown = document.getElementById('dropdown-content');
            if (!icon.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none'; // Hide the dropdown if clicked outside
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

            <script>
                function toggleSubmenu(event) {
                    event.preventDefault();
                    const submenu = document.getElementById("diet-submenu");
                    submenu.style.display = submenu.style.display === "none" ? "block" : "none";
                }
            </script>

            <li><a href="FAQ.php">FAQ's</a></li>
            <li><a href="Contacte.php">Contact</a></li>
        </ul>
    </nav>

    <!--Div de titre aboute diabete et l'image-->
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="text-content">
            <h1>Take Control of Your Health Today</h1>
            <p>Welcome to <strong>My Diabetes</strong>, your go-to platform for diabetes management. Access expert advice, tests, and resources to adopt the right diet and improve your daily life.</p>
            <a href="diabete.php" class="cta-button">Learn More →</a>
        </div>

        <div class="image-container">
            <img src="home.jpg" alt="Healthy woman drinking water">
        </div>
    </section>


    <section class="info-section">
        <h2><span class="c">Je veux <span class="h">m’informer</span></span></h2>
        <div class="info-cards">
            <a href="prevention.php" class="card">
                <i class="fas fa-shield-alt"></i>
                <p>Diabetes Prevention</p>
            </a>
            <a href="warning-signs.php" class="card">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Warning Signs</p>
            </a>
            <a href="type1.php" class="card">
                <i class="fas fa-user-md"></i>
                <p>Type 1 Diabetes</p>
            </a>
            <a href="type2.php" class="card">
                <i class="fas fa-user-injured"></i>
                <p>Type 2 Diabetes</p>
            </a>
            <a href="type3.php" class="card">
                <i class="fas fa-chart-line"></i>
                <p>Gestational Diabète</p>
            </a>
            <a href="complications.php" class="card">
                <i class="fas fa-briefcase-medical"></i>
                <p>Complications</p>
            </a>
        </div>
    </section>

    <div class="text-image2">
        <div class="text-p2">

            <h2>Find Your Ideal Diet Plan</h2>
            <p>Take our personalized diabetes diet test to discover the best nutrition plan suited to your health needs. Answer a few simple questions and get recommendations instantly! </p>

            <a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>" class="button2">
                Start the Test <i></i>
            </a>
        </div>


        <div class="image2">
            <img src="test1.jpg" alt="homme-l'eau">
        </div>
    </div>

    <div class="text-image3">
        <div class="image3">
            <img src="FAQ1.jpg" alt="Contact InfoDiabetes">
        </div>
        <div class="text-p3">
            <h2>Have questions about diabetes? <br>InfoDiabetes Service</h2>
            <p>Contact our healthcare professionals by email, chat, or phone!</p>
            <p class="note"><em>*Please note that the services offered are not emergency services.</em></p>
            <p> Click <a class="red" href="FAQ.php">here</a> for more details.</p>

            <div class="buttons6">

                <a href="tel:+213672925950" class="btn6"><i class="fas fa-phone-alt"></i> Téléphone</a>
                <a href="mailto:islemdiaf633@gmail.com" class="btn6"><i class="fas fa-envelope"></i> E-mail</a>
            </div>
        </div>


    </div>
    <div class="FC">
        <div class="body1">
            <section id="login-section" class="subscribe-section">

                <h2>Sign up for the <span class="highlight1">Diet Test</span></h2>
                <p>Discover the best nutrition plan to manage your diabetes.</p>
                <a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>" class="subscribe-btn">
                    Start the Test <i class="fas fa-paper-plane"></i>
                </a>

                <a href="<?= $loggedIn ? 'regime1.php?user_id=' . $userId : 'Loginn.php' ?>" class="rej-btn">
                    Show My Plan <i class="fas fa-paper-plane"></i>
                </a>





            </section>
        </div>
        <style>
            html {
                scroll-behavior: smooth;
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
    </div>





</body>

</html>