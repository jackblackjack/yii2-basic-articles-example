<?php
return [
    [ 'name' => 'guest', 'type' => 1, 'rule_name' => 'userGroup', 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'user', 'type' => 1, 'rule_name' => 'userGroup', 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'editor', 'type' => 1, 'rule_name' => 'userGroup', 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'admin', 'type' => 1, 'rule_name' => 'userGroup', 'created_at' => time(), 'updated_at' => time() ],

    // common
    [ 'name' => 'error', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'login', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'logout', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'sign-up', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'view', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],

    // articles
    [ 'name' => 'articleCreateNew', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'articleEditExist', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],

    [ 'name' => 'articleCanDeleteIfOwner', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'articleCanEditIfOwner', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
    
    [ 'name' => 'articleCanDelete', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
    
    [ 'name' => 'articleCanViewFull', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],

    // user
    [ 'name' => 'userCreateNew', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'userEditExist', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
    [ 'name' => 'userCanDelete', 'type' => 2, 'rule_name' => NULL, 'created_at' => time(), 'updated_at' => time() ],
];
