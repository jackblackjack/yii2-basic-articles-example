<?php
namespace app\rbac\rules;
 
use Yii;
use yii\rbac\Rule;
 
class UserGroupRule extends Rule
{
    public $name = 'userGroup';
 
    public function execute($user, $item, $params)
    {
        if (\Yii::$app->user->isGuest) return false;

        $ar_roles = \Yii::$app->authManager->getRolesByUser($user);
        $ar_roles_filter = array_filter(array_keys($ar_roles), function($value) use ($item) { 
            return $value === $item->name;
        });

        return in_array($item->name, $ar_roles_filter);
    }
}