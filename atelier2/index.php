<?php
// Démarrer une session utilisateur qui sera en mesure de pouvoir gérer les Cookies
session_start();

// Vérifier si l'utilisateur est déjà en possession d'un cookie valide
// Comme on génère maintenant un token unique, on vérifie uniquement la présence du cookie.
if (isset($_COOKIE['authToken'])) {
    header('Location: page_admin.php');
    exit();
}

// Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification simple du username et de son password.
    if ($username === 'admin' && $password === 'secret') {
        
        // 🔥 EXERCICE 2 : générer un token unique au lieu de 12345
        $token = bin2hex(random_bytes(16)); 

        // 🔥 EXERCICE 1 : cookie valable 60 secondes
        setcookie('authToken', $token, time() + 60, '/', '', false, true);

        header('Location: page_admin.php');
        exit();

    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Atelier authentification par Cookie</h1>
    <h3>
        La page <a href="page_admin.php">page_admin.php</a> est inaccessible tant que vous ne vous serez pas connecté 
        avec le login 'admin' et mot de passe 'secret'
    </h3>

    <?php if (!empty($error)) : ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">Se connecter</button>
    </form>
    <br>
    <a href="../index.html">Retour à l'accueil</a>  
</body>
</html>
