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
    <title>FAQ's</title>
    <link rel="stylesheet" href="FAQ1.css">
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
        <a href="Home.php">Home</a> &gt; <span>FAQ's</span>
    </div>

    <!--Div de titre aboute diabete et l'image-->
    <section class="hero-section">
        <div class="text-container">
            <h1>Frequently Asked Questions</h1>
        </div>
        <div class="image-container">
            <img src="FAQ.jpg" alt="Woman checking blood sugar">
        </div>
    </section>

    <!--logos de facebook....-->
    <div class="section1">


        <section class="share-section">
            <p class="share-text">Share this page</p>


            <a href="https://www.facebook.com" target="_blank" class="icon">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com" target="_blank" class="icon">
                <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="https://www.linkedin.com" target="_blank" class="icon">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="#" class="icon">
                <i class="fas fa-link"></i>
            </a>
            <a href="javascript:window.print()" class="icon">
                <i class="fas fa-print"></i>
            </a>

        </section>
        <div class="question-faq">
            <h1>Do you have any questions?</h1>
            <p>Please read the questions below, which focus on sugar. They cover various aspects, including its effects on health, different types of sugar, and alternatives. Take your time to review them carefully :</p>
        </div>


    </div>
    <div class="faq-container">

        <div class="faq">
            <button class="accordion">What is type 2 diabetes? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>Type 2 diabetes is characterized by two phenomena: the body’s resistance to insulin and a decrease in insulin production. Treatment involves lifestyle changes, sometimes in combination with medication.</p>
                <a href="type2.php" target="_blank" class="more-link">En savoir plus...</a>
            </div>
        </div>

        <div class="faq">
            <button class="accordion">What is type 1 diabetes? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>Type 1 diabetes is a disease caused when the body’s immune system destroys the beta cells in the pancreas. Nothing can prevent the disease. Insulin is the only treatment for type 1 diabetes.</p>
                <a href="type1.php" target="_blank" class="more-link">En savoir plus...</a>
            </div>
        </div>

        <div class="faq">
            <button class="accordion">What are the symptoms of diabetes? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>The most common symptoms include intense thirst, dry mouth, fatigue, and frequent and abundant urination.</p>
                <a href="warning-signs.php" target="_blank" class="more-link">En savoir plus</a>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">What is the difference between type 1 and type 2 diabetes? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>No, prediabetes can be reversed with healthy lifestyle changes, but without intervention, it may lead to type 2 diabetes.</p>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">What foods are prohibited when you have diabetes? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>People with diabetes should limit sugary foods, refined carbs, and fried foods while focusing on balanced, fiber-rich meals.</p>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">What to do when you have hypoglycemia? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>Mild hypoglycemia should be treated with 15 grams of fast-absorbing sugar.</p>
            </div>
        </div>

        <div class="faq">
            <button class="accordion">What to do when you have hyperglycemia? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>For people with type 1 diabetes, it is possible to administer a corrective dose of insulin, also called a corrective bolus, if instructed to do so by their care team.</p>
                <p>For people with type 2 diabetes, there are several strategies available.</p>

            </div>
        </div>
        <div class="faq">
            <button class="accordion">Can type 2 diabetes be cured? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>No. It is possible to put type 2 diabetes into remission, but it requires major lifestyle changes supervised by a team of health professionals. There are criteria to determine which individuals may be able to put their diabetes into remission. </p>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">Are sugar substitutes good alternatives to white sugar? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>Yes, sugar substitutes can be good alternatives to white sugar, as they offer fewer calories and can help with blood sugar control, but it’s important to use them in moderation and choose the right type based on individual health needs.</p>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">How do I get the tax credit? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>Federal and provincial tax credits have been automatically given to people with type 1 diabetes since 2021, since diabetes management is considered to require at least 14 hours of care per week. However, to obtain these tax credits, you must fill out the forms and have them signed by your doctor.</p>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">What diabetes treatments are covered in Quebec by the RAMQ? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>In Quebec, the RAMQ (Régie de l'assurance maladie du Québec) covers several diabetes treatments, including insulin, oral medications, blood glucose test strips, and certain devices like glucose meters. Coverage may also extend to diabetes education and nutrition counseling. However, specific details may vary, so it’s best to check directly with RAMQ or consult a healthcare provider for up-to-date information.</p>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">Where can you donate unused diabetes supplies? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>Diabetes Québec does not collect unused diabetes equipment or supplies.</p>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">Where can I find a foot care nurse? <span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>To find a foot-care nurse, visit the website of <a href="https://aiispq.org/a-propos/bottin-des-membres/" class="ques">the Association des Infirmières et Infirmiers en soins podologiques du Québec.</a></p>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">What is Intermittent Fasting?<span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>Intermittent fasting involves eating only during a specific time of day.</p>
                <p>If you decide to engage in intermittent fasting, talk to your care team. Adjustments to the doses of your medication may be necessary.</p>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">What is the ketogenic diet?<span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>Le régime cétogène est un régime alimentaire riche en graisses, modéré en protéines et très faible en glucides, conçu pour amener le corps à brûler les graisses comme source d'énergie au lieu des glucides.</p>
            </div>
        </div>
        <div class="faq">
            <button class="accordion">Should I take my insulin and medication before a blood test?<span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>When you go to the hospital for a fasting blood test, you should not take your fast-acting or short-acting insulin or your antihyperglycemic medication.</p>
                <p>The first reason you should not do this is that insulin injected while you are fasting will lower your blood sugar and you could end up in a state of hypoglycemia. The second reason is that the results of the blood test, and therefore your blood sugar control, will be distorted and difficult to do since the insulin will have already begun to act when your blood was taken.</p>
                <p>You should book your appointment for as early as possible in the morning and, once your blood test is complete, check your blood sugar and then take your injection or antihyperglycemic medication and eat your lunch. When you inject your insulin, you should eat within minutes of the injection. If you do not do this, you risk becoming hypoglycemic.</p>
            </div>
        </div>

        <div class="faq">
            <button class="accordion">Can I donate blood?<span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>Currently, people with <a href="type1.php" class="ques"> type 1 diabetes</a> are not eligible to donate blood in Québec.</p>
                <p>Héma-Québec is conducting a risk assessment to ensure that donating blood will not negatively impact people with type 1 diabetes.</p>
                <p>For more information, contact <a href="https://www.hemaquebec.ca/en/blood-donation/eligibility-blood/health-status-blood" class="ques">Héma-Québec.</a></p>
                <p>People whose <a href="type2.php" class="ques">type 2 diabetes</a> is properly managed by lifestyle or medication are eligible to donate blood.</p>
                <p>If you are taking insulin, you must meet the following criteria:</p>
                <ul>
                    <li>You must not have taken insulin before 2007;</li>
                    <li>You must not have had symptomatic hypoglycemia within 30 days of donating blood;</li>
                    <li>Your insulin dose must not have been increased or decreased by more than three units within 30 days of donating blood.</li>
                </ul>
                <p>For more details about donor qualifications, vist <a href="https://www.hemaquebec.ca/en/blood-donation/eligibility-blood/health-status-blood" class="ques">Héma-Québec’s</a> website or <a href="https://www.hemaquebec.ca/en/contact-us" class="ques">give them a call</a>.</p>

            </div>
        </div>
        <div class="faq">
            <button class="accordion">Can I get a tattoo?<span class="arrow">&#9654;</span></button>
            <div class="panel">
                <p>Yes. However, your diabetes must be well managed: i.e., your glycated hemoglobin (A1C) and self-monitored blood sugar values are within target values. Certain areas of the body should be avoided.</p>
            </div>
        </div>


    </div>



    <script>
        // Script pour l'accordéon avec flèche animée
        document.addEventListener("DOMContentLoaded", function() {
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    // Toggle la classe 'active' pour gérer l'état ouvert/fermé
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    var arrow = this.querySelector(".arrow");

                    // Si le panneau est ouvert, on le ferme
                    if (panel.style.display === "block") {
                        panel.style.display = "none";
                        arrow.style.transform = "rotate(0deg)"; // Retour flèche
                    } else {
                        // Sinon, on l'ouvre
                        panel.style.display = "block";
                        arrow.style.transform = "rotate(90deg)"; // Rotation flèche
                    }
                });
            }
        });
    </script>

 
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