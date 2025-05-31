<?php
// article.php
require 'config1.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: search.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

if (!$article) {
    header("Location: search.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article['titre']) ?></title>
    <link rel="stylesheet" href="Home.css">
</head>
<body>
    <h1><?= htmlspecialchars($article['titre']) ?></h1>
    <div class="article-content">
        <?= nl2br(htmlspecialchars($article['contenu'])) ?>
    </div>
    <a href="search.php?query=<?= urlencode(htmlspecialchars($article['titre'])) ?>">← Retour aux résultats</a>
</body>
</html>