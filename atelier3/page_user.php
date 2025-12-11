<?php
session_start();

// Vérifier que l'utilisateur est USER
if (!isset($_SESSION['loggedin'], $_SESSION['username']) || $_SESSION['username'] !== 'user') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Utilisateur</title>
</head>
<body>

    <h1>Bienvenue sur la page utilisateur de l'atelier 3</h1>
    <p>Vous êtes connecté en tant que : <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>

    <a href="logout.php">Se déconnecter</a>

</body>
</html>
