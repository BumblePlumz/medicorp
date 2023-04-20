<?php

namespace App\Controllers;

use App\Models\PatientDAO;
use App\Models\PatientDO;
use App\Models\UserDAO;
use App\Models\UserDO;
use App\Core\Form;
use App\Core\GlobalFunctions;
use DateTime;

class PatientController extends Controller
{
    // Initialisation du json de réponse
    private array $response = ["success" => false, "message" => "Une erreur est survenue dans le controller de base", "data" => []];

    public function listing()
    {
        // Si il existe une requête de type POST, on la traite
        if (isset($_POST["action"]) && !empty($_POST["action"])) {
            // On va vérifier de quelle "action" il s'agit et on exécute du code en fonction
            switch ($_POST["action"]) {
                case "load_patients":
                    $this->loadPatients();
                    $this->response["success"] = true;
                    $this->response["message"] = "la requête s'est bien passée";
                    echo json_encode($this->response);
                    break;
            }
            // On ne continue pas l'exécution de la fonction
            exit;
        }

        $this->render("patient/listing");
    }


    /**
     * Gestion de la page "register_patient"
     * Si $_POST on effectue les demandes à la base de donnée puis on les retournes au fichier JS
     * Sinon on affiche la vue avec le formulaire
     * @return void
     */
    public function register_patient()
    {
        // Si il existe une requête de type POST, on la traite
        if (isset($_POST["action"]) && !empty($_POST["action"])) {

            // On va vérifier de quelle "action" il s'agit et on exécute du code en fonction
            switch ($_POST["action"]) {
                case "register":
                    if ($this->response["success"] = $this->createPatient()) {
                        $this->response["message"] = "l'utilisateur a été créer avec succès";
                    }
                    // header('Content-type: application/json');
                    echo json_encode($this->response);
                    break;
            }
            // On ne continue pas l'exécution de la fonction
            exit;
        }

        $form = new Form;

        $form->debutForm("post", "#", ["id" => "form-patient"])

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

        $this->render("patient/register_patient", ['registerForm' => $form->create()]);
    }


    /********************************************/
    /*                                          */
    /*    Methods not used to generate pages    */
    /*                                          */
    /********************************************/
    private function loadPatients()
    {
        $userDAO = UserDAO::getInstance();
        $patientDAO = PatientDAO::getInstance();

        $userList = $patientDAO->findAllByPraticien($_SESSION["user"]["idPraticien"]);
        foreach($userList as $idPatient){
            $userDO = $userDAO->read($idPatient);
            $userArray = array(
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
            );
            $this->response["data"][] = $userArray;
        }

    }
    private function createPatient():bool
    {
        $response = false;
        // On vérifie si notre post contient les champs email et password
        if (Form::validate($_POST, ['nom', 'prenom', 'date-de-naissance', 'adresse', 'ville', 'cp', 'email', 'telephone'])) {
            // On initialise les DAOs
            $userDAO = UserDAO::getInstance();
            $patientDAO = PatientDAO::getInstance();

            // On nettoie les données
            $nom = strip_tags($_POST['nom']);
            $prenom = strip_tags($_POST['prenom']);
            $adresse = strip_tags($_POST['adresse']);
            $ville = strip_tags($_POST['ville']);
            $cp = strip_tags($_POST['cp']);
            $email = strip_tags($_POST['email']);
            $telephone = strip_tags($_POST['telephone']);

            // On transforme l'input "date" en timestamp
            $dateDeNaissance = strip_tags($_POST['date-de-naissance']);
            $dateDeNaissance = strtotime($dateDeNaissance);
            $dateDeNaissancePrepared = new DateTime();
            $dateDeNaissancePrepared->setTimestamp($dateDeNaissance);

            // On génère le mot de passe
            $password = uniqid();

            // On stock le mot de passe et l'email pour les renvoyer à la vue
            $this->response["data"]["email"] = $email;
            $this->response["data"]["mdp"] = $password;

            // On chiffre le mot de passe
            $pass = password_hash($password, PASSWORD_ARGON2I);

            // On instancie l'utilisateur
            $userDO = new UserDO($nom, $prenom, $dateDeNaissancePrepared, $adresse, $ville, $cp, $email, $telephone, $pass);

            // On sauvegarde l'utilisateur dans la base de donnée
            $userDAO->create($userDO);

            // On récupère l'id généré par la création de l'utilisateur
            $idUser = $userDAO->getLastKey();
            $this->response["data"]["key"] = $idUser;
            $this->response["data"]["praticien"] = $_SESSION["user"]["idPraticien"];

            // On instancie le patient*
            $patientDO = new PatientDO($idUser, $_SESSION["user"]["idPraticien"]);

            // On sauvegarde le patient dans la base de donnée
            $patientDAO->create($patientDO);

            $response = true;
        }
        return $response;
    }
}
