<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Accès interdit !");
}

$nom = trim($_POST['nom']);
$prenom = trim($_POST['prenom']);
$email = trim($_POST['email']);
$age = (int)$_POST['age'];
$sexe = $_POST['sexe'];
$adresse = trim($_POST['adresse']);
$nationality = $_POST['nationality'];
$pays = $_POST['pays'];
$description = trim($_POST['description']);
$activities = isset($_POST['activities']) ? implode(",", $_POST['activities']) : "";
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$consent = isset($_POST['consent']);

// Vérification mot de passe
if ($password !== $confirm_password) {
    die("Erreur: Les mots de passe ne correspondent pas !");
}

// Vérifier si l'email existe déjà
$file = "utilisateur.txt";
if (file_exists($file)) {
    $users = file($file, FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        $fields = explode(";", $user);
        if ($fields[2] === $email) {
            die("Erreur: Email déjà utilisé !");
        }
    }
}

// Gérer l'upload de l'avatar
$avatar_path = "";
if (!empty($_FILES['avatar']['name'])) {
    $allowed_types = ["image/png", "image/jpeg", "image/gif"];
    if (!in_array($_FILES['avatar']['type'], $allowed_types)) {
        die("Erreur: Format d'image non supporté !");
    }
    // Déplacer l'image téléchargée dans le dossier "uploads"
    $avatar_path = "uploads/" . basename($_FILES['avatar']['name']);
    move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path);
}

// Enregistrement dans le fichier utilisateur.txt
$newUser = "$nom;$prenom;$email;$age;$sexe;$adresse;$nationality;$pays;$description;$activities;$password;$avatar_path";
file_put_contents("utilisateur.txt", $newUser . PHP_EOL, FILE_APPEND);

// Redirection avec les informations de l'utilisateur
header("Location: welcome.php?nom=$nom&prenom=$prenom&avatar=$avatar_path");
exit;
