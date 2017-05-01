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
     * @var array Допустимые символы для сокращенной ссылки
     */
    private $symbols;
    
    /**
     * @var integer Количество допустимых символов для сокращенной ссылки
     */
    private $symbolsNumber;
    
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
	 * Инициализирует список допустимых символов для сокращенной ссылки
	 * 
	 * @return array
	 */
	private function initSymbols()
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
		
		$this->symbols = $symbols;
		$this->symbolsNumber = count($symbols);
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
		if ('' === $currentLink) {
			return $this->symbols[0];
		}
		
		$lastLinkSymbol = substr($currentLink, -1);
		$currentLink = substr($currentLink, 0, -1);
		
		$lastLinkSymbolIndex = array_search($lastLinkSymbol, $this->symbols);
		
		if ($lastLinkSymbolIndex == $this->symbolsNumber - 1) {
			return $this->getNextShortLink($currentLink) . $this->symbols[0];
		} else {
			return $currentLink . $this->symbols[$lastLinkSymbolIndex + 1];
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
		
		$this->initSymbols();
		$this->shortLink = $this->getNextShortLink($lastLink->shortLink);
	}
}
