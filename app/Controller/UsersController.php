<?php


class UsersController extends AppController {

    public function index() {

        if($this->Auth->loggedIn())
        {
            $this->redirect(array('controller' => 'pics', 'action' => 'myflow'));
        }
        else
        {
            $this->redirect('login');
        }


    }

    public function signup() {


        $this->set('title_for_layout', $this->title_for_layout."Inscription");


        $this->Session->setFlash(null);

        if($this->request->is('post'))
        {

            $d = $this->request->data;

            $d['User']['id'] = null;
            $d['User']['email'] = $d['User']['mail'];


            if(!empty($d['User']['password']) && $d['User']['passwordconf'] == $d['User']['password'])
            {



                $d['User']['password'] = Security::hash($d['User']['password'], null, true);

                if($this->User->save($d, true, array('username', 'password', 'email')))
                {
                    $link = array('controller'=>'users','action'=>'activate',$this->User->id.'-'.md5($d['User']['username']));
                    App::uses('CakeEmail','Network/Email');
                    $mail = new CakeEmail();
                    $mail->from('noreply@localhost.com')
                         ->to($d['User']['mail'])
                         ->subject('Picflow • Validation de votre incription')
                         ->emailFormat('html')
                         ->template('signup')
                         ->viewVars(array('username'=>$d['User']['username'],'link'=>$link))
                         ->send();
                    $this->Session->setFlash("Votre compte a bien été créé","notif");
                    $this->request->data = array();
                    $this->Session->setFlash("Votre compte à été créé avec succes. Un email de verification vous a été envoyé.","notif", array('type' => 'success'));

                    mkdir(DOCROOT.'img/users/picstock/upload/'.$this->User->id, 0777);
                    mkdir(DOCROOT.'img/users/picstock/upload/'.$this->User->id.'/thumbnail', 0777);
                    $_SESSION['mailWaiting'] = '1';
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }
                else
                {

                    $errorChain = '';
                    foreach($this->User->invalidFields() as $field)
                    {
                        $errorChain .= '• '.$field[0].'<br>';
                    }
                    $this->Session->setFlash("<strong>Inscription incomplette.</strong><br>".$errorChain,"notif", array('type' => 'danger'));
                    //debug($this->User->invalidFields());
                }


            }
            else
            {
                $this->Session->setFlash("<strong>Inscription incomplette.</strong><br> Les mots de passes ne correspondent pas","notif", array('type' => 'danger'));
                //debug($this->User->invalidFields());
            }




        }




    }




    function activate($token){
        $token = explode('-',$token);
        $user = $this->User->find('first',array(
            'conditions' => array('id' => $token[0],'MD5(User.username)' => $token[1],'active' => 0)
        ));
        if(!empty($user)){
            $this->User->id = $user['User']['id'];
            $this->User->saveField('active',1);
            $this->Session->setFlash("Votre compte a bien été activé","notif");
            $this->Auth->login($user['User']);
        }else{
            $this->Session->setFlash("Ce lien d'activation n'est pas valide","notif",array('type'=>'error'));
        }
        $this->redirect('/');
        die();
    }


    function logout(){
        $this->Auth->logout();
        //$this->redirect($this->referer());
        $this->redirect('/');
    }


    function login(){


        if($this->request->is('post')){
            if($this->Auth->login()){
                $this->User->id =  $this->Auth->user("id");
                $this->User->saveField('lastlogin',date('Y-m-d H:i:s'));
                $this->Session->setFlash("vous êtes maintenant connecté","notif",array('type'=>'success'));
                $_SESSION['idup']= '12';
                $this->redirect(array('controller' => 'pics', 'action' => 'myflow'));
            }else{
                if( isset($_SESSION['mailWaiting']) && $_SESSION['mailWaiting'] == '1' )
                {
                    $this->Session->setFlash("Vous devez, tout d'abord, confirmer votre email. (un email vous à été envoyé à votre inscription.)","notif",array('type'=>'danger'));
                }
                else
                {
                    $this->Session->setFlash("Identifiants incorrects","notif",array('type'=>'danger'));
                }

            }
        }



    }



