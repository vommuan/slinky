<?php

use yii\db\Migration;

class m170428_120326_links_table extends Migration
{
    public function safeUp()
    {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%link}}', [
			'id' => $this->primaryKey(),
			'link' => $this->text()->notNull(),
			'shortLink' => $this->string()->notNull()->unique(),
		], $tableOptions);
    }

    public function safeDown()
    {
		$this->dropTable('{{%link}}');
    }
}
