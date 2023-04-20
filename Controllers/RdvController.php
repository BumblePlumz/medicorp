<?php

namespace App\Controllers;

use App\Models\RdvModel;
use App\core\Form;
use App\Core\GlobalFunctions;

class RdvController extends Controller
{
    /**
     * Cette méthode affichera une page listant tous les rendez-vous de la base de données
     * @return void
     */
    public function index()
    {
        // On instancie le modèle
        $rdvModel = new RdvModel;

        // On récupère les données
        $rdvs = $rdvModel->findBy(["actif" => 1]);

        $this->render("rdv/index", compact('rdvs')); // compact() est un équivalent du commentaire en dessous
        // $this->render("rdv/index", ["rdvs" => $rdvs, "array" => $array]);
    }

    public function rdvPraticien() {
        // On instancie le modèle
        $rdvModel = new RdvModel;

        // On récupère les données
        $rdvs = $rdvModel->findBy(["actif" => 1]);

        
        $this->render("rdv/rdvPraticien", compact('rdvs')); // compact() est un équivalent du commentaire en dessous
        // $this->render("rdv/index", ["rdvs" => $rdvs, "array" => $array]);
    }

    public function register_rdv(){
        if (isset($_SESSION['praticien']) && !empty($_SESSION['praticien'])){

            $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('prenom', 'Prénom :', ['class' => 'form-label'])
                ->ajoutInput('text', 'prenom', ['id' => 'prenom', 'class' => 'form-control'])

                ->ajoutLabelFor('pec', 'Type de prise en charge :', ['class' => 'form-label'])
                ->ajoutInput('text', 'pec', ['id' => 'pec', 'class' => 'form-control'])

                ->ajoutLabelFor('date-rdv', 'Date du rendez-vous :', ['class' => 'form-label'])
                ->ajoutInput('date', 'date-rdv', ['id' => 'date-rdv', 'class' => 'form-control'])

                ->ajoutLabelFor('commentaire', 'Cmmentaire :', ['class' => 'form-label'])
                ->ajoutInput('textarea', 'commentaire', ['id' => 'commentaire', 'class' => 'form-control'])

                ->ajoutLabelFor('email', 'E-mail :', ['class' => 'form-label'])
                ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])

                ->ajoutBouton('M\'inscrire', ['class' => 'btn btn-primary'])
                ->finForm();


            $this->render("rdv/register_rdv", ['rdvForm' => $form->create()]);
        } 
        $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('pec', 'Type de prise en charge :', ['class' => 'form-label'])
                ->ajoutInput('text', 'pec', ['id' => 'pec', 'class' => 'form-control'])

                ->ajoutLabelFor('date-rdv', 'Date du rendez-vous :', ['class' => 'form-label'])
                ->ajoutInput('date', 'date-rdv', ['id' => 'date-rdv', 'class' => 'form-control'])

                ->ajoutLabelFor('commentaire', 'Commentaire :', ['class' => 'form-label'])
                ->ajoutTextarea('textarea', '', ['id' => 'commentaire', 'class' => 'form-control', 'placeholder' => 'Inscrivez votre commentaire'])

                ->ajoutLabelFor('email', 'E-mail du client :', ['class' => 'form-label'])
                ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])

                ->ajoutBouton('M\'inscrire', ['class' => 'btn btn-primary'])
                ->finForm();


            $this->render("rdv/register_rdv", ['rdvForm' => $form->create()]);
    }
}
