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

        <form action="../ad-database/ldap-add-user.php" method="post">
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
                                <input type="text" name="surname" class="input" placeholder="Nom" required>
                            </div>
                            <div class="input-field">
                                <input type="text" name="givenname" class="input" placeholder="Prénom" required>
                            </div>
                            <div class="input-field">
                                <input type="date" name="dateDeNaissance" class="input" placeholder="Date de naissance" required>
                            </div>
                            <div class="input-field">
                                <input type="text" name="departement" class="input" placeholder="Département" required>
                            </div>
                            <div class="input-field">
                                <input type="text" name="streetaddress" class="input" placeholder="Adresse" required>
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
                                <input type="mail" name="mail" class="input" placeholder="Adresse mail" required>
                            </div>
                            <div class="input-field">
                                <input type="text" name="mobilephone" class="input" placeholder="Tél perso" required>
                            </div>
                            <div class="input-field">
                                <input type="text" name="homephone" class="input" placeholder="Tél pro" required>
                            </div>
                            <select type="text" name="manager" class="input-manager">
                                <option value="Younes Essoufle">Younes Essoufle</option>
                                <option value="Alexis Rosette">Alexis Rosette</option>
                                <option value="Ilyane Salam">Ilyane Salam</option>
                                <option value="Maxime Borgia">Maxime Borgia</option>
                                <option value="Lucas Skiaveti">Lucas Skiaveti</option>
                                <option value="Mattys Lepape">Mattys Lepape</option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="bottom">
                <a href="index.php" class="bouton">Retour</a>
                    <div class="input-field">
                        <input type="submit" class="submit" value="Ajouter l'utilisateur" id="">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>