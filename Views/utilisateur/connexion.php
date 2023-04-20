<?php if(!empty($_SESSION["error"])): ?>
<div class="alert alert-danger" role="alert">
    <?php 
        echo $_SESSION["error"]; 
        unset($_SESSION["error"]) 
    ?>
</div>
<?php endif; ?>

<h1>Connexion</h1>
<?= $loginForm ?>




<?php
echo 
?>

<html>
    <main id="content" class="container content">
        <?= $contenu; ?>
    </main>
</html>