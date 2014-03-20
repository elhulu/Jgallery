




                <li class="flowitem" style="position: absolute; left: 95px; top: 10px; display: list-item;" id="li<?php echo $UserPic['Pic']['id']; ?>">
                    <a class="picsLightLink" href="#data<?php echo $UserPic['Pic']['id']; ?>">
                        <img src="/pepi/my_jGallery/img/users/picstock/upload/<?php echo $userid; ?>/thumbnail/<?php echo basename($UserPic['Pic']['url_thumb']); ?>" alt=""/>

                    </a>
                </li>



            <div style="display:none; width:auto;height:auto;overflow: auto;position:relative;">
                <div id="data<?php echo $UserPic['Pic']['id']; ?>">
                    <div class="FSmain">
                        <div class="FSimg"><img src="/pepi/my_jGallery/img/users/picstock/upload/<?php echo $userid; ?>/<?php echo basename($UserPic['Pic']['url']); ?>" alt=""/></div>
                        <div class="FScomsmain" id="FScomsmain<?php echo $UserPic['Pic']['id']; ?>"></div>


                        <div class="FStext">
                            <div class="flowitemtext">
                                <?php
                                App::uses('String', 'Utility');
                                echo String::truncate($UserPic['Pic']['name'], 40,array('ellipsis' => ' ...','exact' => true) );
                                ?>
                            </div>
                        </div>

                        <?php if($navigerid == $UserPic['Pic']['user_id']){ ?>


                            <div class="FSoptions">
                                <i class="glyphicon glyphicon-edit FSoptionbuttEdit" id="FSoptionEdit<?php echo $UserPic['Pic']['id']; ?>"></i>
                                <i class="glyphicon glyphicon-remove FSoptionbuttDel" id="FSoptionDel<?php echo $UserPic['Pic']['id']; ?>"></i>
                            </div>

                        <?php } ?>

                        <div class="FSedit" id="FSedit<?php echo $UserPic['Pic']['id']; ?>">


                            <form id="FSeditform" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label formlabel" for="inputUsername">Nom</label>
                                    <div class="col-lg-11 forminput whitebox-input-input">
                                        <input id="editinputname<?php echo $UserPic['Pic']['id']; ?>" class="form-control" type="text" placeholder="<?php echo $UserPic['Pic']['name']; ?>" name="name" value="<?php echo $UserPic['Pic']['name']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label formlabel" for="LocationSelect">Déplacer l'image</label>
                                    <div class="col-lg-11 forminput whitebox-input-input">
                                        <select id="LocationSelect<?php echo $UserPic['Pic']['id']; ?>" class="form-control">
                                            <option value="<?php echo $UserPic['Pic']['album_id']; ?>" selected="selected">- Selectionnez un album -</option>
                                            <?php foreach($UserAlbums as $album): ?>
                                                <option value="<?php echo $album['Album']['id']; ?>"><?php echo $album['Album']['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </form>

                            <div class="form-group col-lg-11 margt">
                                <button id="FSeditbutt<?php echo $UserPic['Pic']['id']; ?>" class="addfirendLink btn btn-success FSeditbutt">
                                    <i class="glyphicon glyphicon-edit"></i>
                                    Modifier
                                </button>
                            </div>



                        </div>


                        <div class="FSdel" id="FSdel<?php echo $fields['Pic']['id']; ?>">
                            <img src="/pepi/my_jGallery/img/loadingAlbum.gif" alt=""/>
                        </div>
                    </div>
                </div>
            </div>

