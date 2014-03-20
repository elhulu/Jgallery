<div class="jumbotron loginjumbotron flowbg" id="loginjumb" <?php if( !empty($background) ){ echo "style=\"background: url('/pepi/my_jGallery/img/users/picstock/upload/".$userid."/".$background."')\""; } ?>>
<div id="bg">
    <div class="well addfriendbox" id="addfriendboxres">


    </div>

<div class="uploadbar" id="uploadbar">


    <div class="upbutts">

        <form id="myForm" action="/pepi/my_jGallery/pics/upload/<?php echo $idup; ?>" method="post" enctype="multipart/form-data">

            <div class="uploadbutt" id="uploadbutt">
            <span class="btn btn-success fileinput-button" >
                <i class="glyphicon glyphicon-plus"></i>
                <span>Ajouter une image</span>

                <input id="fileupload" size="80" type="file" name="files[]" multiple>
                <input type="hidden" value="UserIndex" name="rep" id="rep"/>
            </span>
            </div>

            <div class="upsuite">
                    <button id="fileuploadsend" class="addfirendLink btn btn-success">envoyer</button>
                    <div id="message"></div>
            </div>

        </form>

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

    <div class="addAlbumButtdiv">
        <div class="newAlbumInput">
            <input type="text" id="newAlbumName" class="form-controlsm"/>
        </div>
        <button id="newalbumbutt" class="btn btn-album">Nouvel album</button>

        <button id="privalbumbutt" class="btn btn-priv">Privatiser</button>

    <div class="switchmain">
            <div class="scitshlabel"> Accès amis :</div>
            <div id="switchfriend" class="make-switch switchfriend" style="display: inline-block" data-on="default" data-off="success">
                <input type="checkbox" id="friendcheckbox">
            </div>
    </div>


    </div>


    <div id="progress" class="progress">
        <div id="bar" class="progress-bar progress-bar-success"></div>
    </div>





    <div id="files" class="files"></div>

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

    <script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript">
    var iduser = '<?php echo $userid; ?>';
    var contRoot = '<?php echo CONTROLLERROOT; ?>';
    var url = '/pepi/my_jGallery/pics/upload/<?php echo $idup; ?>';


</script>

<script type="text/javascript" src="/pepi/my_jGallery/js/flow.js"></script>



</div>
</div>

