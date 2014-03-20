    <div class="mainwell">
        <div class="signup_form">

            <div class="well ">
                <form class="bs-example form-horizontal" method="POST" id="login_form">
                    <fieldset>
                        <legend>Modifier mes informations personnelles</legend>



                                <div class="form-group">
                                    <label class="col-lg-2 control-label formlabel" for="inputPassword">Mot de passe</label>
                                    <div class="col-lg-11 forminput whitebox-input-input">
                                        <input id="inputPassword" class="form-control" type="password" placeholder="••••••" name="data[User][pass1]">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label formlabel" for="inputPassword">Confirmation</label>
                                    <div class="col-lg-10 forminput whitebox-input-input">
                                        <input id="inputPassword" class="form-control" type="password" placeholder="" name="data[User][pass2]">

                                    </div>
                                </div>

                            <h4>Optionnel</h4>

                            <div class="form-group">
                                <label class="col-lg-2 control-label formlabel" for="inputUsername">Nom</label>
                                <div class="col-lg-11 forminput whitebox-input-input">
                                    <input id="inputUsername" class="form-control" type="text" placeholder="<?php echo isset($data['User']['lastname'])?$data['User']['lastname']:''; ?>" name="data[User][lastname]" value="<?php echo isset($data['User']['lastname'])?$data['User']['lastname']:''; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label formlabel" for="inputUsername">Prénom</label>
                                <div class="col-lg-11 forminput whitebox-input-input">
                                    <input id="inputUsername" class="form-control" type="text" placeholder="<?php echo isset($data['User']['firstname'])?$data['User']['firstname']:''; ?>" name="data[User][firstname]" value="<?php echo isset($data['User']['firstname'])?$data['User']['firstname']:''; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label formlabel" for="inputUsername">Localité</label>
                                <div class="col-lg-11 forminput whitebox-input-input">
                                    <input id="inputUsername" class="form-control" type="text" placeholder="<?php echo isset($data['User']['locality'])?$data['User']['locality']:''; ?>" name="data[User][locality]" value="<?php echo isset($data['User']['locality'])?$data['User']['locality']:''; ?>">
                                </div>
                            </div>

                                <div class="form-group">
                                    <div class="col-lg-4 col-lg-offset-8 signupbutdiv">
                                        <button class="btn btn-primary" type="submit" id="submitbutt">Enregistrer</button>
                                    </div>
                                </div>

                    </fieldset>
                </form>
            </div>
        </div>



    <div class="signupaverts">




        <?php echo $this->Session->flash(); ?>


        <?php if(empty($_POST)){ ?>

            <div class="alert alert-dismissable alert-jg">
                <button class="close" data-dismiss="alert" type="button">×</button>
                <strong>Le nom d'utilisateur</strong>
                doit être composé d'au moins 2 caractères et de moins de 80 caractères.
            </div>

            <div class="alert alert-dismissable alert-jg">
                <button class="close" data-dismiss="alert" type="button">×</button>
                <strong>L'email</strong>
                doit être valide. (validation de votre inscription)
            </div>

            <div class="alert alert-dismissable alert-jg">
                <button class="close" data-dismiss="alert" type="button">×</button>
                <strong>Le mot de passe</strong>
                doit être composé de 2 à 80 caractères, contenir des lettres et des chiffres. (au moins 3 chiffres)
            </div>

        <?php } ?>


    </div>




</div>

    <script>


        $('#login_form').on('submit', function() {
            $("#submitbutt").addClass('submitbuttDisabled');
            $("#submitbutt").html('<img src="/pepi/my_jGallery/img/loading.gif" alt=""/>');
        });



    </script>