<?php $title = "Liste des Posts"; ?>
<!--
*This file is used for the posts view system, such as html
*Using POO
*
    -->
<?php include('partials/_header.php');
?>


<?php ob_start(); ?><!-- input fields for the posts only if you are logged-->
<h1>Liste des posts!</h1>
<div class="champ" style="text-align : center;">
    <?php if(is_logged_in() ): ?>
<form action="index.post.php?action=addPost" method="post">
    <div>
        <label for="title">Titre</label><br />
        <input  type="text" id="title" name="title" />
    </div>
    <div>
        <label for="pseudonyme">Pseudonyme</label><br />
        <input type="text" id="pseudonyme" name="pseudonyme" />
    </div>
    <div>
        <label for="content">Blogpost</label><br />
        <textarea style="margin: auto;" id="content" name="content"></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>
<?php endif ; ?>
</div>


<p style="text-align: center;"><em>Derniers billets du blog :</em></p>


<?php //getting all the posts with the differents functions (change, delete...) only if you are logged
while ($data = $posts->fetch()) {
?>
    <div class="news">
        <h3>
            <?= htmlspecialchars($data['title']) ?>
            <em>le <?= $data['creation_date_fr'] ?> par <?= htmlspecialchars($data['pseudonyme']) ?></em>
        </h3>
        
        <p>
            <?= nl2br(htmlspecialchars($data['content'])) ?>
            <br />
            <em><a href="../index.post.php?action=post&amp;id=<?= $data['id'] ?>">Commentaires</a></em>//
            <?php if(is_logged_in() ): ?>
            <em><a href="index.post.php?action=modifier&amp;id=<?= $data['id'] ?>">Modifier</a></em>//
            <em><a href="index.post.php?action=deletePost&amp;id=<?= $data['id'] ?>">Supprimer</a></em>
        <?php endif ; ?>
        </p>
    </div>
<?php
}
$posts->closeCursor();
?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>