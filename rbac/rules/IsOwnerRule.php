<?php
namespace app\rbac\rules;
 
use Yii;
use yii\rbac\Rule;
 
class IsOwnerRule extends Rule
{
    public $name = 'isOwner';
    
    /**
     * @param string|integer $user ID пользователя.
     * @param Item $item роль или разрешение с которым это правило ассоциировано
     * @param array $params параметры, переданные в ManagerInterface::checkAccess(), например при вызове проверки
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['target']) ? $params['target']->createdBy == $user : false;
    }
}