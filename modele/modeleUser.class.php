<?php
require_once("modele/modeleMere.class.php");

class ModeleUser
{

    private $pdo;

    public function __construct($serveur, $serveur2, $bdd, $user, $mdp, $mdp2)
    {
        $this->pdo = ModeleMere::getPdo($serveur, $serveur2, $bdd, $user, $mdp, $mdp2);
    }

    public function insertClientPar($tab)
    {
        $requete = "call insertClientPar(:nom, :email, :mdp, :tel, :role, :prenom);";
        $donnees = array(
            ":nom" => $tab['nom'],
            ":email" => $tab['email'],
            ":mdp" => $tab['mdp'],
            ":tel" => $tab['tel'],
            ":role" => "clientPart",
            ":prenom" => $tab['prenom']
        );
        if ($this->pdo != null) {
            //on prepare la requete
            $insert = $this->pdo->prepare($requete);
            $insert->execute($donnees);
        }
    }


    public function insertClientPro($tab)
    {
        $requete = "call insertClientPro(:nom, :email, :mdp, :tel, :role, :num_Siret, :adresse);";
        $donnees = array(
            ":nom" => $tab['nom'],
            ":email" => $tab['email'],
            ":mdp" => $tab['mdp'],
            ":tel" => $tab['tel'],
            ":role" => "clientPro",
            ":num_Siret" => $tab['num_Siret'],
            ":adresse" => $tab['adresse']
        );
        if ($this->pdo != null) {
            //on prepare la requete
            $insert = $this->pdo->prepare($requete);
            $insert->execute($donnees);
        }
    }


    public function selectAllHotels()
    {
        $requete = "SELECT * FROM vueHotels;";
        if ($this->pdo != null) {
            //on prepare la requete
            $select = $this->pdo->prepare($requete);
            $select->execute();
            return $select->fetchAll();
        } else {
            return null;
        }
    }

    public function selectAllRestaurants()
    {
        $requete = "SELECT * FROM vueRestaurants;";
        if ($this->pdo != null) {
            //on prepare la requete
            $select = $this->pdo->prepare($requete);
            $select->execute();
            return $select->fetchAll();
        } else {
            return null;
        }
    }

    public function selectAllSports()
    {
        $requete = "SELECT * FROM vueSport;";
        if ($this->pdo != null) {
            //on prepare la requete
            $select = $this->pdo->prepare($requete);
            $select->execute();
            return $select->fetchAll();
        } else {
            return null;
        }
    }

    public function selectAllCultures()
    {
        $requete = "SELECT * FROM vueCulture;";
        if ($this->pdo != null) {
            //on prepare la requete
            $select = $this->pdo->prepare($requete);
            $select->execute();
            return $select->fetchAll();
        } else {
            return null;
        }
    }

    public function selectAllLoisirs()
    {
        $requete = "SELECT * FROM vueCulture;";
        if ($this->pdo != null) {
            //on prepare la requete
            $select = $this->pdo->prepare($requete);
            $select->execute();
            return $select->fetchAll();
        } else {
            return null;
        }
    }

    public function checkUser($email)
    {
        $req = "SELECT * FROM user WHERE email=:email;";
        $donnees = array(
            ":email" => $email,
        );
        if ($this->pdo != null) {
            $select = $this->pdo->prepare($req);
            $select->execute($donnees);
            return $select->fetch();
        } else {
            return null;
        }
    }


    public function selectUser($email, $mdp)
    {
        $requete = "SELECT * FROM user WHERE email=? AND mdp=?";
        if ($this->pdo != null) {
            // on prépare la requete 
            $select  = $this->pdo->prepare($requete);
            $select->execute(array($email, $mdp));
            //extraction de tous les clients
            return $select->fetch();
        } else {
            return null;
        }
    }

