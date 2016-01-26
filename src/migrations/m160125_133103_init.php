<?php

use yii\db\Schema;
use yii\db\Migration;
use bupy7\notify\ss\Module;

/**
 * Initialization table of module.
 * @author Vasilij Belosludcev <https://github.com/bupy7>
 * @since 1.0.0
 */
class m160125_133103_init extends Migration
{
    /**
     * @var string
     */
    protected $tableName;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->tableName = Module::getInstance()->tableName;
    }
    
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'message' => Schema::TYPE_TEXT . ' NOT NULL',
            'type' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'recipient' => Schema::TYPE_INTEGER . ' NOT NULL',
            'readed' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->createIndex('index-1', $this->tableName, 'recipient');
        $this->createIndex('index-2', $this->tableName, 'readed');
        $this->createIndex('index-3', $this->tableName, 'created_at');
        $this->createIndex('index-4', $this->tableName, ['recipient', 'readed']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
