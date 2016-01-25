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
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'message' => Schema::TYPE_TEXT . ' NOT NULL',
            'type' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'recipient' => Schema::TYPE_INTEGER . ' NOT NULL',
            'readed' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
