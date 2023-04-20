<?php

namespace App\Controllers;

use App\Models\PraticienDAO;
use App\Models\PraticienDO;
use App\Models\PatientDAO;
use App\Models\PatientDO;
use App\Models\RdvDao;
use App\Core\Form;
use App\Core\GlobalFunctions;
use DateTime;

class PraticienController extends Controller
{
    // Initialisation du json de réponse
    private array $response = ["success" => ["process" => false, "subProcess" => false], "message" => "Une erreur est survenue dans le controller de base", "data" => []];

    public function listePatient()
    {
        // Si il existe une requête de type POST, on la traite
        if (isset($_POST["action"]) && !empty($_POST["action"])) {
            // On va vérifier de quelle "action" il s'agit et on exécute du code en fonction
            switch ($_POST["action"]) {
                case "loadPatients":
                    $this->loadPatients();
                    echo json_encode($this->response);
                    break;
                case "switchActif":
                    $this->switchActif($_POST);
                    echo json_encode($this->response);
                    break;
                case "deletePatient":
                    $this->deletePatient($_POST);
                    echo json_encode($this->response);
                    break;
                case "updatePatient":
                    $this->updatePatient($_POST);
                    echo json_encode($this->response);
                    break;
            }
            // On ne continue pas l'exécution de la fonction
            exit;
        }

        $this->render("praticien/liste-patient");
    }


