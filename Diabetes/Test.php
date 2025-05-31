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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Test Diet</title>
  <link rel="stylesheet" href="Test1.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>

  <!-- Header -->
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

  <!-- Navigation -->
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

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="Home.php">Home</a> &gt; <span>Test diet</span>
  </div>

  <!-- Hero -->
  <section class="hero-banner">
    <div class="hero-overlay">
      <h1 class="hero-title">Diabetes Test Diet</h1>
    </div>
  </section>

  <!-- Test Form -->
  <form id="dietTestForm">
  <div class="container">
    <button type="button" class="back-btn" id="backBtn"><i class="fas fa-arrow-left"></i></button>

    <input type="hidden" name="who" id="whoInput" />
    <input type="hidden" name="diabetes_type" id="diabetesInput" />
    <input type="hidden" name="hypertension" id="hypertensionInput" />
    <input type="hidden" name="weight" id="weightInput" />

    <!-- Question 1 -->
    <div id="question1" class="question-container">
      <div class="test-title first-title">Our 60-Second To Test Your Diet</div>
      <div class="first-question">Are you taking this test for yourself, or for a loved one?</div>
      <div class="btn-group first-group">
        <button type="button" class="btn8 first-btn">FOR MYSELF</button>
        <button type="button" class="btn8 first-btn">FOR SOMEONE ELSE</button>
      </div>
      <div class="progress-bar-container">
        <div class="progress-bar" id="progressBar"></div>
      </div>
    </div>

    <!-- Question 2 -->
    <div id="question2" class="question-container" style="display:none;">
      <div class="question">Do you have diabetes or are you at risk?</div>
      <div class="btn-group">
        <div class="btn-row">
          <button type="button" class="btn8 diabetes-option" id="type1Btn">TYPE 1 DIABETES</button>
          <button type="button" class="btn8 diabetes-option" id="type2Btn">TYPE 2 DIABETES</button>
        </div>
      </div>
      <div id="hypertension" style="display: none; margin-top: 20px;">
        <div class="question">Do you have hypertension?</div>
        <div class="btn-group">
          <button type="button" class="btn8 hypertension-option">HYPERTENSION</button>
          <button type="button" class="btn8 hypertension-option">NO HYPERTENSION</button>
        </div>
      </div>
      <div class="progress-bar-container">
        <div class="progress-bar" id="progressBar"></div>
      </div>
    </div>

    <!-- Question 3 -->
    <div id="question3" class="question-container" style="display:none;">
      <div class="question">What is your weight category?</div>
      <div class="btn-group">
        <div class="btn-row">
          <button type="button" class="btn8 weight-option">NORMAL WEIGHT</button>
          <button type="button" class="btn8 weight-option">OVERWEIGHT</button>
        </div>
        <div class="btn-row">
          <button type="button" class="btn8 weight-option">OBESE</button>
        </div>
      </div>
      <div class="progress-bar-container">
        <div class="progress-bar" id="progressBar"></div>
      </div>
    </div>
  </div>
</form>

<!-- Style de la barre de progression -->
<style>
  .progress-bar-container {
    width: 100%;
    background-color: #e0e0e0;
    height: 10px;
    border-radius: 5px;
    margin-top: 30px;
  }

  .progress-bar {
    height: 100%;
    width: 0%;
    background-color:rgb(232, 196, 51);
    border-radius: 5px;
    transition: width 0.4s ease;
  }

 
</style>

<!-- Script -->
<script>
  //function back button
  document.addEventListener('DOMContentLoaded', function () {
    const backBtn = document.getElementById("backBtn");
    const diabetesInput = document.getElementById("diabetesInput");
    const hypertensionInput = document.getElementById("hypertensionInput");
    const weightInput = document.getElementById("weightInput");

    function showQuestion(id) {
      document.querySelectorAll('.question-container').forEach(q => q.style.display = 'none');
      document.getElementById(id).style.display = 'block';
      backBtn.style.display = (id !== 'question1') ? 'inline-block' : 'none';
      updateProgressBar(id);
    }
     //progression 
    function updateProgressBar(id) {
      const bar = document.querySelectorAll('#progressBar');
      bar.forEach(el => el.style.width = "0%");
      let percent = 0;
      if (id === "question1") percent = 33;
      else if (id === "question2") percent = 66;
      else if (id === "question3") percent = 100;
      document.querySelectorAll('#' + id + ' .progress-bar').forEach(el => el.style.width = percent + '%');
    }
    //Question 1 n7otoha f who input apres nkemel Q2
    document.querySelectorAll('.first-btn').forEach(button => {
      button.addEventListener('click', function () {
        document.getElementById("whoInput").value = this.textContent;
        showQuestion("question2");
      });
    });

    document.getElementById("type1Btn").addEventListener('click', function () {
      diabetesInput.value = "TYPE 1 DIABETES";
      document.getElementById("hypertension").style.display = "none";
      showQuestion("question3");
    });

    document.getElementById("type2Btn").addEventListener('click', function () {
      diabetesInput.value = "TYPE 2 DIABETES";
      document.getElementById("hypertension").style.display = "block";
    });

    document.querySelectorAll('.hypertension-option').forEach(button => {
      button.addEventListener('click', function () {
        hypertensionInput.value = this.textContent.toUpperCase();
        showQuestion("question3");
      });
    });

    document.querySelectorAll('.weight-option').forEach(button => {
      button.addEventListener('click', function () {
        const weight = this.textContent.toUpperCase();
        weightInput.value = weight;

        const type = diabetesInput.value;
        const pressure = hypertensionInput.value;

        let code = 0;
        if (type === "TYPE 1 DIABETES") {
          if (weight === "NORMAL WEIGHT") code = 1;
          else if (weight === "OVERWEIGHT") code = 2;
          else if (weight === "OBESE") code = 3;
        } else if (type === "TYPE 2 DIABETES") {
          if (pressure === "HYPERTENSION") {
            if (weight === "NORMAL WEIGHT") code = 4;
            else if (weight === "OVERWEIGHT") code = 5;
            else if (weight === "OBESE") code = 6;
          } else if (pressure === "NO HYPERTENSION") {
            if (weight === "NORMAL WEIGHT") code = 7;
            else if (weight === "OVERWEIGHT") code = 8;
            else if (weight === "OBESE") code = 9;
          }
        }

        if (code > 0) {
          redirectToRegime(code);
        }
      });
    });

    backBtn.addEventListener("click", function () {
      if (document.getElementById("question3").style.display === "block") {
        showQuestion("question2");
      } else if (document.getElementById("question2").style.display === "block") {
        showQuestion("question1");
      }
    });

    function redirectToRegime(code) {
      fetch('save_regime.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ code: code })
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            window.location.href = "regime1.php?user_id=" + <?php echo $userId ?? 'null' ?>;
          } else {
            alert("فشل حفظ النظام الغذائي: " + (data.message || 'خطأ غير معروف'));
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert("حدث خطأ في الاتصال بالخادم: " + error.message);
        });
    }

    // Initialiser la première question et la barre
    updateProgressBar("question1");
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
                    <li><a href="<?= $loggedIn ? 'test.php?user_id=' . $userId : 'Loginn.php' ?>">Balanced diet</a></li>
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