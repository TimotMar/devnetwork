<?php $title = htmlspecialchars($post['title']); ?>
<!--
*This file is used for loading the view of each post using html
*
*
-->
<?php ob_start(); ?>
<h1>Mon super blog !</h1>
<p><a href="../index.post.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3> <!-- recovery of the datas in the DB  -->
        <?= htmlspecialchars($post['title']) ?>
        <em>le <?= $post['creation_date_fr'] ?></em>
    </h3>
    
    <p>
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </p>
</div>

<h2>Commentaires</h2>
 <!-- form to add the comments depending if you are logged or not -->
<?php if(is_logged_in() ): ?>
<form action="index.post.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
    <div>
        <label for="author">Auteur</label><br />
        <input type="text" id="author" name="author" />
    </div>
    <div>
        <label for="comment">Commentaire</label><br />
        <textarea id="comment" name="comment"></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>
<?php endif ; ?>

<?php // recovery of all the comments from the datas from the DB
while ($comment = $comments->fetch()) {
?>
    <p><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['comment_date_fr'] ?></p>
    <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>