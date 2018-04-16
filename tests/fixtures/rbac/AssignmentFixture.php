<?php
namespace app\tests\fixtures\rbac;
use yii\test\ActiveFixture;

class AssignmentFixture extends ActiveFixture
{
    public function init()
    {
        $this->db = \Yii::$app->db;

        $authManager = \Yii::$app->authManager;
        $this->tableName = $authManager->assignmentTable;
    }
}
