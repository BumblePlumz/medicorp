<?php
namespace App\Controllers;

use App\Models\PraticienDAO;
use App\Models\UserDAO;

class ProfilController extends Controller
{
    private array $response = ["success" => false, "message" => "Une erreur est survenue dans le controller de base", "data" => []];

    public function praticien()
    {
        // Si il existe une requête de type POST, on la traite
        if (isset($_POST["action"]) && !empty($_POST["action"])) {
            // On va vérifier de quelle "action" il s'agit et on exécute du code en fonction
            switch ($_POST["action"]) {
                case "load_infos_praticien":
                    $this->loadInfosPraticien();
                    echo json_encode($this->response);
                    break;
            }
            // On ne continue pas l'exécution de la fonction
            exit;
        }

        $this->render("profil/praticien");
    }
    public function client()
    {
        // Si il existe une requête de type POST, on la traite
        if (isset($_POST["action"]) && !empty($_POST["action"])) {
            // On va vérifier de quelle "action" il s'agit et on exécute du code en fonction
            switch ($_POST["action"]) {
                case "load_infos_client":
                    $this->loadInfosClient();
                    $this->response["success"] = true;
                    $this->response["message"] = "la requête s'est bien passée";
                    echo json_encode($this->response);
                    break;
            }
            // On ne continue pas l'exécution de la fonction
            exit;
        }

        $this->render("profil/client");
    }

    public function loadInfosPraticien(){
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['idPraticien'])){
            $idPraticien = $_SESSION['user']['idPraticien'];
            $praticienDAO = PraticienDAO::getInstance();
            $praticienDO = $praticienDAO->read($idPraticien);
            $idUser = $praticienDO->getUserID();
            $userDAO = UserDAO::getInstance();
            $userDO = $userDAO->read($idUser);

            $praticienArray = array(
                "id" => $userDO->getIdUser(),
                "nom" => $userDO->getNom(),
                "prenom" => $userDO->getPrenom(),
                "date_naissance" => $userDO->getDateNaissance(),
                "adresse" => $userDO->getAdresse(),
                "ville" => $userDO->getVille(),
                "code_postal" => $userDO->getCodePostal(),
                "email" => $userDO->getEmail(),
                "telephone" => $userDO->getTelephone(),
                "mot_de_passe" => $userDO->getMotDePasse(),
                "actif" => $userDO->getActif(),
                "created_at" => $userDO->getCreated_at(),
                "id_praticien" => $praticienDO->getId(),
                "activite" => $praticienDO->getActivite(),
                "numero_adeli" => $praticienDO->getNumeroAdeli(),
                "actif" => $praticienDO->getActif(),
            );
            $this->response["data"][] = $praticienArray;
            $this->response["success"] = true;
            $this->response["message"] = "la requête s'est bien passée";
        } else {
            $this->response["success"] = false;
            $this->response["message"] = "Une erreur s'est produite dans la fonction loadInfosPraticien";
        }
    }

    public function loadInfosClient(){

    }
}