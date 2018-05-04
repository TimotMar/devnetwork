<?php $title = "Inscription"; ?>
<?php include('partials/_header.php'); ?>
<!--
*This file is used to load the register view using html
*
*
-->

<div id="main-content">
    <div class="container">
        <h1 class="lead"> Devenez membre dès à présent !</h1>

        <?php //error function
        include('partials/_errors.php')
        ?>
        <form data-parsley-validate action="../index.php?action=register" method="post" class="well col-md-6">
            <!-- Name field -->
            <div class="form-group">
                <label class="control-label" for="name">Nom:</label>
                <input type="text" class="form-control" id="name" name="name"
                       values ="<?= get_input('name')?>"
                       required="required"/>
            </div>

            <!-- Pseudo field -->
            <div class="form-group">
                <label class="control-label" for="pseudo">Pseudo:</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" data-parsley-minlength="3"
                       values ="<?= get_input('pseudo')?>"
                       required="required"/>
            </div>

            <!-- Email field -->
            <div class="form-group">
                <label class="control-label" for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email"
                       data-parsley-trigger="change" values ="<?= get_input('email')?>"
                       required="required"/>
            </div>

            <!-- Password field -->
            <div class="form-group">
                <label class="control-label" for="password">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password"
                       required="required" />
            </div>

            <!-- Password confirmation field -->
            <div class="form-group">
                <label class="control-label" for="password_confirm">Confirmez votre mot de passe :</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                       required="required" data-parsley-equalto="#password"/>
            </div>
            <div class="form-group">
                <label class="control-label" for="country">Pays :</label>
                <input type="text" class="form-control" id="country" name="country"
                       required="required"/>
            </div>
            <div class="form-group">
                <label class="control-label" for="city">Ville :</label>
                <input type="text" class="form-control" id="city" name="city"
                       required="required"/>
            </div>

            <input type="submit" class="btn btn-primary" value="Inscription" name="register">


        </form>

    </div><!-- /.container -->
</div>


<?php include('partials/_footer.php'); ?>