<?php

class User extends AppModel{

    public $hasMany = array(
        'Pic'
    );

    public $validate = array(
        'username' => array(
            array(
                'rule' => 'alphanumeric',
                'required' => true,
                'allowEmpty' => false,
                'message' => "Pseudo invalide."
            ),
            array(
                'rule'=> 'isUnique',
                'message' => 'Ce pseudo est déjà pris'
            )
        ),
        'mail' => array(
            array(
                'rule' => 'email',
                'required' => true,
                'allowEmpty' => false,
                'message' => "Email non valide."
            ),
            array(
                'rule'=> 'isUnique',
                'message' => 'Cet email est déjà utilisé.'
            )
        ),
        'password' => array(
                'rule'=> 'notEmpty',
                'message' => 'Merci de préciser un mot de passe.',
                'allowEmpty' => false
        )


    );

}

