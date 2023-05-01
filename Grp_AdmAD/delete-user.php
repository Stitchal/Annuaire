<?php
session_start();
require_once('../ad-database/ConnexionAD.php');
include("../includes/nav.php");

if (!(isset($_SESSION["Grp_AdmAD"]))) {
    header('Location: ../error-403.php');
    exit();
}

?>

<DOCTYPE html>
<html LANG="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/styleAdmin.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <title>Hermardo&Cie</title>
</head>

<body>
    <div class="box-add-user">
        <!--action="../ad-database/ldap-delete-user.php"-->
        <form action="../ad-database/ldap-delete-user.php" method="post">
            <div class="container-user">
                <div class="form">
                    <h2>Voulez-vous vraiment supprimer <?php echo $_SESSION["deletePrenom"] . " ";
                                                        echo $_SESSION["deleteNom"]; ?> de l'annuaire ?</h2>
                </div>
                <div class="bottom">
                    <a href="index.php" class="bouton">Retour</a>
                    <div class="input-field">
                        <input type="submit" class="submit" value="Supprimer" id="">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>