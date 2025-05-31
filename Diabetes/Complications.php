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
    <title>Complications</title>
    <link rel="stylesheet" href="Complications.css">
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
                        <p><strong>
                                <?php echo htmlspecialchars($username); ?>
                            </strong></p>
                        <p>
                            <?php echo htmlspecialchars($email); ?>
                        </p>
                        <hr>
                        <a href="logout.php" class="logout-link">Logout</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
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
    </header>
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
    <!--la barre de home_about diabete-->
    <div class="breadcrumb-container"></div>
    <div class="breadcrumb">
        <a href="Home.php">Home</a> &gt; <a href="diabete.php">About Diabetes</a>&gt;<span>Complications</span>
    </div>
    <!--Div de titre aboute diabete et l'image-->
    <section class="hero-section">
        <div class="text-p">
            <h5>ABOUT DIABETES</h5>
            <h1>Diabetes Complications</h1>
            <p>What you need to know about diabetes complications.</p>

        </div>

        <div class="image-container">
            <img src="complications1.jpg" alt="Woman drink water">
        </div>
    </section>
    <!--logos de facebook....-->
    <div class="section1">


        <section class="share-section">
            <p class="share-text">Share this page</p>

            <!-- Facebook Share -->
            <a href="javascript:void(0);" onclick="partagerFacebookSimple()" class="icon" aria-label="Partager sur Facebook">
                <i class="fa-brands fa-facebook-f"></i>
            </a>

            <!-- Twitter Share -->
            <a href="javascript:void(0);" onclick="partagerTwitter()" class="icon" aria-label="Partager sur Twitter">
                <i class="fa-brands fa-twitter"></i>
            </a>

            <!-- LinkedIn Share -->
            <a href="javascript:void(0);" onclick="partagerLinkedIn()" class="icon" aria-label="Partager sur LinkedIn">
                <i class="fab fa-linkedin"></i>
            </a>

            <!-- Copy Link -->
            <a href="#" onclick="copierLien()" class="icon" aria-label="Copier le lien">
                <i class="fas fa-link"></i>
            </a>

            <!-- Print Page -->
            <a href="javascript:window.print()" class="icon" aria-label="Imprimer la page">
                <i class="fas fa-print"></i>
            </a>
        </section>



        <!-- Share Scripts -->
        <script>
            // Function to share on Facebook
            function partagerFacebookSimple() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/Complications.php"); // Fixed URL for the complications page
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
            }

            // Function to share on Twitter
            function partagerTwitter() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/Complications.php");
                const text = encodeURIComponent("Chouf had l-page!");
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
            }

            // Function to share on LinkedIn
            function partagerLinkedIn() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/Complications.php");
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
            }

            // Function to copy the link to clipboard
            function copierLien() {
                navigator.clipboard.writeText("https://sissou-a11y.github.io/diabete-website/Complications.php")
                    .then(() => alert("Lien copié!"));
            }
        </script>
        <!--what is diabetes-->
        <div class="text-section">
            <h2 class="font">People living with diabetes have an increased risk of developing diabetes complications. The most common are those that affect the heart, blood vessels, eyes, kidneys, nerves, teeth and gums. </h2>
            <p>In high-income countries, diabetes is a leading cause of <strong>cardiovascular disease, blindness, kidney failure </strong> and<strong>lower limb amputation.</strong>Managing blood glucose, blood pressure and cholesterol levels can delay or prevent complications. Regular monitoring of these signs is therefore essential for people with diabetes.</p>
        </div>


    </div>
    <div class="image-cont">
        <img class="responsive-image" src="complication.jpg" alt="women's baby">
    </div>

    <section class="management-section">


        <h2>Diabetes Complications Explained</h2>
        <p>Diabetes increases your risk for many serious health problems. The good news? With the correct treatment and recommended lifestyle changes, many people with diabetes are able to prevent or delay the onset of complications.</p>
    </section>
    <!--types-complication-->

    <div class="container-complications">

        <div class="complication-grid">

            <div class="complication">
                <i class="fas fa-heartbeat"></i>
                <h2>Maladies cardiovasculaires</h2>
                <p>Le diabète augmente le risque de crises cardiaques et d'AVC en favorisant l'accumulation de plaques dans les artères.</p>
            </div>

            <div class="complication">
                <i class="fas fa-eye"></i>
                <h2>Rétinopathie diabétique</h2>
                <p>Une glycémie élevée endommage les vaisseaux sanguins de la rétine, pouvant entraîner une perte de vision.</p>
            </div>

            <div class="complication">
                <i class="fas fa-procedures"></i>
                <h2>Maladie rénale</h2>
                <p>Les reins peuvent être endommagés par l'hyperglycémie, ce qui peut entraîner une insuffisance rénale sévère.</p>
            </div>

            <div class="complication">
                <i class="fas fa-brain"></i>
                <h2>Neuropathie diabétique</h2>
                <p>Le diabète peut causer des douleurs et une perte de sensation, surtout dans les pieds et les mains.</p>
            </div>

            <div class="complication">
                <i class="fas fa-tooth"></i>
                <h2>Complications bucco-dentaires</h2>
                <p>Les diabétiques ont un risque accru d’infections des gencives et de perte de dents.</p>
            </div>

            <div class="complication">
                <i class="fas fa-shield-virus"></i>
                <h2>Affaiblissement immunitaire</h2>
                <p>Les infections sont plus fréquentes en raison d’un système immunitaire affaibli par le diabète.</p>
            </div>

        </div>
    </div>

    <!--More about diabetes-->
    <div>
        <h2 class="h2-more">More about diabetes</h2>
        <div class="container2">

            <!-- Formes rares de diabète -->
            <a href="type3.php">
                <div class="card">
                    <img src=" DiabetesType3.jpg" alt="Formes rares de diabète">
                    <div class="card-content diabetes">
                        <span>Diabetes Gestational</span>
                        <span class="arrow">➜</span>
                    </div>
                </div>
            </a>

            <!-- Complications -->
            <a href="type1.php">
                <div class="card">
                    <img src="type1-d.jpg" alt="Complications">
                    <div class="card-content complications">
                        <span>DiabetesType1</span>
                        <span class="arrow">➜</span>
                    </div>
                </div>
            </a>

            <!-- Prévention du diabète -->
            <a href="type2.php">
                <div class="card">
                    <img src="DiabetesType2.jpg" alt="Prévention du diabète">
                    <div class="card-content prevention">
                        <span>DiabetesType2</span>
                        <span class="arrow">➜</span>
                    </div>
                </div>
            </a>
        </div>
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