<?php
use app\models\User;

return [
    [ 'item_name' => 'admin',  'user_id' => User::findByUsername('admin')->getId() ],
    [ 'item_name' => 'user',  'user_id' => User::findByUsername('demo')->getId() ],
    [ 'item_name' => 'editor',  'user_id' => User::findByUsername('editor')->getId() ]
];
