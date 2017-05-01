<?php

namespace app\components\helpers;

/**
 * Класс-помощник для формирования конфигурации для переводов сообщений
 */
class I18nConfigurator
{
	/**
	 * Получает конфигрурацию по умолчанию
	 * 
	 * @param string $dir Директория, из которой вызывается конфигуратор
	 * @return array
	 */
	private static function getDefaultConfig($dir)
	{
		return [
			/**
			 * String, required, root directory of all source files
			 */
			'sourcePath' => $dir . DIRECTORY_SEPARATOR . '..',
			
			/**
			 * Array, required, list of language codes that the extracted messages
			 * should be translated to. For example, ['zh-CN', 'de'].
			 */
			'languages' => ['ru-RU'],
			
			/**
			 * Boolean, whether to sort messages by keys when merging new messages
			 * with the existing ones. Defaults to false, which means the new (untranslated)
			 * messages will be separated from the old (translated) ones.
			 */
			'sort' => false,
			
			/**
			 * Boolean, whether to remove messages that no longer appear in the source code.
			 * Defaults to false, which means these messages will NOT be removed.
			 */
			'removeUnused' => false,
			
			/**
			 * Boolean, whether to mark messages that no longer appear in the source code.
			 * Defaults to true, which means each of these messages will be enclosed with a pair of '@@' marks.
			 */
			'markUnused' => true,
			
			/**
			 * Array, list of patterns that specify which files (not directories) should be processed.
			 * If empty or not set, all files will be processed.
			 * Please refer to "except" for details about the patterns.
			 */
			'only' => ['*.php'],
			
			/**
			 * Array, list of patterns that specify which files/directories should NOT be processed.
			 * If empty or not set, all files/directories will be processed.
			 * A path matches a pattern if it contains the pattern string at its end. For example,
			 * '/a/b' will match all files and directories ending with '/a/b';
			 * the '*.svn' will match all files and directories whose name ends with '.svn'.
			 * and the '.svn' will match all files and directories named exactly '.svn'.
			 * Note, the '/' characters in a pattern matches both '/' and '\'.
			 * See helpers/FileHelper::findFiles() description for more details on pattern matching rules.
			 * If a file/directory matches both a pattern in "only" and "except", it will NOT be processed.
			 */
			'except' => [
				'.svn',
				'.git',
				'.gitignore',
				'.gitkeep',
				'.hgignore',
				'.hgkeep',
				'/messages',
				'/vendor',
			],

			/**
			 * 'php' output format is for saving messages to php files.
			 */
			'format' => 'php',
			
			/**
			 * Root directory containing message translations.
			 */
			'messagePath' => $dir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages',
			
			/**
			 * Boolean, whether the message file should be overwritten with the merged messages
			 */
			'overwrite' => true,

			/**
			 * Message categories to ignore
			 */
			'ignoreCategories' => [
				'yii',
			],
		];
	}
	
	/**
	 * Получает конфигурацию для системы
	 * 
	 * @param string $dir Директория, из которой вызывается конфигуратор
	 * @return array
	 */
	public static function getApp($dir)
	{
		return array_merge(self::getDefaultConfig($dir), [
			/**
			 * String, the name of the function for translating messages.
			 * Defaults to 'Yii::t'. This is used as a mark to find the messages to be
			 * translated. You may use a string for single function name or an array for
			 * multiple function names.
			 */
			'translator' => 'Yii::t',
		]);
	}
	
	/**
	 * Получает конфигурацию для модуля
	 * 
	 * @param string $dir Директория, из которой вызывается конфигуратор
	 * @return array
	 */
	public static function getModule($dir)
	{
		return array_merge(self::getDefaultConfig($dir), [
			/**
			 * String, the name of the function for translating messages.
			 * Defaults to 'Yii::t'. This is used as a mark to find the messages to be
			 * translated. You may use a string for single function name or an array for
			 * multiple function names.
			 */
			'translator' => 'Module::t',
		]);
	}
}