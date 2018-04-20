<?php

namespace app\rbac\rules;
 
use Yii;
use yii\rbac\Rule;
 
class UserGroupRule extends Rule
{
    public $name = 'userGroup';
 
    public function execute($user_id, $item, $params)
    {
        if (\Yii::$app->user->isGuest) return false;

        // Fetch list user roles and filter it by comparision.
        $ar_roles = \Yii::$app->authManager->getRolesByUser($user_id);
        //var_dump($ar_roles); 
        //var_dump($item);

        $ar_roles_filter = array_filter(array_keys($ar_roles), function($value) use ($item) {
            return $value == $item->name;
        });

        //var_dump($ar_roles_filter);

        return in_array($item->name, $ar_roles_filter);
    }
}