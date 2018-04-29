<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    /**
     * {@inheritDoc}
     */
    public $modelClass = 'app\models\User';

    /**
     * {@inheritDoc}
     */
    public $dataFile = '@app/tests/_data/user_data.php';
}