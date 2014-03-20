<div class="jumbotron loginjumbotron loginbg" id="loginjumb">


    <div class="logincontent">
        <?php echo $this->Session->flash(); ?>

        <div class="panel panel-pf loginpanel" id="logbox">
            <div class="panel-heading">
                <h3 class="panel-title">Connexion</h3>
            </div>
            <div class="panel-body">


                <div class="loginmain">
                    <form class="bs-example form-horizontal" method="POST" id="login_form">



                            <div class="form-group">
                                <label class="col-lg-2 control-labelLogin formlabelLogin" for="inputUsername">Nom d'utilisateur</label>
                                <div class="col-lg-11 forminputLogin whitebox-input-input">
                                    <input id="inputUsername" class="form-control" type="text" placeholder="" name="data[User][username]">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-labelLogin formlabelLogin" for="inputPassword">Mot de passe</label>
                                <div class="col-lg-11 forminputLogin whitebox-input-input">
                                    <input id="inputPassword" class="form-control" type="password" placeholder="" name="data[User][password]">

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-6 signupbutdivLogin">
                                    <button class="btn btn-primary" type="submit">Connexion</button>
                                </div>
                            </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

</div>


<script>

        $("#logbox").slideToggle(1500);
        function backgroundScroll(el, width, speed){
            el.animate({'background-position' : '-'+width+'px'}, speed, 'linear', function(){
                el.css('background-position','0');
                backgroundScroll(el, width, speed);
            });
        }
        // 948 represents the width of the image in pixels and 60000 represents the speed it scrolls
        backgroundScroll($('#loginjumb'), 948, 70000);


        $('#login_form').on('submit', function(e) { //use on if jQuery 1.7+
            $("#logbox").slideToggle(1500);
        });



</script>