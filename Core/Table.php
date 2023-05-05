<?php
namespace App\Core;

class Table {
    private $tableCode = "";

        /**
     * Générer le formulaire HTML
     * @return string 
     */
    public function create(){
        return $this->tableCode;
    }

    /**
     * Ajoute les attributs envoyés à la balise
     * @param array $attributs Tableau associatif ['class' => 'form-control', 'required' => true]
     * @return string Chaine de caractères générée
     */
    private function ajoutAttributs(array $attributs): string
    {
        // On initialise une chaîne de caractères
        $str = '';

        // On liste les attributs "courts"
        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

        // On boucle sur le tableau d'attributs
        foreach($attributs as $attribut => $valeur){
            // Si l'attribut est dans la liste des attributs courts
            if(in_array($attribut, $courts) && $valeur == true){
                $str .= " $attribut";
            }else{
                // On ajoute attribut='valeur'
                $str .= " $attribut=\"$valeur\"";
            }
        }

        return $str;
    }

    /**
     * Balise d'ouverture du formulaire
     * @param array $attributs Attributs
     * @return Table 
     */
    public function debutTable(array $attributs = []): self
    {
        // On crée la balise form
        $this->tableCode .= "<table";

        // On ajoute les attributs éventuels
        $this->tableCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        return $this;
    }

    /**
     * Balise de fermeture du formulaire
     * @return Table 
     */
    public function finTable():self
    {
        /**
         * NB : Pour avoir plusieurs formulaires uniques voici une piste 
         * 1)   $token = md5(uniqid());
         * 2)   Ajouter un input hidden
         *      $this->formCode .= "<input type='hidden' name='token' value='$token'>";
         * 3)   On peut les stocker dans la SESSION pour sauvegarder les données déjà entrée 
         *      $_SESSION['token'] = $token;
         */
        $this->tableCode .= '</table>';
        return $this;
    }

    public function ajoutTHEAD(array $attributs = []):self
    {
        $this->tableCode .= "<thead";

        // On ajoute les attributs éventuels
        $this->tableCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        return $this;
    }

    public function ajoutTBODY(array $attributs = []):self
    {
        $this->tableCode .= "<tbody";

        // On ajoute les attributs éventuels
        $this->tableCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        return $this;
    }

    public function ajoutTFOOTER(array $attributs = []):self
    {
        $this->tableCode .= "<tfooter";

        // On ajoute les attributs éventuels
        $this->tableCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        return $this;
    }

    public function ajoutTR(array $attributs = []):self
    {
        $this->tableCode .= "<tr";

        // On ajoute les attributs éventuels
        $this->tableCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        return $this;

    }

}