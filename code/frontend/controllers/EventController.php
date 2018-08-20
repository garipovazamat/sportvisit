<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.02.16
 * Time: 23:07
 */

namespace frontend\controllers;

use common\models\Event;
use common\models\EventForm;
use common\models\Image;
use common\models\Request;
use frontend\models\SearchEvent;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use vova07\imperavi\actions\GetAction;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

class EventController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => Image::getCurrentUrl(), // Directory URL address, where files are stored.
                'path' => Image::getCurrentPath() // Or absolute path to directory where files are stored.
            ],
        ];
    }

    /**
     * @return bool|null|\common\models\User
     */
    public function getCurrentUser()
    {
        if (!Yii::$app->user->isGuest)
            return Yii::$app->user->identity;
        else return false;
    }

    public function actionCreate($isSection = false, $id_org)
    {
        $event = new EventForm();
        $event->isSection = $isSection;
        if ($event->load(Yii::$app->request->post()) && $event->validate()) {
            $event->user_id = $this->getCurrentUser()->id;
            if ($event->saveNew($id_org))
                return $this->redirect(['site/index']);
        }
        return $this->render('create', ['model' => $event]);
    }

    public function actionUpdate($id, $isSection = false)
    {
        $event = Event::findById($id);
        if (!$event->isAutor())
            throw new ForbiddenHttpException("У вас нет доступа к изменению мероприятия");
        $eventForm = new EventForm();
        $eventForm->loadEvent($event);
        $eventForm->isSection = $isSection;
        if ($eventForm->load(Yii::$app->request->post()) && $eventForm->validate()) {
            if ($eventForm->update())
                return $this->redirect($event->getViewUrl());
        }
        return $this->render('update', ['model' => $eventForm]);
    }

    public function actionIndex()
    {
        $searchEvent = new SearchEvent();
        //$searchEvent->cTime = time();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchEvent->search($params, false, true);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchEvent
        ]);
    }

    public function actionSection()
    {
        $searchEvent = new SearchEvent();
        //$searchEvent->cTime = time();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchEvent->search($params, true, true);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchEvent
        ]);
    }

    public function actionView($id)
    {
        $event = Event::findById($id);
        return $this->render('view', ['model' => $event]);
    }

    public function actionSendrequest($id_event)
    {
        $event = Event::findById($id_event);
        if (Yii::$app->user->isGuest) {
            $event->rememberUrl();
            return $this->redirect(['site/login']);
        }
        $request = Request::isEventRequest($id_event);
        if (!$request) {
            $post = Yii::$app->request->post();
            $form = new Request();
            $form->load($post);
            $request = $event->createRequest($form);
        } else $request->delete();
        return $this->redirect($event->getViewUrl());
    }

    public function actionEventsmap($isSection = false)
    {
        $eventsSearch = new SearchEvent();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $eventsSearch->search($params, $isSection, true);
        $events = $dataProvider->getModels();
        return $this->render('eventmap', [
            'events' => $events,
            'searchModel' => $eventsSearch
        ]);
    }

    public function actionEndsection($id)
    {
        $event = Event::findById($id);
        $cUserId = Yii::$app->user->id;
        if($event->org->id_user == $cUserId){
            $event->date_to = time();
            $event->save();
        }
        return $this->redirect($event->getViewUrl());
    }
}