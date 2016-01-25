<?php

namespace bupy7\notify\ss;

use Yii;
use yii\base\Module as BaseModule;
use yii\db\Connection;
use yii\di\Instance;

/**
 * Server-side module of notification extension.
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
class Module extends BaseModule
{
    /**
     * @var string Table name for saving the notification.
     */
    public $tableName = '{{%notification}}';
    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     */
    public $db = 'db';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
    }
}

