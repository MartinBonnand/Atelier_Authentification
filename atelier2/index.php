<?php
session_start();

// Vérification si l'utilisateur a déjà un cookie valide
if (isset($_COOKIE['authToken']) && isset($_SESSION['authToken']) && $_COOKIE['authToken'] === $_SESSION['authToken']) {
    header('Location: page_admin.php'); // Redirection si déjà connecté
    exit();
}

// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification login/mot de passe
    if ($username === 'admin' && $password === 'secret') {
        // Génération d'un jeton unique
        $token = bin2hex(random_bytes(16));

        // Stockage côté client (cookie) et côté serveur (session)
        setcookie('authToken', $token, time() + 60, '/', '', false, true); // Cookie valable 60 secondes
        $_SESSION['authToken'] = $token;

        header('Location: page_admin.php'); // Redirection vers la page protégée
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
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" required>
        <br><br>
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        <br><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
