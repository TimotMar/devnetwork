<?php
/*
*This file is used for flashsystem to show errors
*
**/
if (isset($_SESSION['notification']['message'])) :?>
<div class="container">
<div class="alert alert-<?= $_SESSION['notification']['message']?>">

    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><?= $_SESSION['notification']['message'];?></h4>
</div>
</div>
<?php $_SESSION['notification'] = []; //besoin de vider l'array $_SESSION?>
<?php endif; ?>

