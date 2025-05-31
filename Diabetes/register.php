<?php
require 'config.php'; // Connexion à la BDD

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Vérifier si email existe déjà
    $check = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Email déjà utilisé
        $error = "⚠️ Cet email est déjà utilisé.";
        echo "<script>alert('$error'); window.location.href = 'loginn.php';</script>";
        exit();
    } else {
        // Crypter mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insérer en BDD
        $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $passwordHash);
        $success = $stmt->execute();

        if ($success) {
            // Récupérer id inséré
            $userId = $conn->insert_id;

            // Démarrer session
            session_start();
            $_SESSION["id"] = $userId;
            $_SESSION["email"] = $email;
            $_SESSION["username"] = $username;

            // Rediriger vers Home
            echo "<script>alert('✅ Inscription réussie !'); window.location.href = 'Home.php';</script>";
            exit();
        } else {
            // Échec insertion
            $error = "❌ Échec de l'insertion dans la base de données.";
            echo "<script>alert('$error'); window.location.href = 'loginn.php';</script>";
            exit();
        }
    }

    // Fermer statements et connexion
    $stmt->close();
    $check->close();
    $conn->close();
}
?>
