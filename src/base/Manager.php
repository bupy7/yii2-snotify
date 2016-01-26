<?php

namespace bupy7\notify\ss\base;

use Yii;
use yii\base\Component;
use bupy7\notify\ss\forms\Notification;
use bupy7\notify\ss\Module;
use yii\db\Connection;
use yii\db\Query;

/**
 * Abstract class of manager notification component.
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
abstract class Manager extends Component
{
    /**
     * @var Notification[] Added notifications which will be flush to database.
     */
    protected $collection = [];
    /**
     * @var Module Instance of notify module class.
     */
    protected $module;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->module = Module::getInstance();
        register_shutdown_function([$this, 'flush']);
    }
    
    /**
     * Mark notification as readed.
     * @param integer|array $id Id(s) of notification(s). 
     * @return boolean
     */
    public function markAsReaded($id)
    {
        return (bool)$this->getDb()->createCommand()
            ->update($this->getTableName(), ['readed' => true], ['id' => $id])
            ->execute();
    }
    
    /**
     * Returns all unread notifications by recipient as an array.
     * @param integer $recipient Id of recipient.
     * @return array
     */
    public function findUnreadByRecipient($recipient)
    {
        return $this->findAll([
                'readed' => false,
                'recipient' => $recipient,
            ], [
                'created_at',
            ]);
    }
    
    /**
     * Return number of unread notifications by recipient.
     * @param integer $recipient Id of recipient.
     * @return integer
     */
    public function countUnreadByRecipient($recipient)
    {
        return (new Query)
            ->from($this->getTableName())
            ->where([
                'readed' => false,
                'recipient' => $recipient,
            ])
            ->count();
    }
    
    /**
     * Returns all results by condition as an array.
     * @param string|array $condition the conditions that should be put in the WHERE part.
     * @param string|array $orderBy the columns (and the directions) to be ordered by.
     * @return array
     */
    public function findAll($condition = [], $orderBy = [])
    {
        return (new Query)
            ->from($this->getTableName())
            ->where($condition)
            ->orderBy($orderBy)
            ->all();
    }
    
    /**
     * Flush notifications to database.
     * @return boolean
     */
    public function flush()
    {
        if (!empty($this->collection)) {
            list($sql, $params) = $this->prepareQuery();
            if (!(bool)$this->getDb()->createCommand($sql, $params)->execute()) {
                return false;
            }
            $this->collection = [];
        }
        return true;
    }
    
    /**
     * Prepare SQL query uses collection of notification.
     * @return string
     */
    protected function prepareQuery()
    {
        $queryBuilder = $this->getDb()->getQueryBuilder();    
        $sql = [];
        $params = [];
        for ($i = 0; $i != count($this->collection); $i++) {
            $row = $this->collection[$i]->attributes;
            $sql[] = $queryBuilder->insert($this->getTableName(), $row, $params);
        }       
        return [implode(';' . PHP_EOL, $sql), $params];
    }
    
    /**
     * Adding notification to collection.
     * @param integer $type Type of notification.
     * @param integer $recipient Id of recipient user.
     * @param string $message Message of notification.
     * @param string $title Title of notification.
     * @return static
     */
    protected function add($type, $recipient, $message, $title)
    {
        $notification = new Notification([
            'type' => $type,
            'recipient' => $recipient,
            'message' => $message,
            'title' => $title,
            'readed' => false,
            'created_at' => time(),
        ]);
        if ($notification->validate()) {
            $this->collection[] = $notification;
        }
        return $this;
    }
    
    private $_db = null;
    
    /**
     * @return Connection Database connection.
     */
    protected function getDb()
    {
        if ($this->_db === null) {
            $this->_db = $this->module->db;
        }
        return $this->_db;
    }
    
    private $_tableName = null;
    
    /**
     * @return string Table name of notification module.
     */
    protected function getTableName()
    {
        if ($this->_tableName === null) {
            $this->_tableName = $this->module->tableName;
        }
        return $this->_tableName;
    }
}

