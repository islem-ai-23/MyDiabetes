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
    <title>Gestational Diabetes</title>
    <link rel="stylesheet" href="type3.css">
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
        <a href="Home.php">Home</a> &gt; <a href="diabete.php">about Diabetes</a> &gt; <span>Gestational diabetes</span>
    </div>



    <!--Div de titre aboute diabete et l'image-->
    <section class="hero-section">
        <div class="text-container">
            <h1>Gestational Diabetes</h1>

        </div>
        <div class="image-container">
            <img src="Gestational.jpg" alt="image-type">
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

        <script>
            // Fonction pour partager sur Facebook (méthode simplifiée)
            function partagerFacebookSimple() {
                const url = "https://sissou-a11y.github.io/diabete-website/type3.php"; // Lien fixe de la page
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank'); // Ouvrir le lien de partage dans une nouvelle fenêtre
            }

            // Partager sur Twitter
            function partagerTwitter() {
                const url = "https://sissou-a11y.github.io/diabete-website/type3.php"; // Lien fixe de la page
                const text = encodeURIComponent("Chouf had l-page!");
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
            }

            // Partager sur LinkedIn
            function partagerLinkedIn() {
                const url = "https://sissou-a11y.github.io/diabete-website/type3.php"; // Lien fixe de la page
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
            }

            // Copier le lien
            function copierLien() {
                const url = "https://sissou-a11y.github.io/diabete-website/type3.php"; // Lien fixe de la page
                navigator.clipboard.writeText(url)
                    .then(() => alert("Lien copié!"));
            }
        </script>




        <!--what is diabetes-->
        <div class="text-section">
            <h2 class="font"><strong class="font">It can be a scary diagnosis, but it’s one that’s fairly common! Gestational diabetes (GDM)—diabetes during pregnancy—affects up to 9% of pregnancies in the U.S. each year, so know you're not alone. If you are diagnosed, this doesn't mean you had diabetes before pregnancy nor does it mean you'll have it after giving birth. The key is to act swiftly, remain consistent, and stay on top of your condition. GDM is treatable, manageable, and something you can effectively manage. With your health care provider's support, you can have a healthy pregnancy and baby. </strong></h2>


        </div>
    </div>
    <div class="image-cont">
        <img class="responsive-image" src="gestionel.jpg" alt="women's baby">
    </div>

    <div class="container-gestationel">
        <section class="section-gestationel">
            <h1>What We Know About GDM</h1>
            <p>The exact cause of GDM is unclear and there’s a lot we don’t know. But—we do know that the placenta's hormones,
                which support the baby's growth, can sometimes block the mother’s insulin, leading to insulin resistance.
                This makes it harder for the body to use insulin effectively, requiring the mother to produce more.
                If the body can't produce enough insulin during pregnancy, glucose remains in the blood, leading to high blood glucose (blood sugar).</p>
            <p>No matter the cause, you can work with your health care provider to create a plan that ensures a healthy pregnancy.
                Don't hesitate to ask questions or seek support—there are many effective ways to manage GDM.</p>



            <h1>Protecting You and Your Baby</h1>
            <p>Take these steps to keep you and your baby healthy:</p>
            <ul>
                <li><strong>Get screened:</strong> Early treatment helps prevent health issues for both you and your baby.
                    The key is to act quickly so you can start managing it right away.</li>
                <li><strong>Make a treatment plan:</strong> Early treatment helps prevent health issues for both you and your baby.
                    Work with your health care team to develop a treatment plan.</li>
            </ul>
        </section>

    </div>

    <div class="symptoms">
        <div class="image-symptoms">
            <img src="gestationel1.jpg" alt="People walking">
        </div>
        <div class="text-symptoms">
            <h2>GDM Treatment</h2>

            <p>Taking quick action is essential. While GDM is treatable, it can pose health risks to both you and your baby if left unmanaged. The primary goal of treatment is to keep your blood glucose levels within a normal range. This may involve special meal plans, regular physical activity, daily blood glucose testing, and insulin injections. Remember, with the right approach and the support of your health care team, you can ensure a healthy pregnancy. </p>
        </div>
    </div>

    <div class="symptoms">
        <div class="text-symptoms">
            <h2>Healthy Eating Is Key to Success</h2>

            <p>As with all forms of diabetes, diet is a crucial management tool. Your health care provider can help you develop a personalized meal plan that will guide you toward the best food choices and easy meal ideas that keep you healthy and strong throughout your pregnancy.</p>
            <p>An easy way to start your healthy eating journey is by taking a test to assess your dietary habits and nutritional needs.</p>
            <a href="lien-du-test">
              
            </a>
        </div>

        <div class="image-symptoms">
            <img src="gestationel2.jpg" alt="People walking">
        </div>

    </div>


    <div class="symptoms">
        <div class="image-symptoms">
            <img src="gestationel3.jpg" alt="People walking">
        </div>
        <div class="text-symptoms">
            <h2>Move More to Manage </h2>

            <p>Exercise plays a vital role in managing GDM. Collaborate with your health care provider to determine the safest level of activity for you and your baby during pregnancy. Start slow and make the movement more fun by bringing your partner, friend, or family member along with you!</p>
        </div>
    </div>


    <!--More about diabetes-->
    <div>
        <h2 class="h2-more">More about diabetes</h2>
        <div class="container2">

            <!-- Formes rares de diabète -->
            <a href="type1.php">
                <div class="card">
                    <img src="DiabetesType2.jpg" alt="Formes rares de diabète">
                    <div class="card-content diabetes">
                        <span>DiabetesType2</span>
                        <span class="arrow">➜</span>
                    </div>
                </div>
            </a>

            <!-- Complications -->
            <a href="type2.php">
                <div class="card">
                    <img src="type1-d.jpg" alt="Complications">
                    <div class="card-content complications">
                        <span>DiabetesType1</span>
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