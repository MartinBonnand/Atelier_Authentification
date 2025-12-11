<?php
// Démarrer la session
session_start();

/* ===========================
   EXERCICE 2 : COMPTEUR DE VISITES
   =========================== */
if (!isset($_SESSION['visites_index'])) {
    $_SESSION['visites_index'] = 0;
}
$_SESSION['visites_index']++;

/* ===========================
   SI UTILISATEUR DEJA CONNECTÉ
   =========================== */
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['username'])) {
    
    if ($_SESSION['username'] === 'admin') {
        header('Location: page_admin.php');
        exit();

    } elseif ($_SESSION['username'] === 'user') {
        header('Location: page_user.php')
        exit();
    }
}

/* ===========================
   TRAITEMENT DU FORMULAIRE
   =========================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // EXERCICE 1 : deux utilisateurs

    // ADMIN
    if ($username === 'admin' && $password === 'secret') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = 'admin';
        header('Location: page_admin.php');
        exit();

    // USER
    } elseif ($username === 'user' && $password === 'utilisateur') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = 'user';
        header('Location: page_user.php');
        exit();

    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Atelier 3 – Sessions</title>
</head>
<body>

    <h1>Atelier 3 : Authentification par Session</h1>

    <p>
        Vous avez visité cette page d'accueil 
        <strong><?= $_SESSION['visites_index']; ?></strong> fois.
    </p>

    <?php if (!empty($error)) : ?>
        <p style="color:red;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" required>
        <br><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        <br><br>

        <button type="submit">Se connecter</button>
    </form>

    <br>
    <a href="../index.html">Retour à l'accueil</a>

</body>
</html>
