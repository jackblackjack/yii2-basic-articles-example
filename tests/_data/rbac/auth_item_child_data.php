<?php
return [
    [ 'parent' => 'guest', 'child' => 'error'],
    [ 'parent' => 'guest', 'child' => 'index'],
    [ 'parent' => 'guest', 'child' => 'login'],
    [ 'parent' => 'guest', 'child' => 'logout'],
    [ 'parent' => 'guest', 'child' => 'sign-up'],
    [ 'parent' => 'guest', 'child' => 'view'],

    [ 'parent' => 'user', 'child' => 'articleCanViewFull'],
    [ 'parent' => 'user', 'child' => 'small'],
    [ 'parent' => 'user', 'child' => 'small-test'],
    [ 'parent' => 'user', 'child' => 'guest'],

    [ 'parent' => 'editor', 'child' => 'articleCreateNew'],
    [ 'parent' => 'editor', 'child' => 'articleCanDeleteIfOwner'],
    [ 'parent' => 'editor', 'child' => 'articleCanEditIfOwner'],
    [ 'parent' => 'editor', 'child' => 'user'],
    
    [ 'parent' => 'admin', 'child' => 'articleEditExist'],
    [ 'parent' => 'admin', 'child' => 'articleCanDelete'],
    [ 'parent' => 'admin', 'child' => 'userCreateNew'],
    [ 'parent' => 'admin', 'child' => 'userEditExist'],
    [ 'parent' => 'admin', 'child' => 'userCanDelete'],
    [ 'parent' => 'admin', 'child' => 'editor']
];