    function edit(){
        $user_id = $this->Auth->user('id');
        if(!$user_id){
            $this->redirect('/');
            die();
        }
        $this->User->id = $user_id;
        $passError = false;
        if($this->request->is('put') || $this->request->is('post')){
            $d = $this->request->data;
            $d['User']['id'] = $user_id;

            if(!empty($d['User']['pass1'])){
                if($d['User']['pass1']==$d['User']['pass2']){
                    $d['User']['password'] = Security::hash($d['User']['pass1'],null,true);
                }else{
                    $passError = true;
                }
            }

            if($passError){

                $this->User->validationErrors['pass2'] = array('Les mots de passe ne correspondent pas');
                $this->Session->setFlash("Les mots de passe ne correspondent pas.","notif",array('type'=>'danger'));
            }
            else
            {
                if($this->User->save($d,true,array('firstname','lastname','password','locality'))){
                    $this->Session->setFlash("Votre profil a bien été édité","notif",array('type'=>'success'));
                    $userdata = $this->User->read();
                    $this->set('data', $d);
                }else{
                    $this->Session->setFlash("Impossible d'enregistrer les modifications.<br><br> Merci de réessayer plus tard.","notif",array('type'=>'danger'));
                }

            }


        }else{
            $this->request->data = $this->User->read();
        }
        $this->request->data['User']['pass1'] = $this->request->data['User']['pass2'] = '';

        $userdata = $this->User->read();
        $this->set('data', $userdata);

    }



    function addfriend()
    {

        if( isset($this->request['pass'][0]) )
        {

            $target_id = $this->request['pass'][0];


            $this->loadModel('Friendreq');


            $d['Friendreq']['user_id'] = $this->Auth->user('id');
            $d['Friendreq']['target_id'] = $target_id;
            $d['Friendreq']['confirmed'] = '0';



            if($this->Friendreq->save($d, true, array('user_id', 'target_id', 'confirmed')))
            {
                echo 'OK';
            }
            else
            {
                echo "Impossible d'envoyer l'invitation.";
            }

            $this->set('user_id', $this->request['pass'][0]);


        }


    }


     function addfriendconf()
     {

            if( isset($this->request['pass'][0]) )
            {

                $freq_id = $this->request['pass'][0];
                $this->loadModel('Friendreq');
                $friendreq = $this->Friendreq->find('first', array(
                    'conditions' => array('Friendreq.id' => $freq_id)
                ));



                $this->loadModel('Friend');

                $d['Friend']['user1_id'] = $friendreq['Friendreq']['user_id'];
                $d['Friend']['user2_id'] = $friendreq['Friendreq']['target_id'];



                if( $this->Friend->save($d, true, array('user1_id', 'user2_id')) && $this->Friendreq->deleteAll(array('Friendreq.id' => $freq_id), false) )
                {
                    echo 'OK';
                }
                else
                {
                    echo "Impossible d'accepter cette invitation.";
                }

                $this->set('user_id', $this->request['pass'][0]);


            }


     }





    function addfriendcanc()
    {

                if( isset($this->request['pass'][0]) )
                {

                    $freq_id = $this->request['pass'][0];


                    $this->loadModel('Friendreq');


                    if($this->Friendreq->deleteAll(array('Friendreq.id' => $freq_id), false))
                    {
                        echo 'OK';
                    }
                    else
                    {
                        echo "Impossible d'envoyer l'invitation.";
                    }

                    $this->set('user_id', $this->request['pass'][0]);


                }


    }



    function friends()
    {

        $this->loadModel('Friend');

        $conditions = array(
            "OR" => array(
                'Friend.user1_id' => $this->Auth->user('id'),
                'Friend.user2_id' => $this->Auth->user('id')
            ));

        $UserFriends = $this->Friend->find('all', array(
            'conditions' => $conditions
        ));

        $arrayfriends = array();
        foreach($UserFriends as $friend)
        {
            if($friend["Friend"]["user1_id"] == $this->Auth->user('id'))
            {
                $arrayfriends[] = $this->User->find('all', array(
                    'conditions' => array('User.id' => $friend["Friend"]["user2_id"])
                ));

            }
            elseif($friend["Friend"]["user2_id"] == $this->Auth->user('id'))
            {
                $arrayfriends[] = $this->User->find('all', array(
                    'conditions' => array('User.id' => $friend["Friend"]["user1_id"])
                ));

            }

        }

        $this->set('friends', $arrayfriends);

    }









}

?>