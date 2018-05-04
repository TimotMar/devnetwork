<?php $title = htmlspecialchars($post['title']); ?>
<!-- 
*This file is used for the modifying page system such as html 
*
*
-->
<?php ob_start(); ?>
<h1>Mon super blog !</h1>
<p><a href="../index.post.php">Retour à la liste des billets</a></p>
<!-- page to modify the posts with the connection to the DB -->
<div class="champ">
<form action="../index.post.php?action=changePost&amp;id=<?= $post['id'] ?>" method="post">
    <div>
        <label for="title">Titre</label><br />
        <input style="width: 450px;" type="text" id="title" name="title"
               value= "<?= htmlspecialchars($post['title']) ?>"/>
    </div>
    <div>
        <label for="pseudo">Pseudo</label><br />
        <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($post['pseudo']) ?>" readonly/>
    </div>
    <div>
        <label for="chapo">Chapô</label><br />
        <input type="text" id="chapo" name="chapo" value="<?= htmlspecialchars($post['chapo']) ?>" />
    </div>
    <div>
        <label for="content">Blogpost</label><br />
        <textarea rows="10" cols="60" id="content" name="content"> <?= htmlspecialchars($post['content']) ?></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>

</form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.view.php'); ?>
