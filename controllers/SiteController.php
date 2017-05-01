<?php

namespace app\controllers;

use app\models\Link;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
			
			return $this->renderAjax('_shortLink', [
				'shortLink' => $model->shortLink,
			]);
		} else {
			$transaction->rollBack();
			
			return $this->renderAjax('_shortLinkError');
		}
	}
	
	/**
	 * Переход по короткой ссылке
	 * 
	 * @param string $sl Код короткой ссылки
	 */
	public function actionGo($shortLink)
	{
		$model = Link::findOne(['shortLink' => $shortLink]);
		
		if (!isset($model)) {
			throw new NotFoundHttpException(Yii::t('app', 'The requested page not found.'));
		}
		
		$this->redirect($model->link);
	}
}
