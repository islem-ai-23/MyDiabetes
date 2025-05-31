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
    <title>About Diabetes</title>
    <link rel="stylesheet" href="style.css">
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
        <a href="Home.php">Home</a> &gt; <span>About Diabetes</span>
    </div>
    <!--Div de titre aboute diabete et l'image-->
    <section class="hero-section">
        <div class="text-container">
            <h1>About diabetes</h1>
        </div>
        <div class="image-container">
            <img src="Capture d’écran 2025-03-05 170431.jpg" alt="Woman checking blood sugar">
        </div>
    </section>
    <!--logos de facebook....-->
    <div class="section1">





        <section class="share-section">
            <p class="share-text">Partager cette page</p>

            <!-- Facebook - Logo avec action de partage -->
            <a href="javascript:void(0);" onclick="partagerFacebookSimple()" class="icon" aria-label="Partager sur Facebook">
                <i class="fa-brands fa-facebook-f"></i> <!-- L'icône de Facebook -->
            </a>

            <!-- Autres réseaux sociaux -->
            <!-- Twitter -->
            <a href="javascript:void(0);" onclick="partagerTwitter()" class="icon" aria-label="Partager sur Twitter">
                <i class="fa-brands fa-twitter"></i>
            </a>

            <!-- LinkedIn -->
            <a href="javascript:void(0);" onclick="partagerLinkedIn()" class="icon" aria-label="Partager sur LinkedIn">
                <i class="fab fa-linkedin"></i>
            </a>

            <!-- Copier le lien -->
            <a href="javascript:void(0);" onclick="copierLien()" class="icon" aria-label="Copier le lien">
                <i class="fas fa-link"></i>
            </a>

            <!-- Imprimer -->
            <a href="javascript:window.print()" class="icon" aria-label="Imprimer la page">
                <i class="fas fa-print"></i>
            </a>
        </section>

        <script>
            // Fonction pour partager sur Facebook (méthode simplifiée)
            function partagerFacebookSimple() {
                const url = "https://sissou-a11y.github.io/diabete-website/"; // Lien fixe de la page
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank'); // Ouvrir le lien de partage dans une nouvelle fenêtre
            }

            // Partager sur Twitter
            function partagerTwitter() {
                const url = "https://sissou-a11y.github.io/diabete-website/"; // Lien fixe de la page
                const text = encodeURIComponent("Chouf had l-page!");
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
            }

            // Partager sur LinkedIn
            function partagerLinkedIn() {
                const url = "https://sissou-a11y.github.io/diabete-website/"; // Lien fixe de la page
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
            }

            // Copier le lien
            function copierLien() {
                const url = "https://sissou-a11y.github.io/diabete-website/"; // Lien fixe de la page
                navigator.clipboard.writeText(url)
                    .then(() => alert("Lien copié!"));
            }
        </script>







        <!--what is diabetes-->
        <div class="text-section">
            <h2 class="font">What is diabetes? <strong class="font">Diabetes is a chronic condition that occurs when the pancreas can no longer make insulin, or the body cannot effectively use insulin.</strong></h2>
            <p>Insulin is <strong>a hormone made by the pancreas</strong> that acts like a key to let glucose from the food we eat pass from the bloodstream into the cells in the body to produce energy. The body breaks down all carbohydrate foods into glucose in the blood, and insulin helps glucose move into the cells.</p>
            <p>When the body cannot produce or use insulin effectively, this leads to high blood glucose levels, called <strong>hyperglycaemia.</strong> Over the long-term high glucose levels are associated with damage to the body and failure of various organs and tissues.</p>
        </div>
    </div>

    <!--les types de diabetes-->
    <section class="diabetes-section">
        <h2>There are 3 main types of diabetes</h2>
        <div class="diabetes-container">
            <div class="diabetes-type">
                <img src="type1.png" alt="Type 1 Icon">
                <h3>Type 1</h3>
                <p>Can develop at any age and requires insulin treatment for survival.</p>
                <a href="type1.php" class="arrow-button">→</a>
            </div>

            <div class="diabetes-type">
                <img src="type2.png" alt="Type 2 Icon" style="width: 300px;">
                <h3>Type 2</h3>
                <p>Accounts for around 90% of all diabetes and is more commonly diagnosed in adults.</p>
                <a href="type2.php" class="arrow-button">→</a>
            </div>

            <div class="diabetes-type">
                <img src="type3.png" alt="Gestational Diabetes Icon" style="width: 170px;">
                <h3>Gestational</h3>
                <p>Occurs with high blood glucose during pregnancy and can cause complications.</p>
                <a href="type3.php" class="arrow-button">→</a>
            </div>
        </div>
    </section>

    <!--Div de warning signe-->
    <div class="text-image">
        <div class="text-p">
            <h5>ABOUT DIABETES</h5>
            <h2>Warning signs</h2>
            <p>Learn to recognize the warning signs of diabetes and how to find out if you have it.</p>
            <a href="warning-signs.php" class="button1">Learn the Symptoms</a>

        </div>
        <div class="image2">
            <img src="image-leau.jpg" alt="homme-l'eau">
        </div>
    </div>

    <!--Video about diagonosing diabetes-->
    <div class="video-section">
        <h2>Here is a video about Understanding A1C</h2>
        <div class="video-container">
            <iframe
                src="https://www.youtube.com/embed/rrOPABi1e1c"
                title="Understanding A1C: Normal Range And Diabetes Management Explained"
                frameborder="0"
                allowfullscreen>
            </iframe>
        </div>
    </div>

    <!--More about diabetes-->
    <div>
        <h2 class="h2-more">More about diabetes</h2>
        <div class="container2">

            <!-- Formes rares de diabète -->
            <a href="warning-signs.php">
                <div class="card">
                    <img src="warning2.jpg" alt="Formes rares de diabète">
                    <div class="card-content diabetes">
                        <span>warning signs</span>
                        <span class="arrow">➜</span>
                    </div>
                </div>
            </a>

            <!-- Complications -->
            <a href="Complications.php">
                <div class="card">
                    <img src="complication22.jpg" alt="Complications">
                    <div class="card-content complications">
                        <span>Complications</span>
                        <span class="arrow">➜</span>
                    </div>
                </div>
            </a>

            <!-- Prévention du diabète -->
            <a href="prevention.php">
                <div class="card">
                    <img src="prevention1.jpg" alt="Prévention du diabète">
                    <div class="card-content prevention">
                        <span>Diabetes prevention</span>
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
                    <li><a href="Test.php">Balanced diet</a></li>
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