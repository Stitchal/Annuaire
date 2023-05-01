<?php
session_start();
$GLOBALS['page'] = "index.php";
require_once('ad-database/ConnexionAD.php');

if (isset($_SESSION["Grp_AdmAD"])) {
    header('Location: ../Grp_AdmAD/index.php');
    exit();
}

include("includes/nav.php");
if (isset($_POST['submitRecherche'])) {
    $_SESSION['departement'] = $_POST['departement'];
    $_SESSION['nom'] = $_POST['nom'];
    header('Location: index.php');
    exit();
}
?>

<DOCTYPE html>
    <html LANG="fr">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/style.css">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
        <title>Hermardo&Cie</title>
    </head>

    <body>
        <div class="form-container">
            <form method="post">
                <div class="input-box">
                    <select type="text" name="departement" class="departement-select">
                        <option value="Tous" selected>Tous</option>
                        <option value="Direction">Direction</option>
                        <option value="Ressources humaines">Ressources humaines</option>
                        <option value="Informatique">Informatique</option>
                        <option value="Entretien">Entretien</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Secrétariat">Secrétariat</option>
                    </select>
                    <?php if (isset($_SESSION['nom'])) :?>
                        <input type="text" name="nom" id="nom" value= <?php echo '"'.$_SESSION['nom'].'"' ?> placeholder="Rechercher une personne..." />
                    <?php else : ?>
                        <input type="text" name="nom" id="nom" maxlength="50" placeholder="Rechercher une personne..." />    
                    <?php endif ?>                
                    <button class="button" name="submitRecherche">Rechercher</button>
                </div>
            </form>
        </div>

        <div class="main">
            <?php

            if (isset($_SESSION['departement'])) {
                if ($_SESSION['departement'] != "Tous") {
                    if (isset($_SESSION['nom'])) {
                        if ($_SESSION['nom'] != '') {
                            $result = ConnexionAD::getInstance()->searchDepartementUser($_SESSION['departement'], $_SESSION['nom']);
                        } else {
                            $result = ConnexionAD::getInstance()->searchDepartement($_SESSION['departement']);
                        }
                        unset($_SESSION['nom']);
                    } else {
                        $result = ConnexionAD::getInstance()->searchDepartement($_SESSION['departement']);
                    }
                } else {
                    if (isset($_SESSION['nom'])) {
                        if ($_SESSION['nom'] != '') {
                            $result = ConnexionAD::getInstance()->getUser($_SESSION['nom']);
                        } else {
                            $result = ConnexionAD::getInstance()->getAllUsers();
                        }
                    }
                }

                echo '<div class="person-cards-container">';

                if ($result["count"] > 0) {
                    foreach ($result as $person) {
                        if ($person["cn"][0] != "") {
                            $cn = $person["cn"][0];
                            $samAccountname = $person["samaccountname"][0];
                            $mail = $person["mail"][0];
                            $streetAddress = $person["streetaddress"][0];
                            $department = $person["department"][0];
                            $mobilePhone = $person["mobile"][0];

                            echo
                            '<div class="person-card">
                            <ul>
                                <li class="departement">' . $department . '</li>
                                <li class="samaccountname">' . $cn . '</li>
                                <table class="infos-container">
                                    <tr><td>Adresse-mail</td><td>' . $mail . '</td></tr>
                                    <tr><td>Adresse</td><td>' . $streetAddress . '</td></tr>
                                    <tr><td>Tel</td><td>' . $mobilePhone . '</td></tr>
                                </table>
                            </ul>
                        </div>';
                        }
                    }
                } else {
                    echo '<span>Aucun résultat</span>';
                }

            } else {
                echo '<p>Pour rechercher des utilisateurs, vous pouvez chercher par le prénom, le nom, le département, et tous en même temps.</p>';
            }
            echo '</div>';
            ?>
        </div>
    </body>

    </html>