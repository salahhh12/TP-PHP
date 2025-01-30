<?php
session_start();

// Charger les nationalités
function loadOptions($filename) {
    $options = [];
    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $options[] = trim($data[0]); // Prend la première colonne (nom nationalité)
        }
        fclose($handle);
    }
    return $options;
}

// Charger les pays avec la colonne correcte
function loadPays($filename) {
    $options = [];
    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $options[] = trim($data[4]); // On prend la 5ème colonne (nom du pays)
        }
        fclose($handle);
    }
    return $options;
}

$nationalities = loadOptions("data/nationality.csv");
$pays = loadPays("data/pays.csv");
$activities = file("data/activity.txt", FILE_IGNORE_NEW_LINES);

// Récupération des erreurs et des données précédemment saisies
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$data = isset($_SESSION['data']) ? $_SESSION['data'] : [];
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Formulaire d'inscription</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <p>Veuillez corriger les erreurs ci-dessous :</p>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="process.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
            <label>Nom :</label>
            <input type="text" name="nom" value="<?= isset($data['nom']) ? htmlspecialchars($data['nom']) : '' ?>" required>
            
            <label>Prénom :</label>
            <input type="text" name="prenom" value="<?= isset($data['prenom']) ? htmlspecialchars($data['prenom']) : '' ?>" required>

            <label>Email :</label>
            <input type="email" name="email" value="<?= isset($data['email']) ? htmlspecialchars($data['email']) : '' ?>" required>

            <label>Âge :</label>
            <input type="number" name="age" min="0" value="<?= isset($data['age']) ? htmlspecialchars($data['age']) : '' ?>" required>

            <label>Sexe :</label>
            <select name="sexe" required>
                <option value="Homme" <?= (isset($data['sexe']) && $data['sexe'] == "Homme") ? 'selected' : '' ?>>Homme</option>
                <option value="Femme" <?= (isset($data['sexe']) && $data['sexe'] == "Femme") ? 'selected' : '' ?>>Femme</option>
            </select>

            <label>Adresse :</label>
            <input type="text" name="adresse" value="<?= isset($data['adresse']) ? htmlspecialchars($data['adresse']) : '' ?>" required>

            <label>Nationalité :</label>
            <select name="nationality" required>
                <?php foreach ($nationalities as $nat): ?>
                    <option value="<?= htmlspecialchars($nat) ?>" <?= (isset($data['nationality']) && $data['nationality'] == $nat) ? 'selected' : '' ?>><?= htmlspecialchars($nat) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Pays de naissance :</label>
            <select name="pays" required>
                <?php foreach ($pays as $p): ?>
                    <option value="<?= htmlspecialchars($p) ?>" <?= (isset($data['pays']) && $data['pays'] == $p) ? 'selected' : '' ?>><?= htmlspecialchars($p) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Présentation :</label>
            <textarea name="description" maxlength="978"><?= isset($data['description']) ? htmlspecialchars($data['description']) : '' ?></textarea>

            <label>Activités de loisir :</label>
            <select name="activities[]" multiple required>
                <?php foreach ($activities as $act): ?>
                    <option value="<?= htmlspecialchars($act) ?>" <?= (isset($data['activities']) && in_array($act, $data['activities'])) ? 'selected' : '' ?>><?= htmlspecialchars($act) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Mot de passe :</label>
            <input type="password" name="password" required>

            <label>Confirmation du mot de passe :</label>
            <input type="password" name="confirm_password" required>

            <label>Avatar (PNG, JPEG, GIF) :</label>
            <input type="file" name="avatar" accept="image/png, image/jpeg, image/gif">

            <label><input type="checkbox" name="consent" required> J'accepte le traitement de mes données</label>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>
