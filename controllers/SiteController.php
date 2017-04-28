<?php

namespace app\controllers;

use app\models\Link;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Link();
        
        return $this->render('index', [
			'model' => $model,
        ]);
    }
    
    /**
     * Получение короткой ссылки черех Ajax
     * 
     * return string
     */
    public function actionShorten()
    {
		$model = new Link();
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $model->shortLink;
		} else {
			return 'Error';
		}
	}
}
