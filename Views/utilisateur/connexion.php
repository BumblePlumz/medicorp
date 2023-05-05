<?php if(!empty($_SESSION["error"])): ?>
<div class="alert alert-danger" role="alert">
    <?php 
        echo $_SESSION["error"]; 
        unset($_SESSION["error"]) 
    ?>
</div>
<?php endif; ?>


<section class="mt-4 mb-4">
    <p class="h1 text-center mb-3 text-primary">Connexion</p>
    <div class="d-flex justify-content-center align-items-center">
        <?= $loginForm ?>
    </div>
</section>
