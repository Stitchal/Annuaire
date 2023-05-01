<?php
session_start();
if (!(isset($_SESSION["Grp_AdmAD"]))) {
    header('Location: ../error-403.php');
    exit();
}

function addEmployee($first_name, $last_name, $email, $password, $address, $birth_date, $mobile, $homephone, $department, $manager)
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

    $name = "$first_name $last_name";
    $samAccountName = "$first_name.$last_name";
    $displayName = "$first_name $last_name";
    $accountPassword = $password;
    $enabled = "true";
    $changePasswordAtLogon = "false";
    $passwordNeverExpires = "true";

    $managerDN = "";

    if ($manager == "Younes Essoufle"){
        $managerDN = "CN=Younes Essoufle,OU=Direction,OU=Entreprise,DC=HermadoCie,DC=fr";
        echo "alert('$manager')";
    } else if ($manager == "Alexis Rosette"){
        $managerDN = "CN=Alexis Rosette,OU=Direction,OU=Entreprise,DC=HermadoCie,DC=fr";
        echo "alert('$manager')";
    } else if ($manager == "Ilyane Salam"){
        $managerDN = "CN=Ilyane Salam,OU=Ressources Humaines,OU=Entreprise,DC=HermadoCie,DC=fr";
        echo "alert('$manager')";
    } else if ($manager == "Maxime Borgia"){
        $managerDN = "CN=Maxime Borgia,OU=Secrétariat,OU=Entreprise,DC=HermadoCie,DC=fr";
        echo "alert('$manager')";
    } else if ($manager == "Lucas Skiaveti"){
        $managerDN = "CN=Lucas Skiaveti,OU=Informatique,OU=Entreprise,DC=HermadoCie,DC=fr";
        echo "alert('$manager')";
    } else if ($manager == "Mattys Lepape"){
        $managerDN = "CN=Mattys Lepape,OU=Marketing,OU=Entreprise,DC=HermadoCie,DC=fr";
        echo "alert('$manager')";
    }

    $attributes = array(
        'cn' => $name,
        'givenname' => $first_name,
        'department' => $department,
        'sn' => $last_name,
        'samaccountname' => $samAccountName,
        'userprincipalname' => $samAccountName,
        'displayname' => $displayName,
        'streetaddress' => $address,
        'mail' => $email,
        'mobile' => $mobile,
        'homephone' => $homephone,
        'manager' => $managerDN,
        'dateDeNaissance' => $birth_date,
        'objectclass' => array("top", "person", "organizationalPerson", "user")
    );

    $user = ldap_add($ldap_conn, "CN=$first_name $last_name,OU=".$department.",". $ad_dn, $attributes);

    if (!$user) {
        echo "CN=$first_name $last_name,OU=".$department.",";
        die ("Erreur lors de la création de l'utilisateur");
    }
    $_SESSION["utilisateurAdd"] = $first_name." ". $last_name;

    echo "L'utilisateur a été créé avec succès";
}

$sn = $_POST['surname'];
$givenname = $_POST['givenname'];
$dateDeNaissance = $_POST['dateDeNaissance'];
$department = $_POST['departement'];
$streetaddress = $_POST['streetaddress'];
$mail = $_POST['mail'];
$mobile = $_POST['mobilephone'];
$homephone = $_POST['homephone'];
$manager= $_POST['manager'];


addEmployee($givenname, $sn, $mail, "hermard123", $streetaddress, $dateDeNaissance, $mobile,$homephone,$department, $manager);

header('Location: ../Grp_AdmAD/index.php');
exit();

?>