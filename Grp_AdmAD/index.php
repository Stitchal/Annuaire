<?php
session_start();
require_once('../ad-database/ConnexionAD.php');
include("../includes/nav.php");

if (!(isset($_SESSION["Grp_AdmAD"]))) {
    header('Location: ../error-403.php');
    exit();
}

if (isset($_SESSION["utilisateurDeleted"])){
    echo "<script>alert('{$_SESSION['utilisateurDeleted']} a été supprimé');</script>";
    unset($_SESSION["utilisateurDeleted"]);
}

if (isset($_SESSION["utilisateurModified"])){
    echo "<script>alert('{$_SESSION['utilisateurModified']} a été modifié');</script>";
    unset($_SESSION["utilisateurModified"]);
}

if (isset($_SESSION["utilisateurAdd"])){
    echo "<script>alert('{$_SESSION['utilisateurAdd']} a été ajouté');</script>";
    unset($_SESSION["utilisateurAdd"]);
}

if (isset($_POST["suppr"])) {
    $_SESSION['deleteNom'] = $_POST["deleteNom"];
    $_SESSION['deletePrenom'] = $_POST["deletePrenom"];
    $_SESSION['deleteDepartement'] = $_POST["deleteDepartement"];
    header('Location: ../Grp_AdmAD/delete-user.php');
    exit();
}

if (isset($_POST["modify"])) {
    $_SESSION['modifyPrenom'] = $_POST["modifyPrenom"];
    $_SESSION['modifyNom'] = $_POST["modifyNom"];
    $_SESSION['modifyDateDeNaissance'] = $_POST["modifyDateDeNaissance"];
    $_SESSION['modifyMail'] = $_POST["modifyMail"];
    $_SESSION['modifyTelPro'] = $_POST["modifyTelPro"];
    $_SESSION['modifyTelPerso'] = $_POST["modifyTelPerso"];
    $_SESSION['modifyAdresse'] = $_POST["modifyAdresse"];
    $_SESSION['modifyManager'] = $_POST["modifyManager"];
    $_SESSION['modifyDepartement'] = $_POST["modifyDepartement"];

    header('Location: ../Grp_AdmAD/modify-user.php');
    exit();
}

