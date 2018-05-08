<?php
namespace app\tests\fixtures\user_notice;

use yii\test\ActiveFixture;

class NoticeTypeFixture extends ActiveFixture
{
    /**
     * {@inheritDoc}
     */
    public $modelClass = 'app\models\NoticeType';

    /**
     * {@inheritDoc}
     */
    public $dataFile = '@app/tests/_data/notice_type_data.php';
}