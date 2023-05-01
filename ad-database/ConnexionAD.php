<?php

#HermadoCie.fr
class ConnexionAD
{
    private $ldap_password = "";
    private static $instance_singleton;


    public static function getInstance()
    {
        if (!self::$instance_singleton) {
            self::$instance_singleton = new ConnexionAD();
        }
        return self::$instance_singleton;
    }

    public function __construct()
    {
    }

    public function connect()
    {
        $ldap_dn = "cn=read-only,dc=HermadoCie,dc=fr";
        $ldap_password = $this->getLDAP_Password();
        $ldap_con = ldap_connect("HermadoCie.fr");
        if (!$ldap_con) {
            echo 'connexion au serveur ldap impossible';
            exit;
        } else {
            echo 'la connexion a ldap a marché</br>';
            return $ldap_con;
        }

        if (ldap_bind($ldap_con, $ldap_dn, $ldap_password)) {
            echo "bind successful";
            return $ldap_con;
        } else {
            echo "invalid user/pass or other errors";
        }

        ldap_close($ldap_con);
    }


    function searchDepartement($departement)
    {
        $ad_server = "ldap://HermadoCie.fr"; 
        $ad_domain = "HermadoCie"; 
        $ad_dn = "OU=" . $departement . ",OU=Entreprise,DC=HermadoCie,DC=fr"; 
        // Informations d'identification pour la connexion
        $usernameConnected = "Administrateur";
        $password = "Hermard123"; // Remplacez "votre_mot_de_passe" par votre mot de passe AD

        // Recherche
        $search_filter = "(objectClass=user)"; // Remplacez "utilisateur_recherche" par le nom d'utilisateur que vous recherchez

        // Connexion à AD
        $ldap_conn = ldap_connect($ad_server);
        if (!$ldap_conn) {
            die("Erreur de connexion au serveur AD");
        }

        // Paramètres LDAP
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        // Authentification
        $bind = @ldap_bind($ldap_conn, $usernameConnected . "@" . $ad_domain . ".fr", $password);
        if (!$bind) {
            die("Erreur d'authentification");
        }

        // Recherche d'utilisateur

        $search = ldap_search($ldap_conn, $ad_dn, $search_filter);
        if (!$search) {
            die("Erreur de recherche");
        }

        // Récupération des résultats
        $result = ldap_get_entries($ldap_conn, $search);

        return $result;
        // Fermeture de la connexion
        ldap_unbind($ldap_conn);
    }
    //DistinguishedName
    function getAllUsers()
    {
        $ad_server = "ldap://HermadoCie.fr"; 
        $ad_domain = "HermadoCie"; 
        $ad_dn = "OU=Entreprise,DC=HermadoCie,DC=fr"; 
        // Informations d'identification pour la connexion
        $usernameConnected = "Administrateur"; // Remplacez "votre_utilisateur" par votre nom d'utilisateur AD
        $password = "Hermard123"; // Remplacez "votre_mot_de_passe" par votre mot de passe AD

        // Recherche
        $search_filter = "(&(objectClass=user)(objectCategory=person))"; // Remplacez "utilisateur_recherche" par le nom d'utilisateur que vous recherchez

        // Connexion à AD
        $ldap_conn = ldap_connect($ad_server);
        if (!$ldap_conn) {
            die("Erreur de connexion au serveur AD");
        }

        // Paramètres LDAP
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        // Authentification
        $bind = @ldap_bind($ldap_conn, $usernameConnected . "@" . $ad_domain . ".fr", $password);
        if (!$bind) {
            die("Erreur d'authentification");
        }

        // Recherche d'utilisateur

        $search = ldap_search($ldap_conn, $ad_dn, $search_filter);
        if (!$search) {
            die("Erreur de recherche");
        }

        // Récupération des résultats
        $result = ldap_get_entries($ldap_conn, $search);

        //ldap_unbind($ldap_conn);
        return $result;
        // Fermeture de la connexion
    }

