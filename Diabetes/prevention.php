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
    <link rel="stylesheet" href="prevention.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>prevention diabetes</title>
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
            <li><a href="FAQ.php">FAQ's</a></li>
            <li><a href="Contacte.php">Contact</a></li>
        </ul>
    </nav>

    <div class="breadcrumb">
        <a href="Home.php">Home</a> &gt; <a href="diabete.php">About Diabetes</a> &gt; <span>Warning Signs and Symptoms</span>
    </div>
    <section class="hero-section">
        <div class="text-p">
            <h5>Diabetes Prevention</h5>
            <h1>Get smart about risks and diabetes prevention.</h1>
            <p>With early detection and awareness, you can take steps to prevent or delay the onset of type 2 diabetes.</p>

        </div>

        <div class="image-container">
            <img src="prevention-diabetes1.jpg" alt="Woman drink water">
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
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/prevention.php"); // URL fixée pour la page de prévention
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
            }

            // Fonction pour partager sur Twitter
            function partagerTwitter() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/prevention.php");
                const text = encodeURIComponent("Check out this page on Diabetes Prevention!");
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
            }

            // Fonction pour partager sur LinkedIn
            function partagerLinkedIn() {
                const url = encodeURIComponent("https://sissou-a11y.github.io/diabete-website/prevention.php");
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
            }

            // Fonction pour copier le lien
            function copierLien() {
                navigator.clipboard.writeText("https://sissou-a11y.github.io/diabete-website/prevention.php")
                    .then(() => alert("Lien copié!"));
            }
        </script>










        <!--what is diabetes-->
        <div class="text-section">
            <h2 class="font">Le diabète de type 1 ne peut être évité, mais des recherches sont en cours pour déterminer les facteurs environnementaux qui le déclenchent. Si le diabète de type 1 ne peut être évité, plusieurs mesures peuvent être prises pour réduire le risque de développer un diabète de type 2.</h2>
            <p>Les mauvaises habitudes alimentaires et les modes de vie sédentaires associés à l'urbanisation sont des facteurs communs qui contribuent au développement du diabète de type 2. Des études menées aux <strong>États-Unis </strong>, en <strong>Finlande</strong>, en <strong>Chine</strong>, en<strong> Inde </strong>, et en <strong>Japon </strong>ont démontré de manière irréfutable que des changements de mode de vie (atteinte d'un poids corporel sain et <strong>activité physique </strong>modérée) peuvent contribuer à prévenir le développement du diabète de type 2 chez les personnes à haut risque.</p>
        </div>
    </div>

    <div class="image-cont">
        <img class="responsive-image" src="prevention-diabetes.jpg" alt="women's baby">
    </div>

    <div class="container-gestationel">
        <section class="section-gestationel">
            <h1>Small changes lead to big results</h1>
            <p>Small changes to your lifestyle can help to prevent or delay diabetes, even if you’ve been diagnosed with prediabetes. Your doctor will help you create a plan and set goals that work for you. They may also refer you to a Centers for Disease Control and Prevention (CDC) recognized, evidence-based lifestyle change program. Don’t hesitate to ask for help along your journey.</p>

        </section>

    </div>

    <div class="symptoms">
        <div class="image-symptoms">
            <img src="depressed-overweight-woman-bed-home-99707336.jpg" alt="People walking">
        </div>
        <div class="text-symptoms">
            <h2>Overweight? Know the impact</h2>
            <p>Overweight and obesity are major risk factors for type 2 diabetes. In fact, excess body fat, especially around the abdomen, can increase insulin resistance, a condition where the body’s cells don’t respond properly to insulin, leading to high blood sugar levels.</p>
            <h3>What to Do?</h3>
            <ul>
                <li>Adopt a balanced diet</li>
                <li>Avoid foods high in saturated fats</li>
                <li>Avoid added sugars</li>
                <li>Exercise regularly</li>
                <li>Monitor your weight</li>

            </ul>
            <p>Diagnosing type 1 diabetes can be difficult, so additional tests may be required to confirm a diagnosis.</p>
        </div>
    </div>

    <div class="symptoms">
        <div class="text-symptoms">
            <h2>Adopt a Balanced Diet</h2>

            <p>A healthy diet plays a key role in controlling blood sugar and preventing diabetes. Foods rich in fiber, such as vegetables, fruits, and whole grains, help slow the absorption of glucose into the bloodstream. A balanced diet also helps maintain a healthy weight and reduces inflammation, a contributing factor to type 2 diabetes.</p>
            <p>An easy way to start your healthy eating journey is by taking a test to assess your dietary habits and nutritional needs.</p>
            <a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>" >
                <button class="btn-insuline">
                    Take the Test
                </button>
            </a>
        </div>

        <div class="image-symptoms">
            <img src="Fat.jpg" alt="People walking">
        </div>

    </div>

    <div class="symptoms">
        <div class="image-symptoms">
            <img src="sport.jpg" alt="People walking">
        </div>
        <div class="text-symptoms">

            <h2> Exercise Regularly</h2>
            <h3>Why it's important:</h3>
            <p>Physical exercise helps reduce blood sugar by enabling muscles to use glucose as an energy source. It also improves insulin sensitivity, meaning insulin is used more efficiently by the body. Furthermore, exercise helps control weight and reduces the risk of heart diseases, which are common among people with diabetes.</p>
            <h3>What to Do?</h3>

            <p>Aim for at least 30 minutes of moderate exercise every day, such as brisk walking, cycling, swimming, or aerobics. If you can't do 30 minutes at once, try breaking it into several 10-15 minute sessions throughout the day. The important thing is to stay active regularly.</p>
        </div>
    </div>

    <section class="management-section">

        <h1>More Vitality: Adopt Healthy Habits Every Day</h1>
        <h2>Avoid Smoking</h2>
        <p>Smoking is a major risk factor for many diseases, including type 2 diabetes. Smoking increases insulin resistance and impairs blood circulation, which can worsen diabetes management. Additionally, smokers are more likely to suffer from diabetes-related complications such as heart disease and kidney problems.</p>
        <h3>what to do:</h3>
        <p>If you smoke, it's essential to quit. Seek medical support to help you quit, such as nicotine substitutes, behavioral therapies, or prescribed medications. By quitting smoking, you reduce not only your risk of diabetes but also your risk of many other serious diseases.</p>
        <br>
        <h2> Monitor Your Blood Sugar Levels</h2>
        <p>People with high blood sugar levels, also known as hyperglycemia, are more likely to develop type 2 diabetes. Regular monitoring of your blood sugar helps detect abnormalities early and allows you to take necessary measures to prevent the onset of the disease.</p>
        <h3>what to do ?</h3>
        <p>Have your blood sugar checked regularly by your doctor, especially if you have risk factors such as a family history of diabetes. If you're overweight, over 45 years old, or already have high blood sugar (pre-diabetes), it's crucial to track your blood sugar and consult a doctor for regular testing.</p>

    </section>



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
            <a href="Complications.php">
                <div class="card">
                    <img src="complication2.jpg" alt="Prévention du diabète">
                    <div class="card-content prevention">
                        <span>Complications</span>
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