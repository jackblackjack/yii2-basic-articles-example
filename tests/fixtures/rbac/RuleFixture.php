<?php
namespace app\tests\fixtures\rbac;

use yii\test\ActiveFixture;

class RuleFixture extends ActiveFixture
{
    public function init()
    {
        $this->db = \Yii::$app->db;

        $authManager = \Yii::$app->authManager;
        $this->tableName = $authManager->ruleTable;
    }
}