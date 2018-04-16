<?php

namespace tests\rbac;

use yii\rbac\Item;
use yii\rbac\Permission;
use yii\rbac\Role;
use yii\rbac\Rule;
#use app\models\User;

use app\rbac\rules\{UserGroupRule, IsOwnerRule};
use app\tests\fixtures\rbac\{RuleFixture, ItemFixture, ItemChildFixture, AssignmentFixture};

class RolesTest extends \Codeception\Test\Unit
{
    /**
     * {@inheritdoc}
     */
    public function _fixtures()
    {
        return [
            'assignment' => [
                'class' => AssignmentFixture::className(),
                'dataFile' => codecept_data_dir() . '/rbac/assigment_data.php',
            ],
            'rule' => [
                'class' => RuleFixture::className(),
                'dataFile' => codecept_data_dir() . '/rbac/auth_rule_data.php',
            ],
            'item' => [
                'class' => ItemFixture::className(),
                'dataFile' => codecept_data_dir() . '/rbac/auth_item_data.php',
            ],
            'item_child' => [
                'class' => ItemChildFixture::className(),
                'dataFile' => codecept_data_dir() . '/rbac/auth_item_child_data.php',
            ]
        ];
    }

    public function testDummy()
    {
    }
}
