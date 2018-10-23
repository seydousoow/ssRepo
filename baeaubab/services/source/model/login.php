<?php 
if (session_status() == PHP_SESSION_NONE)
    session_start();

if (isset($_POST) and count($_POST) >= 3) {
    $user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $pwd = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $token = filter_var($_POST['token'], FILTER_SANITIZE_URL);
    $stat = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);

    require("../model/init.php");
    $bd = connect();
    $sql = "select password, credentials.status as status, nom, prenom, userstatus.status as poste from credentials inner join userstatus on credentials.status = userstatus.id where username=?";
    $req = $bd->prepare($sql);
    $req->execute(array($user));
    
    //check if the username exists
    if ($req->rowCount() > 0) {
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
                //check if the password is correct
            if (password_verify($pwd, $data['password'])) {
                setSess($user, $data['status'], $data['nom'], $data['prenom'], $data['poste']);
                ((isset($token)) && ($stat == $data['status'])) ? header("location: " . urldecode($token)) : redirecting_to_home($data['poste']);
            } else
                login_error(2);
        }
    } else
        login_error(1);
}
    
    //redirection to the good page according to the status of the user that logged in
function redirecting_to_home($status)
{
    switch ($status) {
        case "Directeur Général":
            header("location: /admin/director_homepage.php ");
            break;
        case "Production":
            header("location: ../../../services/production_homepage.php");
            break;
        case "Livraison":
            header("location: ../../../services/delivery_homepage.php?new_delivery");
            break;
        case "Technique":
            header("location: ../../../services/technic_homepage.php?production_monitoring&action=new");
            break;
        case "Employe Service Technique":
            header("location: ../../../services/technic_homepage.php?production_monitoring&action=new");
            break;
    }
}
//send indication in the error according to the credentials the user used to log in
function login_error($state)
{
    echo $state;
    if ($state == 1)
        header("location: ../../../index.php?err=usrnme");
    else if ($state == 2)
        header("location: ../../../index.php?err=pwrd");
}

//set user details as session variable
function setSess($usr, $status, $nom, $prenom, $poste)
{
    $_SESSION['loggedin'] = true;
    $_SESSION['connected'] = true;
    $_SESSION['timer'] = time();
    $_SESSION['username'] = $usr;
    $_SESSION['status'] = $status;
    $_SESSION['name'] = $nom;
    $_SESSION['surname'] = $prenom;
    $_SESSION['poste'] = $poste;
}