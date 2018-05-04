<?php $title = "Liste des utilisateurs"; ?>
<!--
*This file is used to load the html system of the list users 
*    -->
<?php include('partials/_header.php'); ?>


    <div id="main-content">
        <div class="container">

            <h1>Liste des utilisateurs</h1>
            <?php //getting all the posts with the differents functions (change, delete...) only if you are logged
while ($data = $users->fetch(PDO::FETCH_ASSOC)) {
?>
<?php foreach (array_chunk($data, 4) as $user) : //recovery of users with 4 users-groups on each row?>
            <div class="row users">
                <?php foreach ($data as $user) : ?>
                <div class="col-md-3 user-block">
                <a href="../index.php?action=profile&amp;id=<?= $data['id']?>">
                <img src="<?= get_avatar_url($data['email'], 100) ?>"
                     alt="Image de profil de <?= $data['pseudo']?>" class="avatar img-circle">
                </a>
                <a href="../index.php?action=profile&amp;id=<?= $data['id']?>">
                    <h4 class="user_block_username">
                    <?= $data['pseudo']?>
                </h4>
                </a>
            </div>
            <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
            <?php } $users->closeCursor(); ?>
        </div><!-- /.container -->
    </div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://code.jquery.com/jquery-1.12.2.min.js" integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script> 
<script>window.jQuery || document.write('<script src="../../../../public/assets/js/vendor/jquery-slim.min.js">' +
        '<\/script>')</script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="../public/assets/js/jquery.timeago.js"></script>
<script src="../public/assets/js/jquery.timeago.fr.js"></script>
<script src="../libraries/parsley/i18n/fr.js"></script>
<script src="../libraries/parsley/parsley.min.js"></script>

<script>window.Parsley.setLocale('fr');</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".timeago").timeago();


    });
</script>