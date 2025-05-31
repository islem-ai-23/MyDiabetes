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
    <link rel="stylesheet" href="warning.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>warning signs</title>
</head>

<body>
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

    <div class="breadcrumb">
        <a href="Home.php">Home</a> &gt; <a href="diabete.php">About Diabetes</a> &gt; <span>Warning Signs and Symptoms</span>
    </div>
    <section class="hero-section">
        <div class="text-p">
            <h5>ABOUT DIABETES</h5>
            <h1>Warning Signs and Symptoms</h1>
            <p>Know the warning signs and symptoms of diabetes and diabetes complications so you can take action to improve your health</p>

        </div>

        <div class="image-container">
            <img src="warnings.jpg" alt="Woman drink water">
        </div>
    </section>
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

        <script>
            // Fonction pour partager sur Facebook (méthode simplifiée)
            function partagerFacebookSimple() {
                const url = "https://sissou-a11y.github.io/diabete-website/warning-signs.php"; // Lien fixe de la page
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank'); // Ouvrir le lien de partage dans une nouvelle fenêtre
            }

            // Partager sur Twitter
            function partagerTwitter() {
                const url = "https://sissou-a11y.github.io/diabete-website/warning-signs.php"; // Lien fixe de la page
                const text = encodeURIComponent("Chouf had l-page!");
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
            }

            // Partager sur LinkedIn
            function partagerLinkedIn() {
                const url = "https://sissou-a11y.github.io/diabete-website/warning-signs.php"; // Lien fixe de la page
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
            }

            // Copier le lien
            function copierLien() {
                const url = "https://sissou-a11y.github.io/diabete-website/warning-signs.php"; // Lien fixe de la page
                navigator.clipboard.writeText(url)
                    .then(() => alert("Lien copié!"));
            }
        </script>



        <div class="text-section">

            <p class="bold">The following symptoms of diabetes are typical. However, some people with diabetes have symptoms so mild that they go unnoticed.</p>

            <h3>Common symptoms of diabetes:</h3>
            <ul>
                <li>Urinating often</li>
                <li>Feeling very thirsty</li>
                <li>Feeling very hungry—even though you are eating</li>
                <li>Extreme fatigue</li>
                <li>Blurry vision</li>
                <li>Cuts/bruises that are slow to heal</li>
                <li>Weight loss—even though you are eating more (type 1)</li>
                <li>Tingling, pain, or numbness in the hands/feet (type 2)</li>
            </ul>
            <p style="color: #333;">arly detection and treatment of diabetes can decrease the risk of developing the <a href="Complications.php">complications of diabetes.</a></p>

        </div>
    </div>
    <div class="text-image">
        <div class="text-p1">
            <h5>ABOUT DIABETES</h5>
            <h2>Type 1 & 2 Symptoms</h2>
            <p>For some, symptoms are noticeable, and for others, they’re so mild they go unnoticed. Either way, learn what to look out for to reduce your risk of complications.</p>
            <div class="button11">
                <a href="type1.php" class="button1">Type 1 Symptoms</a>
                <a href="type2.php" class="button1">Type 2 Symptoms</a>
            </div>

        </div>
        <div class="image2">
            <img src="warning1.jpg" alt="homme-l'eau">
        </div>
    </div>




    <div class="video-section">
        <div class="video-container" onclick="openVideo()">
            <img src="video.jpg" alt="Vidéo Type 1 Diabète" class="video-thumbnail">
            <button class="play-button"></button>
        </div>

        <div class="video-description">
            <h3>About Diabetes</h3>
            <h2>Diagnosing Diabetes</h2>
            <p>Learn about the different ways diabetes is diagnosed. </p>
        </div>
    </div>

    <div class="popup-video" id="popupVideo">
        <span class="close-btn" onclick="closeVideo()">×</span>
        <iframe id="videoIframe" src="" allowfullscreen></iframe>
    </div>

    <script>
        function openVideo() {
            let popup = document.getElementById("popupVideo");
            let iframe = document.getElementById("videoIframe");

            // Définir l'URL de la vidéo YouTube
            iframe.src = "https://www.youtube.com/embed/ExdNvNYoSDw";

            popup.style.display = "flex";
        }

        function closeVideo() {
            let popup = document.getElementById("popupVideo");
            let iframe = document.getElementById("videoIframe");

            popup.style.display = "none";

            // Arrêter la vidéo en supprimant l'URL de l'iframe
            iframe.src = "";
        }
    </script>
    <div class="text-image2">
        <div class="text-p2">
            <h5>ABOUT DIABETES</h5>
            <h2>Personalised Diabetes Diet Test</h2>
            <p>If you are at risk for developing diabetes Find out the best diet plan for your health! Enter your details and get a customized meal plan tailored to your needs in just 60 seconds </p>

            <a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>"  class="button2">Take the Test</a>
        </div>


        <div class="image2">
            <img src="Test.jpg" alt="homme-l'eau">
        </div>
    </div>


    <div>
        <h2 class="h2-more">More about diabetes</h2>
        <div class="container2">

            <!-- Formes rares de diabète -->
            <a href="prevention.php">
                <div class="card">
                    <img src="prevention1.jpg" alt="Formes rares de diabète">
                    <div class="card-content diabetes">
                        <span> Diabetes prevention</span>
                        <span class="arrow">➜</span>
                    </div>
                </div>
            </a>

            <!-- Complications -->
            <a href="Complications.php">
                <div class="card">
                    <img src="complication22.jpg" alt="Complications">
                    <div class="card-content complications">
                        <span> Complications</span>
                        <span class="arrow">➜</span>
                    </div>
                </div>
            </a>

            <!-- Prévention du diabète -->
            <a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>" >
                <div class="card">
                    <img src="Test2.jpg" alt="Prévention du diabète">
                    <div class="card-content prevention">
                        <span> Diabetes Diet Test</span>
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