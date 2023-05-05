<?php

namespace App\Controllers;

use App\Models\PraticienDAO;
use App\Models\PraticienDO;

use DateTime;

class ProfilController extends Controller
{
    private array $response = ["success" => ["process" => false, "subProcess" => false], "message" => "Une erreur est survenue dans le controller de base", "reload" => false, "data" => []];

    public function praticien()
    {
        // Si il existe une requête de type POST, on la traite
        if (isset($_POST["action"]) && !empty($_POST["action"])) {
            // On va vérifier de quelle "action" il s'agit et on exécute du code en fonction
            switch ($_POST["action"]) {
                case "loadInfosPraticien":
                    $this->loadInfosPraticien();
                    $this->response["reload"] = $_SESSION["praticien"]["profil"]["reload"];
                    if ($this->response["reload"]){
                        $this->response["message"] = $_SESSION["praticien"]["profil"]["message"];
                    }
                    $_SESSION["praticien"]["profil"]["reload"] = false;
                    $_SESSION["praticien"]["profil"]["message"] = "Une erreur est survenue dans le controller de base";
                    echo json_encode($this->response);
                    break;
                case "editInfosPraticien":
                    $this->editInfosPraticien($_POST);
                    $_SESSION["praticien"]["profil"]["reload"] = $this->response["reload"] = true;
                    echo json_encode($this->response);
                    break;
                case "disableAccount":
                    $this->disableAccount();
                    $_SESSION["praticien"]["profil"]["reload"] = $this->response["reload"] = true;
                    echo json_encode($this->response);
                    break;
                case "activateAccount":
                    $this->activateAccount();
                    $_SESSION["praticien"]["profil"]["reload"] = $this->response["reload"] = true;
                    echo json_encode($this->response);
                    break;
                case "changePwd":
                    $this->changeMdp($_POST);
                    $_SESSION["praticien"]["profil"]["reload"] = $this->response["reload"] = true;
                    echo json_encode($this->response);
                    break;
            }
            // On ne continue pas l'exécution de la fonction
            exit;
        }

        $this->render("profil/praticien");
    }

    /**
     * Récupère les informations d'un praticien de la base de donnée
     * @return void
     */
    public function loadInfosPraticien():void
    {
        if (isset($_SESSION['praticien']) && !empty($_SESSION['praticien'])) {
            $idPraticien = $_SESSION['praticien']["idPraticien"];
            $praticienDO = PraticienDAO::getInstance()->read($idPraticien);

            $praticienArray = array(
                "id" => $praticienDO->getIdPraticien(),
                "nom" => $praticienDO->getNom(),
                "prenom" => $praticienDO->getPrenom(),
                "date_naissance" => $praticienDO->getDateNaissance(),
                "adresse" => $praticienDO->getAdresse(),
                "ville" => $praticienDO->getVille(),
                "code_postal" => $praticienDO->getCodePostal(),
                "email" => $praticienDO->getEmail(),
                "telephone" => $praticienDO->getTelephone(),
                "mot_de_passe" => $praticienDO->getMotDePasse(), // Vraiment utile?
                "actif" => $praticienDO->getActif(),
                "activite" => $praticienDO->getActivite(),
                "numero_adeli" => $praticienDO->getNumeroAdeli(),
                "actif" => $praticienDO->getActif(),
                "date_creation" => $praticienDO->getDateCreation(),
            );
            $this->response["data"][] = $praticienArray;
            $this->response["success"]["process"] = true;
            $this->response["message"] = "Le chargement des données s'est bien passé";
        } else {
            $this->response["success"]["process"] = false;
            $this->response["message"] = "Une erreur s'est produite dans la fonction loadInfosPraticien";
        }
    }

