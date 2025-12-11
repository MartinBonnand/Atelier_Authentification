<?php
// Démarrer la session
session_start();

// Vérifier que l'utilisateur est BIEN "admin"
if (!isset($_SESSION['loggedin'], $_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: index.php');  // Redirection si l’utilisateur n’est pas admin
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Administrateur</title>
</head>
<body>

    <h1>Bienvenue sur la page administrateur de l'atelier 3</h1>

    <p>Vous êtes connecté en tant que : 
        <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
    </p>

    <a href="logout.php">Se déconnecter</a>

</body>
</html>
