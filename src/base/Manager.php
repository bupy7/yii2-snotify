<?php

namespace bupy7\notify\ss\base;

use Yii;
use yii\base\Component;
use bupy7\notify\ss\objects\Notification;
use bupy7\notify\ss\Module;

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
     * Flush notifications to database.
     */
    public function flush()
    {
        if (!empty($this->collection)) {
            list($sql, $params) = $this->prepareQuery();
            if ((bool)$this->module->db->createCommand($sql, $params)->execute()) {
                $this->collection = [];
            }
        }
    }
    
    /**
     * Prepare SQL query uses collection of notification.
     * @return string
     */
    protected function prepareQuery()
    {
        $queryBuilder = $this->module->db->getQueryBuilder();    
        $sql = [];
        $params = [];
        for ($i = 0; $i != count($this->collection); $i++) {
            $row = [
                'type' => $this->collection[$i]->type,
                'recipient' => $this->collection[$i]->recipient,
                'message' => $this->collection[$i]->message,
                'title' => $this->collection[$i]->title,
            ];
            $sql[] = $queryBuilder->insert($this->module->tableName, $row, $params);
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
        $this->collection[] = new Notification([
            'type' => $type,
            'recipient' => $recipient,
            'message' => $message,
            'title' => $title,
            'created_at' => time(),
        ]);
        return $this;
    }
}

