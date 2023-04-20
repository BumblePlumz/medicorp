<?php

namespace App\Controllers;

use App\Models\PecDAO;
use App\Models\PecDO;

class PriseEnChargeController extends Controller 
{
    private array $response = ["success" => ["process" => false, "subProcess" => false], "message" => "Une erreur est survenue dans le controller de base", "reload" => false, "data" => []];
    
    public function index() 
    {
        // Si il existe une requête de type POST, on la traite
        if (isset($_POST["action"]) && !empty($_POST["action"])) {
            // On va vérifier de quelle "action" il s'agit et on exécute du code en fonction
            switch ($_POST["action"]) {
                case "loadInfosPec":
                    $this->loadInfosPec();
                    $this->response["reload"] = $_SESSION["praticien"]["profil"]["reload"];
                    if ($this->response["reload"]){
                        $this->response["message"] = $_SESSION["praticien"]["profil"]["message"];
                    }
                    $_SESSION["praticien"]["profil"]["reload"] = false;
                    $_SESSION["praticien"]["profil"]["message"] = "Une erreur est survenue dans le controller de base";
                    echo json_encode($this->response);
                    break;
                case "createPec":
                    $this->createPec($_POST);
                    echo json_encode($this->response);
                    break;
                case "deletePec":
                    $this->deletePec($_POST);
                    echo json_encode($this->response);
                    break;

            }
            // On ne continue pas l'exécution de la fonction
            exit;
        }
        $this->render("praticien/prise-en-charge");
    }

    private function loadInfosPec()
    {
        if (isset($_SESSION['praticien']) && !empty($_SESSION['praticien'])) {
            $idPraticien = $_SESSION['praticien']["idPraticien"];
            $pecList = PecDAO::getInstance()->readAllByPraticien($idPraticien);
            foreach ($pecList as $pecDO) {
                $pecArray = array(
                    "id" => $pecDO->getId(),
                    "type" => $pecDO->getType(),
                    "duree" => $pecDO->getDuree(),
                    "prix" => $pecDO->getPrix(),
                    "idPraticien" => $pecDO->getIdPraticien(),
                );
                $this->response["data"][] = $pecArray;
            }
            $this->response["success"]["process"] = true;
            $this->response["message"] = "Le chargement des données s'est bien passé";
        } else {
            $this->response["success"]["process"] = false;
            $this->response["message"] = "Une erreur s'est produite dans la fonction loadInfosPraticien";
        }
    }

    private function createPec($posts)
    {
        $postType = $posts["type"];
        $postDuree = $posts["duree"];
        $postPrix = $posts["prix"];

        if (isset($_SESSION["praticien"]) && !empty($_SESSION["praticien"])) {
            $idPraticien = $_SESSION["praticien"]["idPraticien"];

            $pecDO = new PecDO($postType, $postDuree, $postPrix, $idPraticien);

            PecDAO::getInstance()->create($pecDO);
        }
    }

    private function deletePec($posts)
    {
        $id = $posts["idPec"];
        PecDAO::getInstance()->deleteById($id);
        $this->response["success"]["subProcess"] = true;
        $this->response["message"] = "La suppression s'est bien passé";
    }
}