<?php

namespace frontend\controllers;

use common\models\Image;
use frontend\models\UserForm;
use Yii;
use common\models\User;
use yii\web\UploadedFile;

class UserController extends \yii\web\Controller
{
    public function actionIndex($id = null)
    {
        if(Yii::$app->user->isGuest)
            return $this->goHome();
        if($id == null)
            $model = Yii::$app->user->identity;
        else
            $model = User::findById($id);
        return $this->render('index', ['model' => $model]);
    }

    public function actionUpdate(){
        $userId = Yii::$app->user->id;
        $model = new UserForm();
        $user = $model->loadUser($userId);
        $photo = new Image();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $photo->imageFile = UploadedFile::getInstance($photo, 'imageFile');
            if(isset($photo->imageFile)) {
                $url = $photo->upload();
                $user->avatar_url = $url;
            }
            $model->updateUser($user);
            return $this->redirect($user->getUrlProfile());
        }
        return $this->render('update', ['model' => $model, 'photo' => $photo]);
    }

}
