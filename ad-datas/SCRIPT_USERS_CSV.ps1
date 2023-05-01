$ADUsers = Import-Csv C:jeu-dessai.csv -Delimiter ";" -Encoding Default

foreach($User in $ADUsers)
{
    $Password = "Hermard123"
    $Prenom = $User.Prenom
    $Nom = $User.Nom
    $Username = $User.Prenom+"."+$User.Nom
    $Departement = $User.departement
    $Email = $User.email
    $PhonePro = $User.phonePro
    $PhonePerso = $User.phonePerso
    $Adresse = $User.adresse
    $Manager = $User.Manager
    $Date = $User.DateNaissance	
    $Zero = "0"

    if (Get-ADUser -Filter {SamAccountName -eq $Username})
    {
        Write-Warning "A user account $Username already exists in Active Directory."
    }
    else
    {
        New-ADUser `
            -SamAccountName $Username `
            -UserPrincipalName "$Username@hermardocie.com" `
            -GivenName $Prenom `
            -Surname $Nom `
            -Name "$Prenom $Nom" `
            -DisplayName "$Nom, $Prenom" `
            -EmailAddress $Email `
            -AccountPassword (ConvertTo-SecureString $Password -AsPlainText -Force) `
            -Enabled $true `
            -HomePhone "$Zero$PhonePerso" `
            -MobilePhone "$Zero$PhonePro" `
            -ChangePasswordAtLogon $true `
            -StreetAddress $Adresse `
            -Department $Departement `
	    -OtherAttributes @{"dateDeNaissance" = $Date }
    }
    Set-ADUser -Identity $Username -Manager (Get-ADUser -Filter "GivenName -eq '$Manager'")
	if (($Manager -eq "Alexis") -or ($Manager -eq "Younes"))
    {
        Add-AdGroupMember -Identity Grp_AdmAD -Members "$Username"
    }
}

write-host "Les utilisateurs ont bien été insérés dans l'annuaire."