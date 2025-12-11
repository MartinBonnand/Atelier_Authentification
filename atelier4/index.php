<?php

function demander_auth() {
    header('WWW-Authenticate: Basic realm="Atelier 4 - Zone protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Accès refusé. Veuillez actualiser la page et entrer vos identifiants.";
    exit();
}

if (isset($_GET['logout'])) {
    demander_auth();
}


if (!isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    demander_auth();
}

$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];


$isAdmin = false;
$isUser  = false;


if ($username === 'admin' && $password === 'secret') {
    $isAdmin = true;
}

if ($username === 'user' && $password === 'utilisateur') {
    $isUser = true;
}

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
            Cette partie de la page n'est visible que si vous êtes connecté avec
            le login <strong>admin</strong> et le mot de passe <strong>secret</strong>.
        </p>
        <ul>
            <li>Accès à des informations sensibles</li>
            <li>Fonctionnalités de gestion</li>
            <li>Vue complète des données</li>
        </ul>
    <?php else: ?>
        <hr>
        <h2>Section ADMIN non visible</h2>
        <p>
            Vous êtes connecté en tant que <strong>user</strong>.<br>
            Cette section est uniquement visible pour le profil <strong>admin</strong>.
        </p>
    <?php endif; ?>

    <hr>
    <p>
        <a href="?logout=1">Changer d'utilisateur (forcer une nouvelle authentification)</a>
    </p>
    <p>
        <em>Pensez à tester en navigation privée, comme demandé dans l'atelier.</em>
    </p>
</body>
</html>
