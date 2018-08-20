<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.02.16
 * Time: 14:04
 */

namespace console\controllers;


use yii\console\Controller;
use Yii;

class RbacController extends Controller
{

    public function actionInit(){
        Yii::$app->authManager->removeAllRoles();

        $role = Yii::$app->authManager->createRole('user');
        $role->description = 'Юзер';
        Yii::$app->authManager->add($role);

        $role = Yii::$app->authManager->createRole('moder');
        $role->description = 'Модератор';
        Yii::$app->authManager->add($role);

        $role = Yii::$app->authManager->createRole('admin');
        $role->description = 'Админ';
        Yii::$app->authManager->add($role);
    }
}