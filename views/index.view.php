<?php $title = "Accueil";?>
<!--
*This file is used to load the html of the index system
*
*
-->
<?php include('partials/_header.php');?>

<div id="main-content">
    <main role="main" class="container">
<!-- main page of the website, including the constants WEBSITE NAME -->
        <div class="jumbotron">
            <h1><?php echo WEBSITE_NAME;?> ?</h1>
            <p class="lead"><strong> <?php echo WEBSITE_NAME;?> </strong> est un blog dédié aux développeurs.<br/>
                <a href="../model/register.php">Rejoignez-nous!</a></p>
            <a href="../model/register.php"><button class="btn btn-primary btn-lg" >Je m'inscris </button></a>
        </div>

    </main><!-- /.container -->
</div>


<?php include('partials/_footer.php');?>