<?php
session_start();
if (!(isset($_SESSION["Grp_AdmAD"]))) {
    header('Location: ../error-403.php');
    exit();
}

function deleteEmployee($first_name, $last_name, $department)
{
    $ad_server = "ldap://HermadoCie.fr";
    $ad_domain = "HermadoCie";
    $ad_dn = "OU=Entreprise,DC=HermadoCie,DC=fr";
    // Informations d'identification pour la connexion
    $usernameConnected = "Administrateur";
    $passwordConnected = "Hermard123";

    // Connexion à AD
    $ldap_conn = ldap_connect($ad_server);

    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

    // Authentification
    $bind = @ldap_bind($ldap_conn, $usernameConnected . "@" . $ad_domain . ".fr", $passwordConnected);
    if (!$bind) {
        die("Erreur d'authentification");
    }

    $user_dn = "CN=$first_name $last_name,OU=".$department.",". $ad_dn;
    $delete = ldap_delete($ldap_conn, $user_dn);

    if (!$delete) {
        echo $user_dn;
        die("Erreur lors de la suppression de l'utilisateur");
    }

    $_SESSION["utilisateurDeleted"] = $first_name." ". $last_name;
    echo "L'utilisateur a été supprimé avec succès";
}

$sn = $_SESSION['deleteNom'];
$givenname = $_SESSION['deletePrenom'];
$department = $_SESSION['deleteDepartement'];

deleteEmployee($givenname, $sn, $department);

header('Location: ../Grp_AdmAD/index.php');
exit();
