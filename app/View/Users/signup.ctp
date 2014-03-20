<div class="mainwell">
    <div class="signup_form">


        <div class="well ">
            <form class="bs-example form-horizontal" method="POST" id="login_form">
                <fieldset>
                    <legend>Inscription</legend>




                    <div class="form-group">
                        <label class="col-lg-2 control-label formlabel" for="inputUsername">Nom d'utilisateur</label>
                        <div class="col-lg-10 forminput whitebox-input-input">
                            <input id="inputUsername" class="form-control" type="text" placeholder="2 caractères min - 80 max." name="data[User][username]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label formlabel" for="inputEmail">Email</label>
                        <div class="col-lg-10 forminput whitebox-input-input">
                            <input id="inputEmail" class="form-control" type="email" placeholder="Email valide uniquement" name="data[User][mail]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label formlabel" for="inputPassword">Mot de passe</label>
                        <div class="col-lg-10 forminput whitebox-input-input">
                            <input id="inputPassword" class="form-control" type="password" placeholder="2 caractères min - 80 max,  au moins 2 chiffres." name="data[User][password]">

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-2 control-label formlabel" for="inputPassword">Confirmation</label>
                        <div class="col-lg-10 forminput whitebox-input-input">
                            <input id="inputPassword" class="form-control" type="password" placeholder="2 caractères min - 80 max,  au moins 2 chiffres." name="data[User][passwordconf]">

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-lg-6 col-lg-offset-6 signupbutdiv">
                            <button class="btn btn-default">Annuler</button>
                            <button id="submitbutt" class="btn btn-primary" type="submit">Envoyer</button>
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

