<?php
require 'config1.php';
session_start();

// Vérification de la connexion utilisateur
$loggedIn = isset($_SESSION['id']);
$username = 'Unknown';
$email = 'No email';

if ($loggedIn && $conn) {
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT username, email FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $userData = $result->fetch_assoc()) {
        $username = $userData['username'] ?? 'Unknown';
        $email = $userData['email'] ?? 'No email';
    }
    if ($stmt) $stmt->close();
}

// Traitement de la recherche
$query = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : '';
$article_results = [];

if ($conn && !empty($query)) {
    $stmt = $conn->prepare("SELECT id, titre, page_link FROM articles WHERE LOWER(titre) LIKE ? OR LOWER(contenu) LIKE ?");
    $searchTerm = "%".$query."%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $row['link'] = !empty($row['page_link']) ? $row['page_link'] : "article.php?id=".$row['id'];
        $article_results[] = $row;
    }
    $stmt->close();
}

if ($conn) $conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - MyDiabetes</title>
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <!-- Barre de titre et search -->
    <header>
        <div class="logo">
            <a href="Home.php"><img src="logo.png" alt="MyDiabetes Logo"></a>
            <a href="Home.php"><span class="clinic-name">My<span class="highlight">Diabetes</span></span></a>
        </div>
        <div class="search-user-container">
            <div class="search">
                <form action="search.php" method="GET" class="search-form">
                    <input class="search-input" type="text" name="query" placeholder="Search..." value="<?= htmlspecialchars($query) ?>">
                    <button class="btn" type="submit">Search</button>
                </form>
            </div>
            <div class="user-dropdown">
                <a href="<?= $loggedIn ? '#' : 'loginn.php' ?>" id="user-icon" class="user-icon">
                    <i class="fas fa-user-circle"></i>
                </a>
                <?php if ($loggedIn): ?>
                    <div id="dropdown-content" class="dropdown-content">
                        <p><strong><?= htmlspecialchars($username) ?></strong></p>
                        <p><?= htmlspecialchars($email) ?></p>
                        <hr>
                        <a href="logout.php" class="logout-link">Logout</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <script>
        document.getElementById('user-icon').addEventListener('click', function(e) {
            e.preventDefault();
            if (<?= $loggedIn ? 'true' : 'false' ?>) {
                const dropdown = document.getElementById('dropdown-content');
                dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
            } else {
                window.location.href = 'loginn.php';
            }
        });

        document.addEventListener('click', function(e) {
            const icon = document.getElementById('user-icon');
            const dropdown = document.getElementById('dropdown-content');
            if (!icon.contains(e.target) && (!dropdown || !dropdown.contains(e.target))) {
                if (dropdown) dropdown.style.display = 'none';
            }
        });
    </script>

    <!-- Barre de navigation -->
    <nav>
        <ul class="nav-links">
            <li><a href="Home.php">Home</a></li>
            <li class="dropdown">
                <a href="diabete.php">About Diabetes <i class="fas fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="type1.php">Type 1</a></li>
                    <li><a href="type2.php">Type 2</a></li>
                    <li><a href="type3.php">Gestational diabetes</a></li>
                    <li><a href="warning-signs.php">Warning signs and symptoms</a></li>
                    <li><a href="prevention.php">Diabetes prevention</a></li>
                    <li><a href="Complications.php">Diabetes complications</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Balanced Diet <i class="fas fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="<?= $loggedIn ? 'test.php?user_id='.$userId : 'Loginn.php' ?>">Start the Test</a></li>
                    <li><a href="<?= $loggedIn ? 'regime1.php?user_id='.$userId : 'Loginn.php' ?>">Show My Plan</a></li>
                </ul>
            </li>
            <li><a href="FAQ.php">FAQ's</a></li>
            <li><a href="Contacte.php">Contact</a></li>
        </ul>
    </nav>
     <div class="breadcrumb">
        <a href="Home.php">Home</a> &gt; <span>Search</span>
    </div>

    <!-- Contenu principal - Résultats de recherche -->
    <div class="search-results-container">
        <h1>Résultats pour : "<?= htmlspecialchars($query) ?>"</h1>

        <?php if (empty($article_results)): ?>
            <p class="no-results">Aucun résultat trouvé.</p>
        <?php else: ?>
            <ul class="results-list">
                <?php foreach ($article_results as $article): ?>
                    <li>
                        <a href="<?= htmlspecialchars($article['link']) ?>">
                            <?= htmlspecialchars($article['titre']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <a href="Home.php" class="back-link">← Retour à l'accueil</a>
    </div>

    <style>
       .breadcrumb {
  background: #f4f4f4;
  padding: 12px 20px;
  font-size: 14px;
}

.breadcrumb a {
  text-decoration: none;
  color: #005F86;
  font-weight: bold;
}

.breadcrumb span {
  
  color: black;
}
        .search-results-container {
            max-width: 1000px;
            margin: 80px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            font-size: 32px;
          
            
        }

        .search-results-container h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 32px;
        }

        .no-results {
            color:rgb(106, 109, 109);
            font-style: italic;
            text-align: center;
            margin: 30px 0;
        }

        .results-list {
            list-style: none;
            padding: 0;
            font-size: 42px;
           
        }

        .results-list li {
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            transition: all 0.3s ease;
            
        }

        .results-list li:hover {
            background: #e9f7fe;
            transform: translateX(5px);
        }

        .results-list a {
            color: #2980b9;
            text-decoration: none;
            font-size: 25px;
            display: block;
            line-height:1.9;
        }

        .results-list a:hover {
            color: #1a5276;
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
            color: #3498db;
            text-decoration: none;
            font-size: 22px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
    <footer>
            <div class="footer-container">
                <div class="footer-section">
                    <h3>Contact</h3>
                    <ul>
                        <li><a href="mailto:islemdiaf633@gmail.com">Email : islemdiaf633@gmail.com</a></li>
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
                    <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin fa-2x"></i></a>
                </div>
            </div>
            <p class="copyright">© 2025 Diabète Info - Tous droits réservés</p>
        </footer>
</body>
</html>