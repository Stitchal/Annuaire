<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['mail'] = '';
    $_SESSION['password'] = '';
}

if (isset($_SESSION["Grp_AdmAD"])) {
    header('Location: ../Grp_AdmAD/index.php');
    exit();
}

if ((isset($_POST['nom'])) && isset($_POST['prenom'])) {
    $_SESSION['mail'] = $_POST['mail'];
    $_SESSION['password'] = $_POST['password'];
    echo "sefsf";
    if ((isset($_SESSION)) && ($_POST['mail'] != '')) {
        echo "Une session est créée pour <br>" . $_SESSION['mail'];
        $SID = session_create_id();
        session_commit();
    }
}

include("includes/nav.php");
$GLOBALS['page'] = "login.php";
?>

<!DOCTYPE html>
<html LANG="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/fonts.css">
    <title>Hermardo&Cie : Connexion</title>
</head>

<body>


    <form action="ad-database/ldap-authentification.php" method="post">
        <div class="box">
            <div class="container">
            
                <div class="top">
                    <header>Se connecter</header>
                </div>

                <div class="input-field">
                    <input type="text" name="username" class="input" placeholder="Identifiant" maxlength="50" required>
                    <i class='bx bx-user'></i>
                </div>

                <div class="input-field">
                    <input type="Password" name="password" class="input" placeholder="Mot de passe" maxlength="50" required>
                    <i class='bx bx-lock-alt'></i>
                </div>

                <div class="input-field">
                    <input type="submit" class="submit" value="Login" id="">
                </div>

                <div><?php
session_start();
if (isset($_SESSION['error_message'])) {
    echo "<p style='color:red'>" . $_SESSION['error_message'] . "</p>";
    unset($_SESSION['error_message']);
}
?></div>
            </div>
        </div>
    </form>
</body>

</html>