if (isset($_POST['submitRecherche'])) {
    $_SESSION['prenom'] = $_POST['prenom'];
    $_SESSION['nom'] = $_POST['nom'];
    $_SESSION['mail'] = $_POST['mail'];
    $_SESSION['telpro'] = $_POST['telpro'];
    $_SESSION['telperso'] = $_POST['telperso'];
    $_SESSION['adresse'] = $_POST['adresse'];
    $_SESSION['departement'] = $_POST['departement'];
    $_SESSION['manager'] = $_POST['manager'];
    $_SESSION['dateDeNaissance'] = $_POST['dateDeNaissance'];
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
        <button class="add-user-button"><a href="add-user.php">Ajouter un utilisateur</a></button>
        <div class="main">
            <table class="users-table">
                <tr>
                    <td class="td-id">ID</td>
                    <td class="td-prenom">Prénom</td>
                    <td class="td-nom">Nom</td>
                    <td class="td-datenaissance">Date de naissance</td>
                    <td class="td-mail">Adresse-mail</td>
                    <td class="td-telpro">N° Tel. Pro.</td>
                    <td class="td-telperso">N° Tel. Perso</td>
                    <td class="td-adresse">Adresse</td>
                    <td class="td-departement">Département</td>
                    <td class="td-manager">Manager</td>
                    <td></td>
                </tr>
                <tr class="tr-input">
                    <form method="post">
                        <td class="td-id"></td>
                        <td class="td-prenom">
                            <input type="text" name="prenom" class="input-prenom" placeholder="" />
                        </td>
                        <td class="td-nom">
                            <input type="text" name="nom" class="input-nom" placeholder="" />
                        </td>
                        <td class="td-datenaissance">
                            <input type="text" name="dateDeNaissance" class="input-datenaissance" placeholder="" />
                        </td>
                        <td>
                            <input type="text" name="mail" class="input-mail" placeholder="" />
                        </td>
                        <td>
                            <input type="text" name="telpro" class="input-telpro" placeholder="" />
                        </td>
                        <td>
                            <input type="text" name="telperso" class="input-telperso" placeholder="" />
                        </td>
                        <td>
                            <input type="text" name="adresse" class="input-adresse" placeholder="" />
                        </td>
                        <td>
                            <input type="text" name="departement" class="input-departement" placeholder="" />
                        </td>
                        <td>
                            <select type="text" name="manager" class="input-manager">
                                <option value="Aucun" selected>Non selectionné</option>
                                <option value="Younes Essoufle">Younes Essoufle</option>
                                <option value="Alexis Rosette">Alexis Rosette</option>
                                <option value="Ilyane Salam">Ilyane Salam</option>
                                <option value="Maxime Borgia">Maxime Borgia</option>
                                <option value="Lucas Skiaveti">Lucas Skiaveti</option>
                                <option value="Mattys Lepape">Mattys Lepape</option>
                            </select>
                        </td>
                        <td><button class="button" name="submitRecherche">Rechercher</button></td>
                    </form>
                </tr>

                <?php
                if (isset($_POST['submitRecherche'])) {
                    $result = ConnexionAD::getInstance()->adminGetUsers($_SESSION['prenom'], $_SESSION['nom'], $_SESSION['mail'], $_SESSION['telperso'], $_SESSION['telpro'], $_SESSION['adresse'], $_SESSION['departement'], $_SESSION['manager'], $_SESSION['dateDeNaissance']);
                } else {
                    $result = ConnexionAD::getInstance()->getAllUsers();
                }

                if ($result["count"] > 0) {
                    $i = 1;
                    foreach ($result as $person) {
                        if ($person["givenname"][0] != "") {
                            $prenom = $person["givenname"][0];
                            $nom = $person["sn"][0];
                            $dateDeNaissance = $person["datedenaissance"][0];
                            $mail = $person["mail"][0];
                            $telpro = $person["mobile"][0];
                            $telperso = $person["homephone"][0];
                            $adresse = $person["streetaddress"][0];
                            $department = $person["department"][0];
                            $managerDN = $person["manager"][0];
                            $manager = ConnexionAD::getInstance()->getUserFromDN($managerDN)[0]["givenname"][0];

                            echo "<tr><td class='td-id'>$i</td>
                            <td class='td-prenom'>$prenom</td>
                            <td class='td-nom'>$nom</td>
                            <td class='td-datenaissance'>$dateDeNaissance</td>
                            <td class='td-mail'>$mail</td>
                            <td class='td-telpro'>$telpro</td>
                            <td class='td-telperso'>$telperso</td>
                            <td class='td-adresse'>$adresse</td>
                            <td class='td-departement'>$department</td>
                            <td class='td-manager'>$manager</td>
                            <td>
                            <form method = 'post'>
                                <input type='hidden' name='modifyPrenom' value=$prenom>
                                <input type='hidden' name='modifyNom' value=$nom>
                                <input type='hidden' name='modifyDateDeNaissance' value=$dateDeNaissance>
                                <input type='hidden' name='modifyMail' value=$mail>
                                <input type='hidden' name='modifyTelPro' value=$telpro>
                                <input type='hidden' name='modifyTelPerso' value=$telperso>
                                <input type='hidden' name='modifyAdresse' value=$adresse>
                                <input type='hidden' name='modifyDepartement' value=$department>
                                <input type='hidden' name='modifyManager' value=$manager>
                                <input name='modify' class='boutonModifier' type='submit' value = 'Modifier' >
                            </form>
                            <form method = 'post'>
                                <input type='hidden' name='deleteNom' value=$nom>
                                <input type='hidden' name='deletePrenom' value=$prenom>
                                <input type='hidden' name='deleteDepartement' value=$department>
                                <input name='suppr' class='boutonDelete' type='submit' value = 'X' >
                            </form>
                            </td></tr>";
                            $i++;
                        }
                    }
                    echo '</table>';
                } else {
                    echo '</table>';
                    echo "<p class ='aucun-resultat'>Aucun résultat</p>";
                }

                ?>
        </div>
        </br></br>
    </body>

    </html>