    public function findByRole($role, $iduser)
    {
        // requête sql avec un WHERE, ça sera un fetch et non pas fetchAll
        $requete = "SELECT * FROM user WHERE role=? AND iduser=?";
        if ($this->pdo != null) {
            //  appel pdo avec la méthode prepare($sql) -> a mettre dans unevariable ex: select
            $select  = $this->pdo->prepare($requete);
            $donnees = array($role, $iduser);
            $select->execute($donnees);
            return $select->fetch();
        } else {
            return null;
        }
    }
    public function selectClientPro($email)
    {
        $requete = "SELECT * FROM vueClientPro WHERE email=?";
        if ($this->pdo != null) {
            // on prépare la requete 
            $select  = $this->pdo->prepare($requete);
            $select->execute(array($email));
            //extraction de tous les clients
            return $select->fetch();
        } else {
            return null;
        }
    }
    public function selectClientPart($email)
    {
        $requete = "SELECT * FROM vueClientPart WHERE email=?";
        if ($this->pdo != null) {
            // on prépare la requete 
            $select  = $this->pdo->prepare($requete);
            $select->execute(array($email));
            //extraction de tous les clients
            return $select->fetch();
        } else {
            return null;
        }
    } 

    //fonction de demande de désinscription 
    public function insertDesinscriptionClientPro($tab){
        $requete = "insert into desinscription(id_user,dateD,motif_User,statut,reservation) values(:id_user,CURDATE(),:motif_User,'En attente',:reservation);";
        $donnees = array(
            ":id_user" => $tab["id_user"],
            ":motif_User" => $tab["motif_User"],
            ":reservation" => $tab["reservation"]
        );
        if ($this->pdo != null) {
            //on prepare la requete

            try{
                $insert = $this->pdo->prepare($requete);
                $insert->execute($donnees);
            }catch(PDOException $e){
                echo "Erreur ! : ".$e->getMessage();
            } 
        }
        
    }

   




    public function existeDemandeDesinscription($id_user)
    {
        $requete ="select count(*) as nb from desinscription where id_user=:id_user";
        if ($this->pdo!=null) {
            //on prepare la requete
            $select = $this->pdo->prepare($requete);
            $select->bindValue("id_user",$id_user);
            $select->execute();

            $nb =$select->fetch(PDO::FETCH_ASSOC);
            if ($nb ["nb"]==0){
                return false;
            }else{
                return true;
            }
        }
    }

    public function refusDemandeDesinscription($id_user)
    {
        $requete ="select motif_admin as motif from desinscription where id_user = :id_user";
        if ($this->pdo != null) {
            //on prepare la requete
            $select = $this->pdo->prepare($requete);
            $select->bindValue("id_user",$id_user);
            $select->execute();

            $refus =$select->fetch(PDO::FETCH_ASSOC);
            if(empty($refus["motif"]==0)){
                return $refus["motif"];
            }else{
                return false;
            }
            
    }}

    public function getDesinscriptions(){
        $requete = "SELECT * FROM desinscription";
        if($this->pdo != null){
            $select = $this->pdo->prepare($requete);
            $select->execute();
            $tab = $select->fetchAll(PDO::FETCH_ASSOC);
            return $tab;
        }
    }

    public function supprUser($id_user){
        $requete = "delete from user where iduser=:iduser;";
        if($this->pdo!=null){
            try{
                $select = $this->pdo->prepare($requete);
                $select->bindValue(':iduser',$id_user);
                $select->execute();
            }catch(PDOException $e){
                echo "Erreur PDO : " . $e->getMessage();
            }

        }

        $requete = "update desinscription set statut='Acceptée' where id_user=:id_user;";
        if($this->pdo!=null){
            try{
                $select = $this->pdo->prepare($requete);
                $select->bindValue(':id_user',$id_user);
                $select->execute();
            }catch(PDOException $e){
                echo "Erreur PDO : " . $e->getMessage();
            }

        }

    }

    public function refuserDesinscription($id_user,$motifAdmin){
        $requete = "update desinscription set statut='Refusée', motif_Admin=:motifAdmin where id_user=:id_user;";
        if($this->pdo!=null){
            try{
                $select = $this->pdo->prepare($requete);
                $select->bindValue(':motifAdmin',$motifAdmin);
                $select->execute();
            }catch(PDOException $e){
                echo "Erreur PDO : " . $e->getMessage();
            }
        }
    }

}

?>
