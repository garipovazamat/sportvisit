<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.02.16
 * Time: 11:15
 */

namespace frontend\controllers;

use common\models\Organization;
use common\models\OrgSport;
use common\models\Request;
use frontend\models\SearchOrganization;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\View;

class OrganizationController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(){
        $searchOrg = new SearchOrganization();
        $request = Yii::$app->request->queryParams;
        $dataProvider = $searchOrg->search($request);
        return $this->render('index', [
            'searchModel' => $searchOrg,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate(){
        $user = Yii::$app->user;
        if($user->isGuest)
            return $this->redirect(['site/login']);
        if($user->identity->isHaveOrg() && !$user->can('createOrgs'))
            throw new ForbiddenHttpException("У вас уже есть организация");

        $org = new Organization();
        $sport = new OrgSport();
        $request = Yii::$app->request->post();
        if($org->load($request) && $org->validate()){
            $transact = Yii::$app->db->beginTransaction();
            $sport->load($request);
            if($org->save()){
                if(!empty($sport->id_sport)) {
                    $sport->id_org = $org->id;
                    $sport->save();
                }
                $transact->commit();
            }
            else $transact->rollBack();
            return $this->redirect(['organization/index']);
        }
        return $this->render('create', ['model' => $org,
            'sport' => $sport]);
    }

    public function actionUpdate($id){
        $org = Organization::findOrgById($id);
        if(!$org->isOwner())
            throw new ForbiddenHttpException("Вы не являетесь владельцем организации, либо не авторизованны");

        if(isset($sport[0]))
            $sport = $org->sports[0];
        else
            $sport = new OrgSport();
        $request = Yii::$app->request->post();
        if($org->load($request) && $org->validate()) {
            $transact = Yii::$app->db->beginTransaction();
            $sport->load($request);
            if ($org->save()) {
                if (!empty($sport->id_sport)) {
                    $sport->id_org = $org->id;
                    $sport->save();
                }
                $transact->commit();
            } else $transact->rollBack();
            return $this->redirect(['organization/index']);
        }
        return $this->render('update', ['model' => $org,
            'sport' => $sport]);
    }

    public function actionView($id){
        $model = Organization::findOrgByShortUrl($id);
        return $this->render('view', ['model' => $model]);
    }

    public function actionPanel($id_event){

    }
}