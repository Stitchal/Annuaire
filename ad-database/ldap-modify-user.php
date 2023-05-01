<?php
session_start();
require_once('ConnexionAD.php');
if (!(isset($_SESSION["Grp_AdmAD"]))) {
    header('Location: ../error-403.php');
    exit();
}

function modifyEmployee($first_name, $last_name, $email, $address, $mobile, $homephone, $department, $dateDeNaissance)
{
    $ad_server = "ldap://HermadoCie.fr";
    $ad_domain = "HermadoCie";
    $ad_dn = "OU=Entreprise,DC=HermadoCie,DC=fr";
    // Informations d'identification pour la connexion
    $usernameConnected = "Administrateur";
    $passwordConnected = "Hermard123";
    $user_dn = "CN=$first_name $last_name,OU=" . $department . "," . $ad_dn;

    // Connexion à AD
    $ldap_conn = ldap_connect($ad_server);

    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

    // Authentification
    $bind = @ldap_bind($ldap_conn, $usernameConnected . "@" . $ad_domain . ".fr", $passwordConnected);
    if (!$bind) {
        die("Erreur d'authentification");
    }

    $name = "$first_name $last_name";
    $samAccountName = "$first_name.$last_name";
    $displayName = "$first_name $last_name";

    $attributes = array(
        /*'cn' => $name,
        'givenname' => $first_name,*/
        /*'department' => $department,
        'sn' => $last_name,
        'samaccountname' => $samAccountName,
        'userprincipalname' => $samAccountName,
        'displayname' => $displayName,*/
        'streetaddress' => $address,
        'mail' => $email,
        'dateDeNaissance' => $dateDeNaissance,
        'mobile' => $mobile,
        'homephone' => $homephone,
    );

    $user = ldap_modify($ldap_conn, $user_dn, $attributes);

    if (!$user) {
        echo $user_dn . '<br>';
        print_r($attributes);
        die("Erreur lors de la modification de l'utilisateur");
    }
    $_SESSION["utilisateurModified"] = $first_name." ". $last_name;

    echo "L'utilisateur a été modifié avec succès";
}

$first_name =$_POST['givenname'];
$last_name = $_POST['surname'];
$email = $_POST['mail'];
$mobile = $_POST['mobilephone'];
$homephone = $_POST['homephone'];
$address = $_POST['streetaddress'];
$department = $_POST['departement'];
$dateDeNaissance = $_POST['dateDeNaissance']; 

modifyEmployee($first_name, $last_name, $email, $address, $mobile, $homephone, $department, $dateDeNaissance);

header('Location: ../Grp_AdmAD/index.php');
exit();
