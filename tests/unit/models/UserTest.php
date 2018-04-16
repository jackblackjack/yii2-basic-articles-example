<?php

namespace tests\models;

use app\models\User;
use yii\helpers\{ Inflector, StringHelper};
use app\tests\fixtures\UserFixture;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * {@inheritdoc}
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user_data.php'
            ]
        ];
    }

    function testTableName()
    {
        $pseudo_name = '{{%' . Inflector::camel2id(StringHelper::basename('User'), '_') . '}}';
        $this->assertEquals($pseudo_name, User::tableName());	
    }

    public function testFindUserById()
    {
        $model = $this->getMockBuilder('\app\model\User')
                    ->setMethods(['getId'])
                    ->getMock();

        $model->expects($this->once())
            ->method('getId')
            ->will($this->returnCallback(function() { return 1; }));

        $this->assertEquals(1, $model->getId());
    }

    public function testFindUserByUsername()
    {
        $fixture_user = $this->tester->grabFixture('user', 0);

        expect_that($user = User::findByUsername($fixture_user['username']));
        expect($user->username)->equals($fixture_user['username']);
    }

    public function testFindUserByEmail()
    {
        $fixture_user = $this->tester->grabFixture('user', 0);

        expect_that($user = User::findByEmail($fixture_user['email']));
        expect($user->email)->equals($fixture_user['email']);
    }

    public function testFindByUsernameOrEmail_Username()
    {
        $fixture_user = $this->tester->grabFixture('user', 0);

        expect_that($user = User::findByUsernameOrEmail($fixture_user['username']));
        expect($user->username)->equals($fixture_user['username']);
        expect($user->email)->equals($fixture_user['email']);
    }

    public function testFindByUsernameOrEmail_Email()
    {
        $fixture_user = $this->tester->grabFixture('user', 0);

        expect_that($user = User::findByUsernameOrEmail($fixture_user['email']));
        expect($user->email)->equals($fixture_user['email']);
        expect($user->username)->equals($fixture_user['username']);
    }

    public function testSetPassword()
    {
        expect_that($user = new User());

        $generated_password = md5(uniqid('', true));
        expect($user->setPassword($generated_password));

        expect_that($user->validatePassword($generated_password));
        expect_not($user->validatePassword(md5(uniqid('', true))));
    }

    public function testGenerateAuthKey()
    {
        expect_that($user = new User);

        $user->auth_key = null;
        expect_not($user->auth_key);

        $user->generateAuthKey();
        $this->assertNotEmpty($user->auth_key);
    }
}
