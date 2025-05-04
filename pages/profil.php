<?php
require_once("modele/modeleUser.class.php");

// on récupère notre user qui a le rôle professionnel ou particulier en se servant de la variable de session
$unUser = $c_User->findByRole($_SESSION['role'], $_SESSION['iduser']);

$unClientPart=null;
$unClientPro=null;

if($unUser['role'] == 'clientPro') {
    $unClientPro = $c_User->selectClientPro($_SESSION['email']); //select * from vueclient where email =

    require_once("vue/vue_les_profilsPro.php");

    if(isset($_POST["desinscription"])){
        $verif = $c_User->existeDemandeDesinscription($_SESSION['iduser']);
        if($verif) 
        {
            if(!$c_User->refusDemandeDesinscription($_SESSION["iduser"])){
                $_SESSION["msg"]="<p>Votre demande de desinscription a ete enregister . Un mail vous sera envoyé dans 24 heures.</p>";
            }else{
                $_SESSION["msg"]="<h3>REFUS</h3>
                <p>votre admin a refusé votre demande pour le motif suivant : ". $c_User->refusDemandeDesinscription($_SESSION["iduser"]) . "</p>   
            ";
            }
            require_once("vue/vue_message_desinscription.php");
        }else{
            require_once("vue/vue_form_desinscription.php");
            
        }
    
    
    } 

    if(isset($_POST["valider"])){
        $tab = array();
        $tab["id_user"] = $_SESSION["iduser"];
        $tab["motif_User"] = $_POST["motif"];
        
        if($_POST['reser']==true){
            $tab["reservation"] = true;
        }else{
            $tab["reservation"] = false;
        }

        $c_User->insertDesinscriptionClientPro($tab);
        require_once("vue/vue_message_desinscription.php");
       
    }
   


}else if($unUser['role'] == 'clientPart') {

    $unClientPart = $c_User->selectClientPart($_SESSION['email']); 

    require_once("vue/vue_les_profilsPart.php");

}else if($unUser['role'] == 'admin'){ 

    $_SESSION["vue_desinscrits"] = $c_User->getDesinscriptions(); //Récupère le contenu de la table de désinscription
    require_once("vue/vue_des_desinscrits.php");//afficher la vue d'administration des désinscriptions
    if(isset($_POST["accepter"])){
        $c_User->supprUser($_POST["id_user"]);
        $_SESSION["msg"]="Desinscription acceptée. Suppression de l'user";
    }
    if(isset($_POST["refuser"])){
        $c_User->refuserDesinscription($_POST["id_user"],$_POST["motif_Admin"]);
        $_SESSION["msg"]="Desinscription refusée.";
        
    }
    

}

?>