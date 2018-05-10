<?php $title = "Connexion"; ?>
<!--
*This file is used to load the html view of the login page
*
-->
<?php include('partials/_header.php'); ?>


    <div id="main-content">
        <div class="container">
            <h1 class="lead"> Connexion</h1>

            <?php
            include('partials/_errors.php');
            ?>
            <form data-parsley-validate action="../index.php?action=logintheUser" method="post" class="well col-md-6">
                <!-- identifiant field -->
                <div class="form-group">
                    <label class="control-label" for="identifiant">Pseudo ou email:</label>
                    <input type="text" class="form-control" id="identifiant" name="identifiant"
                           values="<?= get_input('identifiant')?>"
                           required="required"/>
                </div>


                <!-- Password field -->
                <div class="form-group">
                    <label class="control-label" for="password">Mot de passe :</label>
                    <input type="password" class="form-control" id="password" name="password"
                           required="required" />
                </div>

                <input type="submit" class="btn btn-primary" value="Connexion" name="login">


            </form>

        </div><!-- /.container -->
    </div>


<?php include('partials/_footer.php'); ?>