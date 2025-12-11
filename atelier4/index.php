<?php
// Ne mets RIEN avant ce <?php (pas d'espace, pas de ligne vide) !

function demander_auth() {
    header('WWW-Authenticate: Basic realm="Atelier 4 - Zone protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Accès refusé. Actualisez la page et entrez vos identifiants.";
    exit();
}

// Si on clique sur "changer d'utilisateur"
if (isset($_GET['logout'])) {
    demander_auth();
}

// Vérifier si le navigateur a envoyé des identifiants
if (!isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    demander_auth();
}

$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

$isAdmin = ($username === 'admin' && $password === 'secret');
$isUser  = ($username === 'user'  && $password === 'utilisateur');

// Si ce n'est ni admin ni user -> on redemande
if (!$isAdmin && !$isUser) {
    demander_auth();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Atelier 4 - Authentification par header HTTP</title>
</head>
<body>
    <h1>Atelier 4 : Authentification via le header HTTP (Basic Auth)</h1>

    <p>
        Vous êtes connecté en tant que :
        <strong><?= htmlspecialchars($username) ?></strong>
        (profil <?= $isAdmin ? 'ADMIN' : 'USER' ?>).
    </p>

    <hr>

    <h2>Contenu visible par tous les utilisateurs connectés</h2>
    <p>Cette section est accessible à <strong>admin</strong> et à <strong>user</strong>.</p>

    <?php if ($isAdmin): ?>
        <hr>
        <h2>Section réservée à l'ADMIN</h2>
        <p>
            Visible uniquement pour <strong>admin / secret</strong>.
        </p>
    <?php else: ?>
        <hr>
        <h2>Section ADMIN non visible</h2>
        <p>Vous êtes connecté en tant que user. La section admin est cachée.</p>
    <?php endif; ?>

    <hr>
    <p><a href="?logout=1">Changer d'utilisateur</a></p>
    <p><em>Testez en navigation privée comme demandé dans l'atelier.</em></p>
</body>
</html>
