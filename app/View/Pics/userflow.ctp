<div class="jumbotron loginjumbotron flowbg" id="loginjumb">


    <div class="well addfriendbox" id="addfriendbox">

            <div class="confaddfriend">
                <button class="btn btn-primary" id="friendbuttok">
                    <i class="glyphicon glyphicon-ok"></i>
                    Ajouter <strong><?php echo $user_username; ?></strong> a mes amis.
                </button>

                <button class="btn btn-default" id="friendbuttcancel">
                    <i class="glyphicon glyphicon-remove"></i>
                    Annuler
                </button>
            </div>

    </div>

    <div class="well addfriendbox" id="addfriendboxres">



    </div>



    <div class="uploadbar" id="uploadbar">

        <div class="uploadbutt" id="uploadbutt">


            <?php if($friend == 0){ ?>
        <span class="fileinput-button addfirendcont" >

            <button id="addfriendbutt" class="addfirendLink btn btn-success" href="/pepi/my_jGallery/users/addfriend/<?php echo $userid; ?>">
                    <i class="glyphicon glyphicon-plus"></i>
                    Ajouter
                </button>
        </span>

            <div class="usernamediv">

                <button class="btn btn-default userbutt" type="button">
                <i class="glyphicon glyphicon-user"></i>
                <?php echo $user_username; ?>
                </button>

            </div>

            <?php } else { ?>

            <span class="fileinput-button addfirendcont" >

            <button  class="btn btn-success" >
                <i class="glyphicon glyphicon-user"></i>
                <?php echo $user_username; ?>
            </button>
        </span>


            <?php } ?>

        </div>

        <div class="albumslistmain" id="albumslistmain">

            <ul id="albumlist" class="kwicks kwicks-horizontal">
                <?php
                $iAlbums = 1;
                foreach($UserAlbums as $fields): ?>
                    <li id="album<?php echo $fields['Album']['id']; ?>">
                        <div class="albumdisplay" id="albumdisplay<?php echo $iAlbums; ?>">
                            <?php
                            App::uses('String', 'Utility');
                            echo String::truncate($fields['Album']['name'], 22,array('ellipsis' => ' ...','exact' => true) );
                            ?>
                        </div>
                    </li>
                    <?php
                    $iAlbums++;
                endforeach; ?>
            </ul>



        </div>


    </div>

    <div class="loaderPics">
        <img src="/pepi/my_jGallery/img/loadingdd.gif" alt=""/>
    </div>

    <div id="newtilesdiv">

        <ul id="newtiles">

        </ul>

    </div>

    <div id="flowcontent">

        <ul id="tiles">
            <?php
            $iIDs = 1;
            foreach($UserPics as $fields): ?>
                <li class="flowitem" style="position: absolute; left: 95px; top: 10px; display: list-item;" id="li<?php echo $iIDs; ?>">
                    <a class="picsLightLink" href="#data<?php echo $iIDs; ?>">
                        <img src="/pepi/my_jGallery/img/users/picstock/upload/<?php echo $userid; ?>/thumbnail/<?php echo basename($fields['Pic']['url_thumb']); ?>" alt=""/>

                    </a>
                </li>
                <?php
                $iIDs++;
            endforeach; ?>
        </ul>


        <?php
        $iIDs = 1;
        foreach($UserPics as $fields): ?>
            <div style="display:none; width:auto;height:auto;overflow: auto;position:relative;">
                <div id="data<?php echo $iIDs; ?>">
                    <div class="FSmain">
                        <div class="FSimg"><img src="/pepi/my_jGallery/img/users/picstock/upload/<?php echo $userid; ?>/<?php echo basename($fields['Pic']['url']); ?>" alt=""/></div>
                        <div class="FScomsmain">

                            <div class="ComMain">
                                <div class="ComHead"><span>Joss</span> ৹ 02/11/2013 13:10:12 </div>

                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <div class="ComContent">Ceci est mon commentaire !! J'espere que vous l'apprécierez !!</div>

                                    </div>
                                </div>
                            </div>
                            <div class="ComMain">
                                <div class="ComHead"><span>Joss</span> ৹ 02/11/2013 13:10:12 </div>

                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <div class="ComContent">Ceci est mon commentaire !! J'espere que vous l'apprécierez !!</div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="FStext">
                            <div class="flowitemtext">
                                <?php
                                App::uses('String', 'Utility');
                                echo String::truncate($fields['Pic']['name'], 40,array('ellipsis' => ' ...','exact' => true) );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $iIDs++;
        endforeach; ?>


    </div>


    <script type="text/javascript">
        var iduser = '<?php echo $userid; ?>';
        var contRoot = '<?php echo CONTROLLERROOT; ?>';
        var url = '/pepi/my_jGallery/img/users/picstock/upload/index.php?idup=<?php echo $idup; ?>';
    </script>

    <script type="text/javascript" src="/pepi/my_jGallery/js/userflow.js"></script>




</div>

