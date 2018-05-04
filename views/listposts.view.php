<?php $title = "Liste des Posts"; ?>
<!--
*This file is used for the posts view system, such as html
*Using POO
*
    -->




<?php ob_start(); ?><!-- input fields for the posts only if you are logged-->
<h1>Liste des posts!</h1>
<div class="champ" style="text-align : center;">
    <?php if(is_logged_in() ): ?>
<form action="index.post.php?action=addPost" method="post">
    <h2>Ajouter un article</h2>
    <div class="form-group">
        <label class="control-label" for="title">Titre</label><br />
        <input class="form-control" type="text" id="title" name="title" />
    </div>
    <div class="form-group">
        <label class="control-label" for="pseudo">Pseudo</label><br />
        <input class="form-control" type="text" id="pseudo" name="pseudo" value="<?php echo ''. get_session('pseudo'). ''; ?>" readonly/>
    </div>
    <div class="form-group">
        <label class="control-label" for="chapo">Chapô</label><br />
        <input class="form-control" type="text" id="chapo" name="chapo" />
    </div>
    <div style="display: none;">
        <label class="control-label" for="post_mail">Email</label><br />
        <input class="form-control" type="text" id="post_mail" name="post_mail" value="<?php echo ''. get_session('email'). ''; ?>" />
    </div>
    <div class="form-group">
        <label class="control-label" for="content">Blogpost</label><br />
        <textarea style="margin: auto;" class="form-control tinymce" id="content" name="content"></textarea>
    </div>
    <div>
        <input class="btn btn-primary" type="submit" />
    </div>
</form>
<?php endif ; ?>
</div>
<p style="text-align: center; font-size: 20px; padding-top: 3px;"><em>Derniers billets du blog :</em></p>


<?php //getting all the posts with the differents functions (change, delete...) only if you are logged
while ($data = $posts->fetch()) {
?>
<div class="shadow">
  <div class="container">
    <div class="news">
        <h3>
            <?= htmlspecialchars($data['title']) ?>
            <em>le <?= $data['creation_date_fr'] ?> par <?= htmlspecialchars($data['pseudo']) ?></em>
        </h3>
        <?= nl2br(htmlspecialchars($data['chapo'])) ?>
        <p>
            <?= nl2br(htmlspecialchars($data['content'])) ?>
            <br />
            <em><a href="../index.post.php?action=post&amp;id=<?= $data['id'] ?>">Commentaires</a></em>//
            <?php if(is_logged_in() ): ?>
                <?php if($_SESSION['pseudo'] == $data['pseudo'] || $_SESSION['user_id'] == "4") : ?>
            <em><a href="index.post.php?action=modifier&amp;id=<?= $data['id'] ?>">Modifier</a></em>//
            <em><a href="index.post.php?action=deletePost&amp;id=<?= $data['id'] ?>">Supprimer</a></em>
            <?php endif ; ?>
        <?php endif ; ?>
        </p>
    </div>
   </div>
</div>
<?php
}
$posts->closeCursor();
?>
<?php $content = ob_get_clean(); ?>

<?php require('template.view.php'); ?>