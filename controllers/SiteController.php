<?php

namespace app\controllers;

use app\models\Link;
use Yii;
use yii\helpers\Url;
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
		
		$transaction = Yii::$app->db->beginTransaction();
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$transaction->commit();
			return Url::to(['/' . $model->shortLink], true);
		} else {
			$transaction->rollBack();
			return Yii::t('app', 'Something went wrong. Please, try again later.');
		}
	}
}