    function getUser($username)
    {
        $ad_server = "ldap://HermadoCie.fr"; 
        $ad_domain = "HermadoCie"; 
        $ad_dn = "OU=Entreprise,DC=HermadoCie,DC=fr"; 
        // Informations d'identification pour la connexion
        $usernameConnected = "Administrateur"; // Remplacez "votre_utilisateur" par votre nom d'utilisateur AD
        $password = "Hermard123"; // Remplacez "votre_mot_de_passe" par votre mot de passe AD

        // Recherche
        $search_filter = "(sAMAccountName=*$username*)"; // Remplacez "utilisateur_recherche" par le nom d'utilisateur que vous recherchez

        // Connexion à AD
        $ldap_conn = ldap_connect($ad_server);
        if (!$ldap_conn) {
            die("Erreur de connexion au serveur AD");
        }

        // Paramètres LDAP
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        // Authentification
        $bind = @ldap_bind($ldap_conn, $usernameConnected . "@" . $ad_domain . ".fr", $password);
        if (!$bind) {
            die("Erreur d'authentification");
        }

        // Recherche d'utilisateur
        $search = ldap_search($ldap_conn, $ad_dn, $search_filter);
        if (!$search) {
            echo  'username : '.$username;
            die("Erreur de recherche");
        }

        // Récupération des résultats
        $result = ldap_get_entries($ldap_conn, $search);

        // Fermeture de la connexion
        ldap_unbind($ldap_conn);

        // Affichage des résultats
        if ($result["count"] > 0) {
            return $result;
        } else {
            return null;
        }
    }

    function getUserFromDN($dn)
    {
        $ad_server = "ldap://HermadoCie.fr"; // Remplacez "HermadoCie.fr" par votre serveur AD
        $ad_domain = "HermadoCie"; 
        $ad_dn = "OU=Entreprise,DC=HermadoCie,DC=fr"; 

        // Informations d'identification pour la connexion
        $usernameConnected = "Administrateur"; // Remplacez "Administrateur" par votre nom d'utilisateur AD
        $password = "Hermard123"; // Remplacez "Hermard123" par votre mot de passe AD

        // Recherche
        $search_filter = "(distinguishedName=$dn)"; // Utilisez le DN passé en paramètre pour la recherche

        // Connexion à AD
        $ldap_conn = ldap_connect($ad_server);
        if (!$ldap_conn) {
            die("Erreur de connexion au serveur AD");
        }

        // Paramètres LDAP
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        // Authentification
        $bind = @ldap_bind($ldap_conn, $usernameConnected . "@" . $ad_domain . ".fr", $password);
        if (!$bind) {
            die("Erreur d'authentification");
        }

        // Recherche d'utilisateur
        $search = ldap_search($ldap_conn, $ad_dn, $search_filter);
        if (!$search) {
            die("Erreur de recherche");
        }

        // Récupération des résultats
        $result = ldap_get_entries($ldap_conn, $search);

        // Fermeture de la connexion
        ldap_unbind($ldap_conn);

        // Affichage des résultats
        if ($result["count"] > 0) {
            return $result;
        } else {
            return null;
        }
    }


