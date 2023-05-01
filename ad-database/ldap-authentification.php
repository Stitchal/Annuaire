<?php
$ad_domain = "HermadoCie";
$ad_dn = "OU=Entreprise,DC=HermadoCie,DC=fr";
$usernameConnected = $_POST["username"];
$password = $_POST["password"];

$search_filter = "(cn=Grp_AdmAD)";

// Connexion à AD
$ldap_conn = ldap_connect("ldap://HermadoCie.fr");
if (!$ldap_conn) {
    die("Erreur de connexion au serveur AD");
}

// Paramètres LDAP
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

// Authentification
$bind = @ldap_bind($ldap_conn, $usernameConnected . "@" . $ad_domain . ".fr", $password);
if (!$bind) {
    session_start();
    $_SESSION['error_message'] = "L'authentification a échoué. Veuillez vérifier votre nom d'utilisateur et votre mot de passe.";
    header("Location: ../login.php");
    exit();
}

$search = ldap_search($ldap_conn, $ad_dn, $search_filter);
if (!$search) {
    header('Location: ../login.php');
    exit();
} else {
    session_start();
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["password"] = $_POST["password"];
    $_SESSION["Grp_AdmAD"] = 1;
    ldap_unbind($ldap_conn);
    header('Location: ../Grp_AdmAD/index.php');
    exit();
}