    /**
     * Gestion de la page "register_patient"
     * Si $_POST on effectue les demandes à la base de donnée puis on les retournes au fichier JS
     * Sinon on affiche la vue avec le formulaire
     * @return void
     */
    public function enregistrer_patient()
    {
        // Si il existe une requête de type POST, on la traite
        if (isset($_POST["action"]) && !empty($_POST["action"])) {

            // On va vérifier de quelle "action" il s'agit et on exécute du code en fonction
            switch ($_POST["action"]) {
                case "register":
                    $this->createPatient($_POST);
                    echo json_encode($this->response);
                    break;
            }
            // On ne continue pas l'exécution de la fonction
            exit;
        }

        $form = new Form;

        $form->debutForm("post", "#", ["id" => "form-patient", "class" => "row mx-auto col-6"])

            ->ajoutLabelFor('nom', 'Nom :', ['class' => 'form-label'])
            ->ajoutInput('text', 'nom', ['id' => 'nom', 'class' => 'form-control'])

            ->ajoutLabelFor('prenom', 'Prénom :', ['class' => 'form-label'])
            ->ajoutInput('text', 'prenom', ['id' => 'prenom', 'class' => 'form-control'])

            ->ajoutLabelFor('date-de-naissance', 'Date de naissance :', ['class' => 'form-label'])
            ->ajoutInput('date', 'date-de-naissance', ['id' => 'date-de-naissance', 'class' => 'form-control'])

            ->ajoutLabelFor('adresse', 'Adresse :', ['class' => 'form-label'])
            ->ajoutInput('text', 'adresse', ['id' => 'adresse', 'class' => 'form-control'])

            ->ajoutLabelFor('ville', 'Ville :', ['class' => 'form-label'])
            ->ajoutInput('text', 'ville', ['id' => 'ville', 'class' => 'form-control'])

            ->ajoutLabelFor('cp', 'Code Postal :', ['class' => 'form-label'])
            ->ajoutInput('text', 'cp', ['id' => 'cp', 'class' => 'form-control'])

            ->ajoutLabelFor('email', 'E-mail :', ['class' => 'form-label'])
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])

            ->ajoutLabelFor('telephone', 'Téléphone :', ['class' => 'form-label'])
            ->ajoutInput('number', 'telephone', ['id' => 'telephone', 'class' => 'form-control'])

            ->ajoutBouton('Inscrire un patient', ['class' => 'btn btn-primary', "type" => "submit"])

            ->finForm();

        $this->render("praticien/enregistrer-patient", ['registerForm' => $form->create()]);
    }

    public function priseEnCharge(){
        $this->render("praticien/prise-en-charge");
    }

    public function calendrier(){
        $this->render("praticien/calendrier");
    }


    /********************************************/
    /*                                          */
    /*    Methods not used to generate pages    */
    /*                                          */
    /********************************************/
    private function loadPatients()
    {
        $patientList = PraticienDAO::getInstance()->findAllPatientByIdPraticien($_SESSION["praticien"]["idPraticien"]);
        foreach ($patientList as $idPatient) {
            $patientDO = PatientDAO::getInstance()->read($idPatient);
            $patientArray = array(
                "id" => $patientDO->getIdpatient(),
                "nom" => $patientDO->getNom(),
                "prenom" => $patientDO->getPrenom(),
                "dateNaissance" => $patientDO->getDateNaissance(),
                "adresse" => $patientDO->getAdresse(),
                "ville" => $patientDO->getVille(),
                "codePostal" => $patientDO->getCodePostal(),
                "email" => $patientDO->getEmail(),
                "telephone" => $patientDO->getTelephone(),
                "motDePasse" => $patientDO->getMotDePasse(),
                "actif" => $patientDO->getActif(),
                "dateCreation" => $patientDO->getDateCreation(),
            );
            $this->response["data"][] = $patientArray;
        }
        $this->response["success"] = true;
        $this->response["message"] = "la requête s'est bien passée";
    }


    private function createPatient($posts)
    {
        // On vérifie si notre post contient les champs email et password
        if (Form::validate($_POST, ['nom', 'prenom', 'date-de-naissance', 'adresse', 'ville', 'cp', 'email', 'telephone'])) {
            // On initialise les DAOs
            $patientDAO = PatientDAO::getInstance();
            $praticienDAO = PraticienDAO::getInstance();

            // On nettoie les données
            $nom = strip_tags($posts['nom']);
            $prenom = strip_tags($posts['prenom']);
            $adresse = strip_tags($posts['adresse']);
            $ville = strip_tags($posts['ville']);
            $cp = strip_tags($posts['cp']);
            $email = strip_tags($posts['email']);
            $telephone = strip_tags($posts['telephone']);

            // On transforme l'input "date" en timestamp
            $dateDeNaissance = strip_tags($posts['date-de-naissance']);
            $date_format = "Y-m-d";
            $dateDeNaissancePrepared = DateTime::createFromFormat($date_format, $dateDeNaissance);

            // On génère le mot de passe
            $password = uniqid();

            // On stock le mot de passe et l'email pour les renvoyer à la vue
            $this->response["data"]["email"] = $email;
            $this->response["data"]["mdp"] = $password;

            // On chiffre le mot de passe
            $pass = password_hash($password, PASSWORD_ARGON2I);

            // On instancie l'utilisateur
            $patientDO = new PatientDO($nom, $prenom, $dateDeNaissancePrepared, $adresse, $ville, $cp, $email, $telephone, $pass);

            // On sauvegarde l'utilisateur dans la base de donnée
            $patientDAO->create($patientDO);
            
            // On récupère l'id généré par la création de l'utilisateur
            $idPatient = $patientDAO->getLastKey();
            $this->response["data"]["key"] = $idPatient;
            $this->response["data"]["praticien"] = $idPraticien = $_SESSION["praticien"]["idPraticien"];
            
            $praticienDAO->createPatient($idPraticien, $idPatient);
            
            $this->response["success"] = true;
            $this->response["message"] = "Inscription réussite";
        }
    }

    private function switchActif($posts)
    {   
        $patientDO = PatientDAO::getInstance()->read($posts["idPatient"]);
        $actif = $patientDO->getActif();
        if ($actif) {
            $patientDO->setActif(0);
        } else {
            $patientDO->setActif(1);
        }
        PatientDAO::getInstance()->update($patientDO);
        $this->response["success"]["subProcess"] = true;
        $this->response["message"] = "la requête du switch s'est bien passée";
    }

    private function deletePatient($posts)
    {
        $id = $posts["idPatient"];
        $patientDO = PatientDAO::getInstance()->read($id);

        $rdvDO = RdvDAO::getInstance()->readByIdPatient($id);
        if (empty($rdvDO)){
            PatientDAO::getInstance()->delete($patientDO);
        } else {
            RdvDAO::getInstance()->deleteByPatient($id);
            PatientDAO::getInstance()->delete($patientDO);
        }
        $this->response["success"]["subProcess"] = true;
        $this->response["message"] = "la suppression du Patient et de ses rendez-vous s'est bien passé";
    }

    private function updatePatient($posts)
    {
        $postNom = $posts["nom"];
        $postPrenom = $posts["prenom"];
        $postDateN = $posts["dateDeNaissance"];
        $postAdresse = $posts["adresse"];
        $postVille = $posts["ville"];
        $postCp = $posts["cp"];
        $postEmail = $posts["email"];
        $postTel = $posts["telephone"];

        if (isset($_SESSION["praticien"]) && !empty($_SESSION["praticien"])){
            $id = $posts["idPatient"];
            $patientDO = PatientDAO::getInstance()->read($id);
            
            $this->existNotEmpty($postNom) ? $patientDO->setNom($postNom) : "";
            $this->existNotEmpty($postPrenom) ? $patientDO->setPrenom($postPrenom) : "";;
            $this->existNotEmpty($postDateN) ? $patientDO->setDateNaissance(DateTime::createFromFormat('Y-m-d', $postDateN)) : "";
            $this->existNotEmpty($postAdresse) ? $patientDO->setAdresse($postAdresse) : "";
            $this->existNotEmpty($postVille) ? $patientDO->setVille($postVille) : "";
            $this->existNotEmpty($postCp) ? $patientDO->setCodePostal($postCp) : "";
            $this->existNotEmpty($postEmail) ? $patientDO->setEmail($postEmail) : "";
            $this->existNotEmpty($postTel) ? $patientDO->setTelephone($postTel) : "";

            
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
