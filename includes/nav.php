<?php
session_start();
if (isset($GLOBALS['page'])) {
    $page = $GLOBALS['page'];
} else {
}
?>

<!DOCTYPE html>
<html LANG="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/favicon.ico" />
    <link rel="stylesheet" href="../css/new_menu.css">

</head>

<body>
    <navbar class="navbar-container">
        <div class="logo-container">
            <?php if (isset($_SESSION["Grp_AdmAD"])) : ?>
                <a href="index.php"><span style="color:#C96567">Hermardo</span>&Cie (Mode avancé)</a>
            <?php else : ?>
                <a href="index.php"><span style="color:#C96567">Hermardo</span>&Cie (Mode consultation)</a>
            <?php endif; ?>
        </div>

        <div class="bars">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>

        <ul class="nav-items">
            <?php if (isset($_SESSION["Grp_AdmAD"])) : ?>
                <li class="nav-link"><a href="../Grp_AdmAD/index.php">Tous les utilisateurs</a></li>
                <li class="nav-link nav-link-account"><a href=#><?php echo $_SESSION["username"]; ?> </a></li>
                <div class="login-register">
                    <a href="../logout.php" class="button">Se déconnecter</a>
                </div>
            <?php else : ?>
                <li class="nav-link"><a href="../index.php">Accueil</a></li>
                <div class="login-register">
                    <a href="../login.php" class="button">Se connecter</a>
                </div>
            <?php endif; ?>
        </ul>
    </navbar>
    <script src="../js/script.js"></script>
</body>

</html>