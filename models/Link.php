<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%link}}".
 *
 * @property int $id
 * @property string $link
 * @property string $shortLink
 */
class Link extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%link}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link'], 'required'],
            [['link'], 'url', 'defaultScheme' => 'http'],
            
            [['shortLink'], 'required'],
            [['shortLink'], 'string', 'length' => [4, 255]],
            [['shortLink'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'link' => Yii::t('app', 'Link'),
            'shortLink' => Yii::t('app', 'Short Link'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
		if (!parent::beforeValidate()) {
			return false;
		}
		
		$this->generateShortLink();
	}
	
	/**
	 * Генерирует коротку ссылку
	 */
	private function generateShortLink()
	{
		if (!empty($this->shortLink)) {
			return;
		}
		
		// TODO: Алгоритм генерации короткой ссылки
	}
}