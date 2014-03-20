<?php


class SearchController extends AppController {

    public function user() {

        if( isset($this->request['pass'][0]))
        {
            $searchkey = $this->request['pass'][0];
        }
        else
        {
            $arrayParams = $this->request->data;
            $searchkey = $arrayParams['searchkey'];
        }



        $conditions = array('User.username LIKE' => '%'.$searchkey.'%');

        $this->loadModel('User');
        $searchres = $this->User->find('all', array(
            'conditions' => $conditions,
            'order' => 'username DESC'
        ));


        $this->set('searchres', $searchres);



        $conditions2 = array('Album.name LIKE' => '%'.$searchkey.'%', 'Album.private' => 0);

        $this->loadModel('Album');
        $searchresalbum = $this->Album->find('all', array(
            'conditions' => $conditions2,
            'order' => 'name DESC'
        ));


        $this->set('searchresalbum', $searchresalbum);



    }



}
?>