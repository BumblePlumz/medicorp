<!-- HEADER -->
<?php
use App\Core\GlobalFunctions;

GlobalFunctions::addScript("/View/praticien/enregistrerPatient", "defer");
?>
<!-- Message d'erreur en rouge -->
<?php if(!empty($_SESSION["error"])): ?>
<div class="alert alert-danger" role="alert">
    <?php 
        echo $_SESSION["error"]; 
        unset($_SESSION["error"]);
    ?>
</div>
<?php endif; ?>
<!-- Message de succes en vert -->
<?php if(!empty($_SESSION["success"])): ?>
<div class="alert alert-success" role="alert">
    <?php 
        echo $_SESSION["success"]["message"];
        GlobalFunctions::my_print_r($_SESSION["success"]["userDO"]);
        unset($_SESSION["success"]);
    ?>
</div>
<?php endif; ?>


<section>
    <p class="h1 text-center mt-5 mb-5">Enregistrement d'un patient</p>
    <?= $registerForm; ?>
</section>