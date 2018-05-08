<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class ArticleFixture extends ActiveFixture
{
    /**
     * {@inheritDoc}
     */
    public $modelClass = 'app\models\Article';

    /**
     * {@inheritDoc}
     */
    public $dataFile = '@app/tests/_data/article_data.php';
}