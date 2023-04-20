<?php
namespace App\Controllers;

use App\Models\PraticienDAO;
use App\Models\PraticienDO;

use App\Core\GlobalFunctions;
use App\Core\Form;
use DateTime;

class UtilisateurController extends Controller
{
    /**
     * Url : /praticiens/logout
     * @return void
     */
    public function logout():void
    {
        // On supprimer les variables $_SESSION
        unset($_SESSION["praticien"]);
        // On détruit la session
        session_destroy();

        // On redirige vers l'accueil
        header("location: /");
    }

    public function inscription_praticien() 
    {
        // On vérifie si notre post contient les champs email et password
        if(Form::validate($_POST, ['nom', 'prenom', 'ville', 'date-de-naissance', 'adresse', 'cp', 'email', 'telephone', 'password', 'activite', 'numero_adeli'])){
            
            // On nettoie les données
            $nom = strip_tags($_POST['nom']);
            $prenom = strip_tags($_POST['prenom']);
            $adresse = strip_tags($_POST['adresse']);
            $ville = strip_tags($_POST['ville']);
            $cp = strip_tags($_POST['cp']);
            $email = strip_tags($_POST['email']);
            $telephone = strip_tags($_POST['telephone']);
            $activite = strip_tags($_POST['activite']);
            $adeli = strip_tags($_POST['numero_adeli']);
            
            // On transforme l'input "date" en timestamp
            $dateDeNaissance = strip_tags($_POST['date-de-naissance']);
            $dateDeNaissance = strtotime($dateDeNaissance);
            $dateDeNaissancePrepared = new DateTime();
            $dateDeNaissancePrepared->setTimestamp($dateDeNaissance);
            
            // On chiffre le mot de passe
            $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);

            $praticienDO = new praticienDO($nom, $prenom, $dateDeNaissancePrepared, $adresse, $ville, $cp, $email, $telephone, $pass, $activite, $adeli);
            $praticienDAO = new PraticienDAO();

            $praticienDAO->create($praticienDO, true);
            $session = $praticienDAO->findOneByEmail($_POST["email"]);

            $praticienDAO->setSessionPraticien($session);

            header("Location: /profil/praticien");
            // $this->render("profil/praticien");
        }

        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('nom', 'Nom :', ['class' => 'form-label'])
            ->ajoutInput('text', 'nom', ['id' => 'nom', 'class' => 'form-control'])

            ->ajoutLabelFor('prenom', 'Prénom :', ['class' => 'form-label'])
            ->ajoutInput('text', 'prenom', ['id' => 'prenom', 'class' => 'form-control'])

            ->ajoutLabelFor('ville', 'Ville :', ['class' => 'form-label'])
            ->ajoutInput('text', 'ville', ['id' => 'ville', 'class' => 'form-control'])

            ->ajoutLabelFor('date-de-naissance', 'Date de naissance :', ['class' => 'form-label'])
            ->ajoutInput('date', 'date-de-naissance', ['id' => 'date-de-naissance', 'class' => 'form-control'])

            ->ajoutLabelFor('adresse', 'Adresse :', ['class' => 'form-label'])
            ->ajoutInput('text', 'adresse', ['id' => 'adresse', 'class' => 'form-control'])

            ->ajoutLabelFor('cp', 'Code Postal :', ['class' => 'form-label'])
            ->ajoutInput('text', 'cp', ['id' => 'cp', 'class' => 'form-control'])

            ->ajoutLabelFor('email', 'E-mail :', ['class' => 'form-label'])
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])

            ->ajoutLabelFor('telephone', 'Téléphone :', ['class' => 'form-label'])
            ->ajoutInput('number', 'telephone', ['id' => 'telephone', 'class' => 'form-control'])

            ->ajoutLabelFor('pass', 'Mot de passe :', ['class' => 'form-label'])
            ->ajoutInput('password', 'password', ['id' => 'password', 'class' => 'form-control'])

            ->ajoutLabelFor('activite', 'Activitée :', ['class' => 'form-label'])
            ->ajoutInput('text', 'activite', ['id' => 'activite', 'class' => 'form-control'])

            ->ajoutLabelFor('numero_adeli', 'Numéro adeli :', ['class' => 'form-label'])
            ->ajoutInput('text', 'numero_adeli', ['id' => 'numero_adeli', 'class' => 'form-control'])

            ->ajoutBouton('M\'inscrire', ['class' => 'btn btn-primary'])
            ->finForm();

        $this->render('utilisateur/inscription_praticien', ['registerForm' => $form->create()]);
    }

    public function connexion()
    {
        if(Form::validate($_POST, ['email', 'password'])){
            $praticienDAO = new PraticienDAO();
            $praticienDO = $praticienDAO->findOneByEmail(strip_tags($_POST['email']));

            GlobalFunctions::my_print_r($praticienDO);
            
            if (isset($praticienDO) && empty($praticienDO) || !password_verify($_POST['password'], $praticienDO->getMotDePasse()) ){
                // Variable de session
                $_SESSION["error"] = "Connexion refusée, vérifier vos identifiants";
                // Redirection
                header("location: /utilisateur/connexion");
                // On arrête le script
                exit;
            }
            
            if(password_verify($_POST['password'], $praticienDO->getMotDePasse())){
                $praticienDAO->setSessionPraticien($praticienDO);
                header("Location: /profil/praticien");
            }     
        }

        // On instancie le formulaire
        $form = new Form;

        // On ajoute chacune des parties qui nous intéressent
        $form->debutForm()
            ->ajoutLabelFor('email', 'Email', ['class' => 'form-label'])
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])
            ->ajoutLabelFor('password', 'Mot de passe', ['class' => 'form-label'])
            ->ajoutInput('password', 'password', ['id' => 'password', 'class' => 'form-control'])
            ->ajoutBouton('Me connecter', ['class' => 'btn btn-primary'])
            ->finForm()
        ;

        // On envoie le formulaire à la vue en utilisant notre méthode "create"
        $this->render('utilisateur/connexion', ['loginForm' => $form->create()]);
    }


}