    function searchDepartementUser($departement, $username)
    {
        $ad_server = "ldap://HermadoCie.fr"; 
        $ad_domain = "HermadoCie"; 
        $ad_dn = "OU={$departement},OU=Entreprise,DC=HermadoCie,DC=fr"; 
        // Informations d'identification pour la connexion
        $usernameConnected = "Administrateur"; // Remplacez "votre_utilisateur" par votre nom d'utilisateur AD
        $password = "Hermard123"; // Remplacez "votre_mot_de_passe" par votre mot de passe AD

        // Recherche
        $search_filter = "(sAMAccountName=*$username*)"; // Remplacez "utilisateur_recherche" par le nom d'utilisateur que vous recherchez

        // Connexion à AD
        $ldap_conn = ldap_connect($ad_server);
        if (!$ldap_conn) {
            die("Erreur de connexion au serveur AD");
        }

        // Paramètres LDAP
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        // Authentification
        $bind = @ldap_bind($ldap_conn, $usernameConnected . "@" . $ad_domain . ".fr", $password);
        if (!$bind) {
            die("Erreur d'authentification");
        }

        // Recherche d'utilisateur
        $search = ldap_search($ldap_conn, $ad_dn, $search_filter);
        if (!$search) {
            die("Erreur de recherche");
        }

        // Récupération des résultats
        $result = ldap_get_entries($ldap_conn, $search);

        // Fermeture de la connexion
        ldap_unbind($ldap_conn);

        // Affichage des résultats
        if ($result["count"] > 0) {
            return $result;
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getLDAP_Password(): string
    {
        return $this->ldap_password;
    }

    public function existLogin()
    {
    }

    function adminGetUsers($prenom, $nom, $mail, $telPerso, $telPro, $adresse, $departement, $manager, $dateDeNaissance)
    {

        $ad_server = "ldap://HermadoCie.fr";
        $ad_domain = "HermadoCie";
        $ad_dn = "OU=Entreprise,DC=HermadoCie,DC=fr";
        $usernameConnected = $_SESSION["username"];
        $password = $_SESSION["password"];

        //

        $search_filter = "(&(objectClass=user)";
        if (!empty($prenom)) {
            $search_filter .= "(givenname=*$prenom*)";
        }
        if (!empty($nom)) {
            $search_filter .= "(sn=*$nom*)";
        }
        if (!empty($mail)) {
            $search_filter .= "(mail=*$mail*)";
        }

        if (!empty($telPro)) {
            $search_filter .= "(mobile=*$telPro*)";
        }

        if (!empty($telPerso)) {
            $search_filter .= "(homephone=*$telPerso*)";
        }

        // Ajout de la fonctionnalité de recherche pour les adresses
        if (!empty($adresse)) {
            $search_filter .= "(streetaddress=*$adresse*)";
        }

        // Ajout de la fonctionnalité de recherche pour les départements
        if (!empty($departement)) {
            $search_filter .= "(department=*$departement*)";
        }

        if (!empty($dateDeNaissance)) {
            $search_filter .= "(dateDeNaissance=*$dateDeNaissance*)";
        }

        // Ajout de la fonctionnalité de recherche pour les responsables

        if ($manager != "Aucun") {
            if (!empty($manager)) {
                if ($manager == "Younes Essoufle"){
                    $search_filter .= "(manager=CN=Younes Essoufle,OU=Direction,OU=Entreprise,DC=HermadoCie,DC=fr)";
                    echo "alert('$manager')";
                } else if ($manager == "Alexis Rosette"){
                    $search_filter .= "(manager=CN=Alexis Rosette,OU=Direction,OU=Entreprise,DC=HermadoCie,DC=fr)";
                    echo "alert('$manager')";
                } else if ($manager == "Ilyane Salam"){
                    $search_filter .= "(manager=CN=Ilyane Salam,OU=Ressources Humaines,OU=Entreprise,DC=HermadoCie,DC=fr)";
                    echo "alert('$manager')";
                } else if ($manager == "Maxime Borgia"){
                    $search_filter .= "(manager=CN=Maxime Borgia,OU=Secrétariat,OU=Entreprise,DC=HermadoCie,DC=fr)";
                    echo "alert('$manager')";
                } else if ($manager == "Lucas Skiaveti"){
                    $search_filter .= "(manager=CN=Lucas Skiaveti,OU=Informatique,OU=Entreprise,DC=HermadoCie,DC=fr)";
                    echo "alert('$manager')";
                } else if ($manager == "Mattys Lepape"){
                    $search_filter .= "(manager=CN=Mattys Lepape,OU=Marketing,OU=Entreprise,DC=HermadoCie,DC=fr)";
                    echo "alert('$manager')";
                }
            }
        }


        // Connexion à AD
        $ldap_conn = ldap_connect($ad_server);
        if (!$ldap_conn) {
            die("Erreur de connexion au serveur AD");
        }

        // Paramètres LDAP
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        // Authentification
        $bind = @ldap_bind($ldap_conn, $usernameConnected . "@" . $ad_domain . ".fr", $password);
        if (!$bind) {
            die("Erreur d'authentification");
        }

        $search_filter .= ")";

        // Recherche d'utilisateurs
        $search = ldap_search($ldap_conn, $ad_dn, $search_filter);
        if (!$search) {
            die("Erreur de recherche");
        } else {
        }

        // Récupération des résultats
        $results = ldap_get_entries($ldap_conn, $search);

        // Retourne les résultats
        return $results;
    }
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

//Get-ADUser -LDAPFilter '(objectClass=user)'
//Get-ADUser -LDAPFilter '(givenname=daffy)'
//write-host "manager : $manager"