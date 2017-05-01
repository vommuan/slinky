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
     * Начальная короткая ссылка
     */
    const START_SHORT_LINK = '0000';
    
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
		
		return true;
	}
	
	/**
	 * Получает список допустимых символов для сокращенной ссылки
	 * 
	 * @return array
	 */
	private function getSymbols()
	{
		$symbols = array_merge(
			array_map(
				function($value) {
					return (string) $value;
				},
				range(0, 9)
			),
			range('a', 'z')
		);
		
		if ('mysql' !== $this->db->driverName) {
			$symbols = array_merge($symbols, range('A', 'Z'));
		}
		
		sort($symbols);
		
		return $symbols;
	}
	
	/**
	 * Получает запись о последней ссылке из базы данных
	 * 
	 * @return string
	 */
	private function getLastLink()
	{
		return self::find()->orderBy(['id' => SORT_DESC])->limit(1)->one();
	}
	
	/**
	 * Получает следующую короткую ссылку
	 * 
	 * @param string $currentLink Текущая ссылка
	 * @return string
	 */
	private function getNextShortLink($currentLink)
	{
		$symbols = $this->getSymbols();
		$lastSymbolIndex = count($symbols) - 1;
		
		if ('' === $currentLink) {
			return $symbols[0];
		}
		
		$lastLinkSymbol = substr($currentLink, -1);
		$currentLink = substr($currentLink, 0, -1);
		
		$lastLinkSymbolIndex = array_search($lastLinkSymbol, $symbols);
		
		if ($lastLinkSymbolIndex == $lastSymbolIndex) {
			return $this->getNextShortLink($currentLink) . $symbols[0];
		} else {
			return $currentLink . $symbols[$lastLinkSymbolIndex + 1];
		}
	}
	
	/**
	 * Генерирует коротку ссылку
	 */
	private function generateShortLink()
	{
		if (!empty($this->shortLink)) {
			return;
		}
		
		$lastLink = $this->getLastLink();
		
		if (!isset($lastLink)) {
			$this->shortLink = self::START_SHORT_LINK;
			return;
		}
		
		$this->shortLink = $this->getNextShortLink($lastLink->shortLink);
	}
}
