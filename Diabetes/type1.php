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
    <title>DiabetesType1</title>
    <link rel="stylesheet" href="type1.css">
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
        <a href="Home.php">Home</a> &gt; <a href="diabete.php">about Diabetes</a> &gt; <span>Type1 diabetes</span>
    </div>



    <!--Div de titre aboute diabete et l'image-->
    <section class="hero-section">
        <div class="text-container">
            <h1>Type 1 diabetes</h1>
        </div>
        <div class="image-container">
            <img src="d.jpg" alt="image-type">
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
            // Fonction pour partager sur Facebook
            function partagerFacebookSimple() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/type1.php"); // URL fixée pour la page Type 1
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
            }

            // Fonction pour partager sur Twitter
            function partagerTwitter() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/type1.php");
                const text = encodeURIComponent("Learn about Type 1 Diabetes!");
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
            }

            // Fonction pour partager sur LinkedIn
            function partagerLinkedIn() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/type1.php");
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
            }

            // Fonction pour copier le lien
            function copierLien() {
                navigator.clipboard.writeText("https://sissou-a11y.github.io/diabete-website/type1.php")
                    .then(() => alert("Lien copié!"));
            }
        </script>




        <!--what is diabetes-->
        <div class="text-section">
            <h2 class="font"><strong class="font">When you have type 1 diabetes, your immune system mistakenly treats the beta cells in your pancreas that create insulin as foreign invaders and destroys them. When enough beta cells are destroyed, your pancreas can’t make insulin or makes so little of it that you need to take insulin to live. </strong></h2>
            <p>In 2025, the total number of people living with type 1 diabetes is estimated to be around 10.5 million. Applying the 17% proportion of individuals under the age of 20 observed in 2021, this would represent approximately 1.8 million young people under 20 living with type 1 diabetes in 2025.</p>
            <p>These estimates are based on current trends and may vary depending on various factors, including medical advances and environmental changes.</p>
        </div>
    </div>



    <!--symptoms diabetes-->
    <div class="symptoms">
        <div class="image-symptoms">
            <img src="DiabeticChild509x358.png" alt="People walking">
        </div>
        <div class="text-symptoms">
            <h2>Symptoms of type 1 diabetes</h2>
            <p>The most common symptoms of type 1 diabetes include:</p>
            <ul>
                <li>Abnormal thirst and dry mouth</li>
                <li>Sudden weight loss</li>
                <li>Frequent urination</li>
                <li>Lack of energy, tiredness</li>
                <li>Constant hunger</li>
                <li>Blurred vision</li>
                <li>Bedwetting</li>
            </ul>
            <p>Diagnosing type 1 diabetes can be difficult, so additional tests may be required to confirm a diagnosis.</p>
        </div>
    </div>
    <div class="video-section">
        <div class="video-container">
            <iframe
                src="https://www.youtube.com/embed/C3AQIfgthh4"
                title="Understanding A1C: Normal Range And Diabetes Management Explained"
                frameborder="0"
                allowfullscreen>
            </iframe>
        </div>
    </div>




    <!--tritement of diabetes -->
    <section class="management-section">

        <h2>Treatment of type 1 diabetes</h2>
        <p>People with type 1 diabetes require daily insulin treatment, regular blood glucose monitoring and a healthy lifestyle to manage their condition effectively.</p>

        <h3>1. Insulin Therapy</h3>
        <p>People with type 1 diabetes must take <strong>insulin daily</strong> since their body no longer produces it. Insulin can be administered through <strong>injections</strong> or an <strong>insulin pump</strong> to help regulate blood sugar levels.</p>

        <h3>2. Blood Sugar Monitoring</h3>
        <p>Regular blood glucose monitoring is essential to prevent complications. Many people use <strong>continuous glucose monitors (CGMs)</strong> or traditional <strong>fingerstick tests</strong> to track their levels.</p>

        <h3>3. Technology and Support</h3>
        <p>Advancements like <strong>insulin pumps</strong> and <strong>CGMs</strong> have made diabetes management easier. Additionally, <strong>support from healthcare professionals, family, and diabetes communities</strong> plays a key role in long-term well-being.</p>

        <div class="image-cont">
            <img src="insuline .jpg" alt="People staying active outdoors" class="responsive-image">
        </div>
        <h3>4. Physical Activity</h3>
        <p>Exercise helps improve insulin sensitivity and overall health. However, people with type 1 diabetes must <strong>adjust insulin doses and monitor blood sugar</strong> to avoid hypoglycemia during physical activity</p>

        <h3>Effects of Exercise on Blood Sugar</h3>
        <ul>
            <li><strong>Aerobic Exercise (e.g., running, cycling):</strong> Can lower blood sugar, requiring insulin and carbohydrate adjustments.</li>
            <li><strong>Anaerobic Exercise (e.g., weightlifting, sprinting):</strong> May raise blood sugar due to adrenaline release.</li>
        </ul>

        <p>With proper management, exercise benefits overall diabetes control and health.</p>
        <div class="image-cont">
            <img src="insuline2.jpg" alt="People staying active outdoors" class="responsive-image">
        </div>
        <h3>3. Healthy Eating</h3>
        <p>A well-balanced diet helps keep blood sugar stable. It's important to <strong>monitor carbohydrate intake</strong> and eat <strong>nutrient-rich foods</strong> to maintain energy levels. If you follow a healthy diet, it is essential to choose whole, unprocessed foods and maintain consistency in meal timing to avoid blood sugar fluctuations.</p>

        <p>To find the best healthy diet for you, click the button below and take our test:</p>
        <a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>" >
            <button class="btn-insuline">
                Take the Test
            </button>
        </a>
    </section>




    <!--More about diabetes-->
    <div>
        <h2 class="h2-more">More about diabetes</h2>
        <div class="container2">



            <!-- Formes rares de diabète -->
            <a href="type2.php">
                <div class="card">
                    <img src="DiabetesType2.jpg" alt="Formes rares de diabète">
                    <div class="card-content diabetes">
                        <span>DiabetesType2</span>
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
            <a href="type3.php">
                <div class="card">
                    <img src="DiabetesType3.jpg" alt="Prévention du diabète">
                    <div class="card-content prevention">
                        <span>Diabetes Gestational</span>
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