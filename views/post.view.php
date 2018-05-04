<?php $title = htmlspecialchars($post['title']); 
?>
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
        <em>le <?= $post['creation_date_fr'] ?> par <?= $post['pseudo']  ?></em>
    </h3>
    <?= nl2br(htmlspecialchars($post['chapo'])) ?>
    <p>
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </p>
</div>
<h2 style="padding-left: 100px;">Ajouter un commentaire</h2>
 <!-- form to add the comments depending if you are logged or not -->
<?php if(is_logged_in() ): ?>
   
<form action="index.post.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
	<div style="padding-left:100px;">
    <div style="width: 11%;">
        <label for="author">Auteur</label><br />
        <input class="form-control" type="text" id="author" name="author" value="<?php echo ''. get_session('pseudo'). ''; ?>" readonly/>
    </div>
    <div style="width: 18%;">
        <label for="comment">Commentaire</label><br />
        <textarea class="form-control" id="comment" name="comment"></textarea>
    </div>
    <div style="display: none;">
        <input type="text" id="post_mail" name="post_mail" value="<?= $post['post_mail'] ?>"/>
    </div>
     <div style="display: none;">
        <input type="text" id="post_pseudo" name="post_pseudo" value="<?= $post['pseudo'] ?>"/>
    </div>
    <div style="width: 10%;">
        <input class="form-control" type="submit" value="Envoyer" name="envoi"/>
            </div>
        </div>
    </form>
<?php endif; ?>

<?php // recovery of all the comments from the datas from the DB
while ($comment = $comments->fetch()) {
?>
<?php if ($comment['publication'] == 1 || $_SESSION['pseudo'] == $post['pseudo'] || $_SESSION['user_id'] == '4'): ?>
<div class="shadow">
  <div class="container">
    <div class="news">
    <p><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['comment_date_fr'] ?></p>
    <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
    <?php
if ((is_logged_in()) && ($_SESSION['pseudo'] == $post['pseudo']) || ($_SESSION['pseudo'] == $comment['author']) || $_SESSION['user_id'] == "4") : ?>
            <em><a href="index.post.php?action=deleteComment&amp;id=<?= $comment['id'] ?>">Supprimer</a></em>
<?php endif; ?> 

    </div>
    <?php if (is_logged_in() && $_SESSION['pseudo'] == $post['pseudo'] && $comment['publication'] == 0 || $_SESSION['user_id'] == "4") : ?>
<em><a href="index.post.php?action=validateComment&amp;id=<?= $comment['id'] ?>">Valider</a></em>
<em><a href="index.post.php?action=deleteComment&amp;id=<?= $comment['id'] ?>">Supprimer</a></em>
<?php endif ; ?>
  </div>
</div>

<?php endif; ?>

<?php
}
?>

<?php $content = ob_get_clean(); ?>

<?php require('template.view.php'); ?>