<?php


class PicsController extends AppController {

    public function index() {

        if($this->Auth->loggedIn())
        {
            $this->redirect('myflow');
        }
        else
        {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }


    }



    public function myflow() {


        if(!$this->Auth->loggedIn())
        {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $idfolder = 1;

        $this->set('idup', $this->Auth->user('id'));
        $this->set('idfolder', $idfolder);

        $UserPics = $this->Pic->find('all', array(
            'conditions' => array('Pic.user_id' => $this->Auth->user('id'), 'Pic.album_id' => 'UserIndex'),
            'order' => 'created DESC'
        ));

        $this->loadModel('Album');
        $UserAlbums = $this->Album->find('all', array(
            'conditions' => array('Album.user_id' => $this->Auth->user('id'), 'Album.parent_album' => null),
            'order' => 'created DESC'
        ));


        $this->set('UserPics', $UserPics);
        $this->set('UserAlbums', $UserAlbums);
        $this->set('userid', $this->Auth->user('id'));
        $this->set('background', $this->Auth->user('wallbackground'));




    }




    public function userflow() {

        if(!$this->Auth->loggedIn())
        {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $idfolder = 1;



            $this->set('idup', $this->request['pass'][0]);
            $this->set('idfolder', $idfolder);

            $UserPics = $this->Pic->find('all', array(
                'conditions' => array('Pic.user_id' => $this->request['pass'][0], 'Pic.album_id' => 'UserIndex'),
                'order' => 'created DESC'
            ));

            $this->loadModel('Album');
            $UserAlbums = $this->Album->find('all', array(
                'conditions' => array('Album.user_id' => $this->request['pass'][0], 'Album.parent_album' => null, 'Album.private' => 0),
                'order' => 'created DESC'
            ));

            $this->loadModel('User');
            $userData = $this->User->find('list', array(
                'fields' => array('User.username'),
                'conditions' => array('User.id' => $this->request['pass'][0])
            ));

            $this->set('UserPics', $UserPics);
            $this->set('UserAlbums', $UserAlbums);
            $this->set('userid', $this->request['pass'][0]);
            $this->set('user_username', $userData[$this->request['pass'][0]]);




        //verif Friends (aff add butt)
        $this->loadModel('Friend');

        // Check 1
        $conditions1 = array(

            "AND" => array(
                'Friend.user1_id' => $this->request['pass'][0],
                'Friend.user2_id' => $this->Auth->user('id')
            )

        );

        $UserFriend1 = $this->Friend->find('first', array(
                'conditions' => $conditions1 )
        );


        // Check 2
        $conditions2 = array(

            "AND" => array(
                'Friend.user1_id' => $this->Auth->user('id'),
                'Friend.user2_id' => $this->request['pass'][0]
            )

        );

        $UserFriend2 = $this->Friend->find('first', array(
                'conditions' => $conditions2 )
        );


        if( isset($UserFriend1['Friend']) || isset($UserFriend2['Friend']) )
        {
            $friend = 1;
        }
        else
        {
            $friend = 0;
        }


        $this->set('friend', $friend);





    }


    function upload()
    {


        $output_dir = DOCROOT."img\\users\\picstock\\upload\\".$this->request['pass'][0].'\\';

        $valid_exts = array('jpeg', 'jpg', 'png');
        $max_file_size = 1600 * 1024; #1600kb
        $nw = $nh = 2000; # image with & height

        if(isset($_FILES["files"]))
        {

            $arrayData = array();
            for($i=0; $i < count($_FILES['files']['name']); $i++)
            {
                $arrayData[$i]['myfile']['name'] = $_FILES['files']['name'][$i];
                $arrayData[$i]['myfile']['type'] = $_FILES['files']['type'][$i];
                $arrayData[$i]['myfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $arrayData[$i]['myfile']['error'] = $_FILES['files']['error'][$i];
                $arrayData[$i]['myfile']['size'] = $_FILES['files']['size'][$i];
            }

            $return ='';

            foreach($arrayData as $file)
            {




                    $ext = strtolower(pathinfo($file['myfile']['name'], PATHINFO_EXTENSION));
                    # file type validity
                    if (in_array($ext, $valid_exts))
                    {

                        if ($file["myfile"]["error"] > 0 || $file['myfile']['size'] > $max_file_size)
                        {
                            echo "La taille de votre fichier est trop élevé.";
                        }
                        else
                        {
                            $rand = uniqid();
                            $newname= $rand . $file["myfile"]["name"];
                            $resrec = move_uploaded_file($file["myfile"]["tmp_name"],$output_dir. $newname);


                            //thumb
                            $xmax = 200;
                            $ymax = 700;
                            $ext = explode(".", $newname);
                            $ext = $ext[count($ext)-1];

                            if($ext == "jpg" || $ext == "jpeg")
                                $im = imagecreatefromjpeg($output_dir.$newname);
                            elseif($ext == "png")
                                $im = imagecreatefrompng($output_dir.$newname);
                            elseif($ext == "gif")
                                $im = imagecreatefromgif($output_dir.$newname);

                            $x = imagesx($im);
                            $y = imagesy($im);

                            if($x <= $xmax && $y <= $ymax)
                            {
                                //-- no resize
                                $im2 = $im;
                            }
                            else
                            {

                                    $newx = $xmax;
                                    $newy = $newx * $y / $x;


                                $im2 = imagecreatetruecolor($newx, $newy);
                                imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);

                            }

                            $extension = pathinfo($newname, PATHINFO_EXTENSION);

                            if (preg_match("/png/",$extension))
                            {
                                imagepng($im2,$output_dir.'thumbnail\\'.$newname);
                            }
                            else
                            {
                                imagejpeg($im2,$output_dir.'thumbnail\\'.$newname,200);
                            }
                            //--




                            //bdd
                            $arrayParams = array();

                            $arrayParams['Pic']['user_id'] = $this->Auth->user('id');
                            $arrayParams['Pic']['name'] = $file['myfile']["name"];
                            $arrayParams['Pic']['url'] = $newname;
                            $arrayParams['Pic']['url_thumb'] = $output_dir.'thumbnail\\'.$newname;
                            $arrayParams['Pic']['album_id'] = $_POST['rep'];

                            $arrayParams['Pic']['id'] = null;


                            if($this->Pic->save($arrayParams, true, array('user_id','name','url','url_thumb','album_id'))) {
                                $return .=  $this->Pic->id.'-1_1-';
                            }


                        }

                    }




            }

            echo $return;


        }




    }


    // AJAX



    public function record() {



        if ( $this->request->is('post') ) {


            $arrayParams['Pic'] = $this->request->data;

            $arrayParams['Pic']['id'] = null;


            if($this->Pic->save($arrayParams, true, array('user_id','name','url','url_thumb','album_id'))) {
                echo $this->Pic->id;
            }
        }



    }



    public function generateWall() {



        if ( $this->request->is('post') ) {


            $arrayParams = $this->request->data;
            $idpic = $arrayParams['id'];

            $UserPic = $this->Pic->find('first', array(
                'conditions' => array('Pic.id' => $idpic)
            ));


            $this->loadModel('Album');
            $UserAlbums = $this->Album->find('all', array(
                'conditions' => array('Album.user_id' => $this->Auth->user('id'), 'Album.id !=' => $UserPic['Pic']['album_id']),
                'order' => 'created ASC'
            ));


        }

        $this->set('UserPic', $UserPic);
        $this->set('userid', $this->Auth->user('id'));
        $this->set('UserAlbums', $UserAlbums);
        $this->set('navigerid', $this->Auth->user('id'));

    }


    public function loadAlbumPics() {


        $arrayParams = $this->request->data;
        $album_id = $arrayParams['AlbumID'];

        if( empty($arrayParams['iduser']) )
        {
            $idwalluser = $this->Auth->user('id');
            $friend = 0;
        }
        else
        {
            $idwalluser = $arrayParams['iduser'];

            //verif FriendsAcces
            $this->loadModel('Friend');

            // Check 1
            $conditions1 = array(

                "AND" => array(
                        'Friend.user1_id' => $idwalluser,
                        'Friend.user2_id' => $this->Auth->user('id')
                )

            );

            $UserFriend1 = $this->Friend->find('first', array(
                'conditions' => $conditions1 )
            );


            // Check 2
            $conditions2 = array(

                "AND" => array(
                    'Friend.user1_id' => $this->Auth->user('id'),
                    'Friend.user2_id' => $idwalluser
                )

            );

            $UserFriend2 = $this->Friend->find('first', array(
                    'conditions' => $conditions2 )
            );



            if( isset($UserFriend1['Friend']) || isset($UserFriend2['Friend']) )
            {
                $friend = 1;
            }
            else
            {
                $friend = 0;
            }





        }

        //verif Priv
        $this->loadModel('Album');
        $UserAlbum = $this->Album->find('first', array(
            'conditions' => array('Album.id' => $album_id)
        ));





        if(isset($UserAlbum['Album']))
        {

            //verif Friendaccess step 2
            if($UserAlbum['Album']['friends'] == 1 && $friend == 1)
            {
                $albumFriendAccess = 1;
            }
            else
            {
                $albumFriendAccess = 0;
            }



            if($UserAlbum['Album']['private'] == 0 || $UserAlbum['Album']['user_id'] == $this->Auth->user('id') || $albumFriendAccess == 1)
            {

                $UserPics = $this->Pic->find('all', array(
                    'conditions' => array('Pic.user_id' => $idwalluser, 'Pic.album_id' => $album_id),
                    'order' => 'created DESC'
                ));

                $this->loadModel('Album');
                $UserAlbums = $this->Album->find('all', array(
                    'conditions' => array('Album.user_id' => $this->Auth->user('id'), 'Album.id !=' => $album_id),
                    'order' => 'created ASC'
                ));

                $this->set('UserPics', $UserPics);
                $this->set('UserAlbums', $UserAlbums);
                //$this->set('parent_album', $parent_album);

                $private = 0;

            }
            else
            {
                $private = 1;
            }


        }
        else
        {
            $UserPics = $this->Pic->find('all', array(
                'conditions' => array('Pic.user_id' => $idwalluser, 'Pic.album_id' => $album_id),
                'order' => 'created DESC'
            ));

            $this->loadModel('Album');
            $UserAlbums = $this->Album->find('all', array(
                'conditions' => array('Album.user_id' => $this->Auth->user('id'), 'Album.id !=' => $album_id),
                'order' => 'created ASC'
            ));

            $this->set('UserPics', $UserPics);
            $this->set('UserAlbums', $UserAlbums);
            //$this->set('parent_album', $parent_album);

            $private = 0;
        }



        $this->set('userid', $idwalluser);
        $this->set('navigerid', $this->Auth->user('id'));
        $this->set('private', $private);





    }



    public function viewAlbum() {




        if ( $this->request->is('post') ) {


            $arrayParams = $this->request->data;
            $idpic = $arrayParams['id'];

            if( empty($arrayParams['iduser']) )
            {
                $idwalluser = $this->Auth->user('id');
            }
            else
            {
                $idwalluser = $arrayParams['iduser'];
            }

            if($idpic == 'UserIndex')
            {


                $this->loadModel('Album');
                $UserAlbums = $this->Album->find('all', array(
                    'conditions' => array('Album.user_id' => $idwalluser, 'Album.parent_album' => '0'),
                    'order' => 'created DESC'
                ));



                $this->set('UserAlbums', $UserAlbums);
                //$this->set('parent_album', $parent_album);
                $this->set('userid', $this->Auth->user('id'));
            }
            else
            {


                $this->loadModel('Album');
                $UserAlbums = $this->Album->find('all', array(
                    'conditions' => array('Album.user_id' => $idwalluser, 'Album.parent_album' => $idpic),
                    'order' => 'created DESC'
                ));



                $parent_album = $this->Album->find('first', array(
                    'conditions'=>array('id'=>$idpic),
                    'fields'=>array('parent_album')
                ));


                if( empty($parent_album['Album']['parent_album']))
                {
                    $parent_album['Album']['parent_album'] = 'UserIndex';
                }


                $this->set('UserAlbums', $UserAlbums);
                $this->set('parent_album', $parent_album);
                $this->set('userid', $this->Auth->user('id'));


            }



        }



    }





    public function addAlbum() {


        $arrayParams = $this->request->data;
        $albumname = $arrayParams['name'];
        $albumidparent = $arrayParams['idparent'];

        $this->loadModel('Album');

        $d['Album']['name'] = $albumname;
        $d['Album']['user_id'] = $this->Auth->user('id');
        $d['Album']['parent_album'] = $albumidparent;



        if($this->Album->save($d, true, array('name', 'user_id', 'parent_album')))
        {
            echo 'OK';
        }
        else
        {
            echo 'KO';
        }




    }









    function editPic() {

        $arrayParams = $this->request->data;

        $picid = $arrayParams['id'];
        $picname = $arrayParams['name'];
        $destalbum = $arrayParams['destAlbum'];


        $d['Pic']['id'] = $picid;
        $d['Pic']['name'] = $picname;
        $d['Pic']['album_id'] = $destalbum;



        if($this->Pic->save($d, true, array('id', 'name', 'album_id')))
        {
            echo 'OK';
        }
        else
        {
            echo 'KO';
        }


    }



    function delPic() {

        $arrayParams = $this->request->data;

        $picid = $arrayParams['id'];


        if($this->Pic->deleteAll(array('Pic.id' => $picid), false))
        {
            echo 'OK';
        }
        else
        {
            echo 'KO';
        }


    }

    function loadcoms() {

        $arrayParams = $this->request->data;

        $picid = $arrayParams['id'];

        $this->loadModel('Com');
        $PicComs = $this->Com->find('all', array(
            'conditions' => array('Com.pic_id' => $picid),
            'order' => 'Com.created ASC'
        ));







        $this->set('PicComs', $PicComs);
        $this->set('picid', $picid);




    }



    function addcom() {

        $arrayParams = $this->request->data;

        $picid = $arrayParams['id'];
        $comcontent = $arrayParams['content'];


        $d['Com']['id'] = null;
        $d['Com']['pic_id'] = $picid;
        $d['Com']['user_id'] = $this->Auth->user('id');
        $d['Com']['content'] = $comcontent;


        $this->loadModel('Com');
        if($this->Com->save($d, true, array('id', 'pic_id', 'user_id', 'content')))
        {
            echo 'OK';
        }
        else
        {
            echo 'KO';
        }



    }




    function setalbumpriv() {

        $arrayParams = $this->request->data;

        $albumid = $arrayParams['id'];


        $d['Album']['id'] = $albumid;
        $d['Album']['private'] = 1;


        $this->loadModel('Album');
        if($this->Album->save($d, true, array('id', 'private')))
        {
            echo 'OK';
        }
        else
        {
            echo 'KO';
        }


    }


    function setfriendable() {

        $arrayParams = $this->request->data;

        $albumid = $arrayParams['id'];
        $op = $arrayParams['op'];

        if($op == 1)
        {
            $d['Album']['id'] = $albumid;
            $d['Album']['friends'] = 1;


            $this->loadModel('Album');
            if($this->Album->save($d, true, array('id', 'friends')))
            {
                echo 'OK';
            }
            else
            {
                echo 'KO';
            }
        }
        else
        {
            $d['Album']['id'] = $albumid;
            $d['Album']['friends'] = 0;


            $this->loadModel('Album');
            if($this->Album->save($d, true, array('id', 'friends')))
            {
                echo 'OK';
            }
            else
            {
                echo 'KO';
            }
        }




    }




}

?>