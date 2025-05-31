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
    <title>DiabetesType2</title>
    <link rel="stylesheet" href="type2.css">
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
        <a href="Home.php">Home</a> &gt; <a href="diabete.php">about Diabetes</a> &gt; <span>Type2 diabetes</span>
    </div>
    <!--Div de titre aboute diabete et l'image-->
    <section class="hero-section">
        <div class="text-container">
            <h1>Type 2 diabetes</h1>
        </div>
        <div class="image-container">
            <img src="diabete-femme-age-mur-test.avif" alt="image-type">
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
            // Fonction pour partager sur Facebook
            function partagerFacebookSimple() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/type2.php"); // URL fixée pour la page de type2
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
            }

            // Fonction pour partager sur Twitter
            function partagerTwitter() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/type2.php");
                const text = encodeURIComponent("Learn about Type 2 Diabetes!");
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
            }

            // Fonction pour partager sur LinkedIn
            function partagerLinkedIn() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/type2.php");
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
            }

            // Fonction pour copier le lien
            function copierLien() {
                navigator.clipboard.writeText("https://sissou-a11y.github.io/diabete-website/type2.php")
                    .then(() => alert("Lien copié!"));
            }
        </script>

        <!--what is diabetes-->
        <div class="text-section">
            <h2 class="font"><strong class="font">The primary indicator of type 2 diabetes is insulin resistance, when the body cannot fully respond to insulin. In many cases, the condition can be delayed or prevented.. </strong></h2>
            <p>At first, your beta cells make extra insulin to make up for it. Over time, your pancreas can’t make enough insulin to keep your blood glucose at normal levels. Type 2 diabetes develops most often in middle-aged and older adults but is increasing in young people.
            </p>
            <p>Treatment for people with type 2 diabetes will include healthy eating and exercise. However, your health care provider may need to also prescribe oral and injectable medications (including insulin) to help you meet your target blood glucose levels.</p>
        </div>
    </div>
    <!--les photos et information de type2-->

    <div class="container-type2">
        <div class="text-section-type2">
            <h1>Symptoms of Type 2 Diabetes</h1>
            <p>The symptoms of type 2 diabetes are similar to those for type 1 diabetes and include:</p>
            <ul>
                <li>Excessive thirst and dry mouth</li>
                <li>Frequent urination</li>
                <li>Lack of energy, tiredness</li>
                <li>Slow healing wounds</li>
                <li>Recurrent infections in the skin</li>
                <li>Blurred vision</li>
                <li>Tingling or numbness in hands and feet</li>
            </ul>
            <p>These symptoms can be mild or absent, so people with type 2 diabetes can live several years with the condition before being diagnosed.</p>
        </div>

        <div class="image-section-type2">
            <img src="symptoms-type2.jpg" alt="Person with glucose monitor">
        </div>
    </div>

    <!--factors de type2-->
    <div class="container-type2">
        <div class="image-section-type22">
            <img src="type2-factor.jpg" alt="Facteurs de risque du diabète">
        </div>
        <div class="text-section-type22">
            <h1>Facteurs de risque du diabète</h1>
            <p>Certains facteurs augmentent le risque de développer un diabète de type 2. Voici les principaux :</p>
            <ul>
                <li><strong>Antécédents familiaux :</strong> Avoir un parent ou un proche atteint de diabète.</li>
                <li><strong>Surpoids et obésité :</strong> L'excès de poids est un facteur majeur du diabète de type 2.</li>
                <li><strong>Mode de vie sédentaire :</strong> Manque d'exercice et inactivité physique.</li>
                <li><strong>Mauvaise alimentation :</strong> Consommation excessive de sucre et de graisses saturées.</li>
                <li><strong>Hypertension artérielle :</strong> Pression artérielle élevée associée à un risque accru.</li>
                <li><strong>Âge avancé :</strong> Le risque augmente après 45 ans.</li>
                <li><strong>Stress chronique :</strong> Peut influencer la glycémie et l'insuline.</li>
            </ul>
        </div>

    </div>
    <!--traitement-->

    <div class="container-type23">
        <div class="text-section-type23">
            <h1>Treatment of type 2 diabetes</h1>
            <h2>A Healthy Lifestyle… The Solution!</h2>
            <p>The primary treatment for type 2 diabetes is based on lifestyle changes, emphasizing a
                <a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>"  class="highlight-link">balanced diet</a> and regular physical activity.
            </p>
            <p>These habits help regulate blood sugar levels and promote weight loss.</p>

            <h2>Medication Treatments</h2>
            <p>Various medical strategies aim to restore insulin sensitivity and regulate blood sugar levels. The first-line treatment consists of oral antidiabetic drugs, including:</p>
            <ul>
                <li><strong>Biguanides:</strong> Metformin</li>
                <li><strong>Sulfonylureas:</strong> Glipizide, Gliclazide, Glibenclamide</li>
                <li><strong>Glinides:</strong> Repaglinide</li>
                <li><strong>Alpha-glucosidase inhibitors:</strong> Acarbose</li>
                <li><strong>DPP-4 inhibitors (Incretin enhancers):</strong> Sitagliptin, Vildagliptin</li>
            </ul>

            <h2>Insulin Therapy</h2>
            <p>In some cases, insulin therapy becomes necessary. Different types of insulin treatments are available:</p>
            <ul>
                <li>Rapid-acting insulin analogs</li>
                <li>Short-acting human insulin</li>
                <li>Intermediate-acting human insulin</li>
                <li>Long-acting human insulin</li>
                <li>Long-acting insulin analogs</li>
            </ul>


        </div>
        <div class="image-section-type23">
            <img src="sweet-life-4eacZiKDZvA-unsplash.jpg" alt="Person managing diabetes">
        </div>
    </div>


    <!--More about diabetes-->
    <div>
        <h2 class="h2-more">More about diabetes</h2>
        <div class="container2">

            <!-- Formes rares de diabète -->
            <a href="prevention.php">
                <div class="card">
                    <img src="prevention1.jpg" alt="Formes rares de diabète">
                    <div class="card-content diabetes">
                        <span>Diabetes prevention</span>
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
            <a href="type3.php">
                <div class="card">
                    <img src="DiabetesType3.jpg" alt="Prévention du diabète">
                    <div class="card-content prevention">
                        <span>Diabetes gestational</span>
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