    /**
     * Edite les informations d'un praticien en base de donnée
     * @return void
     */
    public function editInfosPraticien($posts):void
    {
        $postNom = $posts["nom"];
        $postPrenom = $posts["prenom"];
        $postDateN = $posts["date_naissance"];
        $postAdresse = $posts["adresse"];
        $postVille = $posts["ville"];
        $postCp = $posts["code_postal"];
        $postEmail = $posts["email"];
        $postTel = $posts["telephone"];
        $postActivite = $posts["activite"];
        $postAdeli = $posts["numero_adeli"];

        if (isset($_SESSION["praticien"]) && !empty($_SESSION["praticien"])) {
            $idPraticien = $_SESSION["praticien"]["idPraticien"];
            $praticienDAO = PraticienDAO::getInstance();
            $praticienDO = $praticienDAO->read($idPraticien);

            $this->existNotEmpty($postNom) ? $praticienDO->setNom($postNom) : "";
            $this->existNotEmpty($postPrenom) ? $praticienDO->setPrenom($postPrenom) : "";;
            $this->existNotEmpty($postDateN) ? $praticienDO->setDateNaissance(DateTime::createFromFormat('Y-m-d', $postDateN)) : "";
            $this->existNotEmpty($postAdresse) ? $praticienDO->setAdresse($postAdresse) : "";
            $this->existNotEmpty($postVille) ? $praticienDO->setVille($postVille) : "";
            $this->existNotEmpty($postCp) ? $praticienDO->setCodePostal($postCp) : "";
            $this->existNotEmpty($postEmail) ? $praticienDO->setEmail($postEmail) : "";
            $this->existNotEmpty($postTel) ? $praticienDO->setTelephone($postTel) : "";
            $this->existNotEmpty($postActivite) ? $praticienDO->setActivite($postActivite) : "";
            $this->existNotEmpty($postAdeli) ? $praticienDO->setNumeroAdeli($postAdeli) : "";

            $this->response["success"] = $praticienDAO->update($praticienDO);
        }
        if ($this->response["success"]) {
            $_SESSION["praticien"]["email"] = $praticienDO->getEmail();
            $_SESSION["praticien"]["profil"]["message"] = $this->response["message"] = "Mise à jour effectuée avec succès";
        } else {
            $_SESSION["praticien"]["profil"]["message"] = $this->response["message"] = "Echec de la mise à jour";
        }
    }

    public function disableAccount():void
    {
        if (isset($_SESSION["praticien"]) && !empty($_SESSION["praticien"])) {
            $idPraticien = $_SESSION["praticien"]["idPraticien"];
            $praticienDAO = PraticienDAO::getInstance();
            $praticienDO = $praticienDAO->read($idPraticien);
            $praticienDO->setActif(0);

            $this->response["success"] = $praticienDAO->update($praticienDO);
        }
        if ($this->response["success"]){
            $_SESSION["praticien"]["profil"]["message"] = $this->response["message"] = "Compte désactivé avec succès";
        } else {
            $_SESSION["praticien"]["profil"]["message"] = $this->response["message"] = "Echec de la désactivation du compte";
        }
    }

    
    public function activateAccount():void
    {
        if (isset($_SESSION["praticien"]) && !empty($_SESSION["praticien"])) {
            $idPraticien = $_SESSION["praticien"]["idPraticien"];
            $praticienDAO = PraticienDAO::getInstance();
            $praticienDO = $praticienDAO->read($idPraticien);
            $praticienDO->setActif(1);

            $this->response["success"] = $praticienDAO->update($praticienDO);
        }
        if ($this->response["success"]){
            $_SESSION["praticien"]["profil"]["message"] = $this->response["message"] = "Compte réactivé avec succès";
        } else {
            $_SESSION["praticien"]["profil"]["message"] = $this->response["message"] = "Echec de la réactivation du compte";
        }
    }

    
    public function changeMdp($posts):void
    {
        if (isset($_SESSION["praticien"]) && !empty($_SESSION["praticien"])) {
            $idPraticien = $_SESSION["praticien"]["idPraticien"];
            $praticienDAO = PraticienDAO::getInstance();
            $praticienDO = $praticienDAO->read($idPraticien);

            if (password_verify($posts["oldPwd"], $praticienDO->getMotDePasse())) {
                $hash = password_hash($posts["pwd"], PASSWORD_ARGON2I);
                $praticienDO->setMotDePasse($hash);

                $this->response["success"]["subProcess"] = $praticienDAO->update($praticienDO);
                $_SESSION["praticien"]["profil"]["message"] = $this->response["message"] = "Mot de passe modifier avec succès";
            } else {
                $this->response["success"] = false;
                $_SESSION["praticien"]["profil"]["message"] = $this->response["message"] = "Echec de la modification du mot de passe";
            }
        }
    }


    /**
     * Savoir si un POST existe et n'est pas vide
     * @param [type] $post
     * @return boolean
     */
    public function existNotEmpty($post):bool
    {
        $response = false;
        if (isset($post) && !empty($post)) {
            $response = true;
        }
        return $response;
    }

}
