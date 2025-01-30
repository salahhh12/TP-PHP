<?php
session_start();

// Vérifier si les informations sont bien passées
if (!isset($_GET['nom']) || !isset($_GET['prenom'])) {
    header("Location: index.php");
    exit;
}

// Récupération des informations
$nom = htmlspecialchars($_GET['nom']);
$prenom = htmlspecialchars($_GET['prenom']);
$avatar = isset($_GET['avatar']) && !empty($_GET['avatar']) ? htmlspecialchars($_GET['avatar']) : "uploads/default-avatar.png";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur le site, <?= $nom . " " . $prenom ?> !</h1>

        <?php if (!empty($avatar)): ?>
            <img src="<?= $avatar ?>" alt="Avatar de <?= $nom ?>" class="avatar">
        <?php endif; ?>

        <p>Merci pour votre inscription !</p>
        <a href="index.php">Retour à l'accueil</a>
    </div>
</body>
</html>
