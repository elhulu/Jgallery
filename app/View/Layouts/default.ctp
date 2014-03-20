<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
    <script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>
    <script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<?php
		echo $this->Html->meta('icon');

    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('style');
    echo $this->Html->css('jquery.fileupload.css');
    echo $this->Html->css('jquery.kwicks.min.css');
    echo $this->Html->css('jquery.fancybox.css');
    echo $this->Html->css('jquery-ui-1.10.3.custom.min.css');
    echo $this->Html->css('jquery-impromptu.css');
    echo $this->Html->css('bootstrap-switch.css');




    echo $this->Html->script('jquery-1.10.2.min.js');
    echo $this->Html->script('bootstrap.js');
    echo $this->Html->script('jquery.wookmark.min.js');
    echo $this->Html->script('jquery.imagesloaded.js');
    echo $this->Html->script('jquery.ui.widget.js');
    echo $this->Html->script('jquery.fileupload.js');
    echo $this->Html->script('jquery.iframe-transport.js');
    echo $this->Html->script('jquery.fileupload-process.js');
    echo $this->Html->script('jquery.fileupload-image.js');
    echo $this->Html->script('jquery.fileupload-audio.js');
    echo $this->Html->script('jquery.fileupload-video.js');
    echo $this->Html->script('jquery.fileupload-validate.js');
    echo $this->Html->script('jquery.kwicks.min.js');
    echo $this->Html->script('fancybox/jquery.easing-1.3.pack.js');
    echo $this->Html->script('jquery.fancybox.js');
    echo $this->Html->script('fancybox/jquery.mousewheel-3.0.4.pack.js');
    echo $this->Html->script('jquery-ui-1.10.3.custom.js');
    echo $this->Html->script('alerts.js');
    echo $this->Html->script('jquery-impromptu.js');
    echo $this->Html->script('bootstrap-switch.min.js');




		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>



</head>
<body>

    <div class="header">
        <nav class="navbar navbar-default navbar-static-top topbar" role="navigation">

            <div class="collapse navbar-collapse navbar-ex1-collapse">

                <div class="navbarbrand"></div>

                <?php if(!AuthComponent::user('id')): ?>
                <ul class="nav navbar-nav">
                    <li class="activeb"><a href="/pepi/my_jGallery/users/signup" id="activba"><strong>Inscription</strong></a></li>
                    <li><?php echo $this->Html->link("Connexion",'/users/login'); ?></li>
                </ul>
                <?php endif; ?>

                <form class="navbar-form navbar-left" role="search" action="/pepi/my_jGallery/search/user/" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Rechercher" name="searchkey">
                    </div>
                    <button type="submit" class="btnb btn-default"><i class="glyphicon glyphicon-search"></i> </button>
                </form>

                <?php if(AuthComponent::user('id')): ?>

                <ul class="nav navbar-nav pull-right">
                    <li class="username"><?php echo USERNAME; ?></li>
                    <li class="activeb"><a href="/pepi/my_jGallery/pics/myflow" id="activba"><strong>Mes images</strong></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Compte <b class="caret"></b></a>
                        <ul class="dropdown-menu">

                                <li><?php echo $this->Html->link("Se déconnecter",'/users/logout'); ?></li>
                                <li><?php echo $this->Html->link("Informations personnelles",array('action'=>'edit','controller'=>'users')); ?></li>

                                <li id="friendsMenu">



                                </li>

                        </ul>
                    </li>

                </ul>
                <?php endif; ?>

            </div>


        </nav>
    </div>

	<div id="container">




        <div class="sub_container">

            <!-- Alerts  -->
            <?php
            if(!empty($freqs))
            {
                foreach($freqs as $freq)
                {
                    echo '
            <div class="well addfriendbox reqalert" id="alertfreq'.$freq['Friendreq']['id'].'">

                <p>
                    Demande d\'ajout a la liste d\'amis de <a href="/pepi/my_jGallery/pics/userflow/'.$freq['User']['id'].'">'.$freq['User']['username'].'</a>.
                </p>

                <button class="btn btn-primary alertbtnok" id="friendbuttok'.$freq['Friendreq']['id'].'">
                    <i class="glyphicon glyphicon-ok"></i>
                    Accepter
                    <strong>'.$freq['User']['username'].'</strong>
                </button>


                <button class="btn btn-default alertbtncancel" id="friendbuttcancel'.$freq['Friendreq']['id'].'">
                    <i class="glyphicon glyphicon-remove"></i>
                    Refuser
                </button>

            </div>';
                }

            }
            ?>


            <?php echo $this->fetch('content'); ?>
        </div>


	</div>




	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
