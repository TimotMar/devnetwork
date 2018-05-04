<?php $title = "Edition de Profil"; ?>
<?php include('partials/_header.php'); ?>
<!--
*This file is used for the edit user view system, such as html
*
*
-->

    <div id="main-content">
        <div class="container">
            <div class="row">

                <?php //if same user_id : we get the possibility to change the profil parameters
                if (!empty($_GET['id']) && $_GET['id'] === get_session('user_id')) :?>
                        <div class="col-md-6 col-md-offset-3">

                            <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Compléter mon profil</h3>
            </div>
            <div class="panel-body">
                <?php include('partials/_errors.php');?>
                <form data-parsley-validate action="../index.php?action=changeUser&amp;id=<?= $_GET['id'] ?>" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nom<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value ="<?= $profile['name']?>"
                                       required="required"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">Ville<span class="text-danger">*</span></label>
                                <input type="text" name="city" id="city" class="form-control"
                                       value ="<?= $profile['city']/* si on a déjà rentré le nom : on récup, sinon valeur en BDD*/?>"
                                       required="required"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Pays<span class="text-danger">*</span></label>
                                <input type="text" name="country" id="country" class="form-control"
                                       value ="<?= $profile['country']?>"
                                       required="required"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sex">Sexe<span class="text-danger">*</span></label>
                                <select required="required" name="sex" id="sex" class="form-control">
                                    <option value="M" <?= $profile['sex'] == "M" ? "selected" : ""?>>
                                        Masculin
                                    </option>
                                    <option value="F" <?= $profile['sex'] == "F" ? "selected" : ""?>>
                                        Feminin
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="twitter">Twitter</label>
                                <input type="text" name="twitter" id="twitter"
                                       value ="<?= $profile['twitter']?>"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="github">Github</label>
                                <input type="text" name="github" id="github"
                                       value ="<?= $profile['github']?>"
                                       class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="available_for_hiring">
                                    <input type="checkbox" name="available_for_hiring"
                                        <?= $profile['available_for_hiring'] ? "checked" : ""?>/>
                                    Disponible pour emploi?
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="facebook">Facebook</label>
                                <input type="text" name="facebook" id="facebook"
                                       value ="<?= $profile['facebook']?>"
                                       class="form-control"/>
                            </div>
                        </div>
                    </div>

  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="bio">Biographie</label>
                                <textarea name="bio" id="bio" cols="36" rows="18" class="form-control"
                                value="<?= $profile['bio']?>"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Valider" name="update"/>
                </form>
            </div>
        </div>
    </div>
                <?php endif;?>
                        </div>


                        </div><!-- /.container -->
                        </div>
                        <?php include('partials/_footer.php'); ?>
