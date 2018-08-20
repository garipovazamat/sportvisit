<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.02.16
 * Time: 2:13
 */

namespace console\controllers;


use common\models\Event;
use common\models\Image;
use common\models\News;
use common\models\Request;
use frontend\models\OrganizationForm;
use yii\console\Controller;

class TestController extends Controller
{

    public function actionIndex(){
        $auth = \Yii::$app->authManager;
        $create_many_orgs = $auth->createPermission('createOrgs');
        $create_many_orgs->description = 'Право создавать много органиаций';
        $auth->add($create_many_orgs);

        $admin = $auth->getRole('admin');
        $auth->addChild($admin, $create_many_orgs);

        return 1;
    }
}