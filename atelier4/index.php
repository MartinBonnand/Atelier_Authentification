<?php
// Atelier 4 : Authentification simple via le header HTTP (Basic Auth)
session_start();

// Fonction qui force le navigateur à demander les identifiants
function demander_auth() {
    header('WWW-Authenticate: Basic realm="Atelier 4 - Zone protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Accès refusé. Veuillez actualiser la page et entrer vos identifiants.";
    exit();
}

// Gestion du logout (forcer une nouvelle authentification)
if (isset($_GET['logout'])) {
    // Supprimer toute session existante et redemander l'auth
    session_destroy();
    demander_auth();
}

// Vérifier que le navigateur a envoyé des identifiants
if (!isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    demander_auth();
}

$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

// Définir les rôles
$isAdmin = false;
$isUser  = false;

if ($username === 'admin' && $password === 'secret') {
    $isAdmin = true;
} elseif ($username === 'user' && $password === 'utilisateur') {
    $isUser = true;
}

// Si identifiants invalides
if (!$isAdmin && !$isUser) {
    demander_auth();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Atelier 4 - Authentification Basic Auth</title>
</head>
<body>
    <h1>Atelier 4 : Authentification via le header HTTP (Basic Auth)</h1>

    <p>
        Vous êtes connecté en tant que : <strong><?= htmlspecialchars($username) ?></strong>
        (profil <?= $isAdmin ? 'ADMIN' : 'USER' ?>)
    </p>

    <hr>

    <h2>Contenu accessible à tous les utilisateurs connectés</h2>
    <p>Cette section est visible par <strong>admin</strong> et <strong>user</strong>.</p>

    <?php if ($isAdmin): ?>
        <hr>
        <h2>Section réservée à l'ADMIN</h2>
        <p>Cette partie de la page n'est visible que par l'utilisateur <strong>admin</strong>.</p>
        <ul>
            <li>Accès aux informations sensibles</li>
            <li>Fonctionnalités de gestion</li>
            <li>Vue complète des données</li>
        </ul>
    <?php else: ?>
        <hr>
        <h2>Section ADMIN non visible</h2>
        <p>Vous êtes connecté en tant que <strong>user</strong>. Cette section est uniquement visible pour le profil <strong>admin</strong>.</p>
    <?php endif; ?>

    <hr>
    <p><a href="?logout=1">Changer d'utilisateur (forcer nouvelle authentification)</a></p>
    <p><em>Testez en navigation privée pour bien voir le comportement.</em></p>
</body>
</html>
