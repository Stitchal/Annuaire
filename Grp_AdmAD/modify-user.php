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

        <form action="../ad-database/ldap-modify-user.php" method="post">
            <div class="container-user">
                <div class="form">
                    <div class="left">
                        <div class="container-label">
                            <ul>
                                <li>Nom</li>
                                <li>Prénom</li>
                                <li>Date de naissance</li>
                                <li>Département</li>
                                <li>Adresse</li>
                            </ul>
                        </div>
                        <div class="container-input">
                            <div class="input-field">
                            
                            <input type="text" name="surname" class="input sensible" placeholder="Nom" value="<?php echo $_SESSION['modifyNom']; ?>">

                            </div>
                            <div class="input-field">
                                <input type="text" name="givenname" class="input sensible" placeholder="Prénom" value="<?php echo $_SESSION['modifyPrenom']; ?>">
                            </div>
                            <div class="input-field">
                                <input type="date" name="dateDeNaissance" class="input" placeholder="Date de naissance" value="<?php echo $_SESSION['modifyDateDeNaissance']; ?>">
                            </div>
                            <div class="input-field">
                                <input type="text" name="departement" class="input sensible" placeholder="Département" value="<?php echo $_SESSION['modifyDepartement']; ?>">
                            </div>
                            <div class="input-field">
                                <input type="text" name="streetaddress" class="input" placeholder="Adresse" value="<?php echo $_SESSION['modifyAdresse']; ?>" >
                            </div>
                        </div>


                    </div>
                    <div class="right">
                        <div class="container-label">
                            <ul>
                                <li>Adresse mail</li>
                                <li>Tél perso</li>
                                <li>Tél pro</li>
                                <li>Manager</li>
                            </ul>
                        </div>
                        <div class="container-input">
                            <div class="input-field">
                                <input type="mail" name="mail" class="input" placeholder="Adresse mail" value="<?php echo $_SESSION['modifyMail']; ?>" >
                            </div>
                            <div class="input-field">
                                <input type="text" name="mobilephone" class="input" placeholder="Tél perso" value="<?php echo $_SESSION['modifyTelPro']; ?>" >
                            </div>
                            <div class="input-field">
                                <input type="text" name="homephone" class="input" placeholder="Tél pro" value="<?php echo $_SESSION['modifyTelPerso']; ?>" >
                            </div>
                            <div class="input-field">
                                <input type="text" name="manager" class="input sensible" placeholder="Manager" value="<?php echo $_SESSION['modifyManager']; ?>" disabled>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="bottom">
                <a href="index.php" class="bouton">Retour</a>
                    <div class="input-field">
                        <input type="submit" class="submit" value="Modifier l'utilisateur" id="">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>