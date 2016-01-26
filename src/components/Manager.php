<?php

namespace bupy7\notify\ss\components;

use Yii;
use bupy7\notify\ss\base\Manager as BaseManager;

/**
 * Manager of notification component.
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
class Manager extends BaseManager
{
    /**
     * Success notification type.
     */
    const TYPE_SUCCESS = 1;
    /**
     * Danger notification type.
     */
    const TYPE_DANGER = 2;
    /**
     * Warning notification type.
     */
    const TYPE_WARNING = 3;
    /**
     * Info notification type.
     */
    const TYPE_INFO = 4;
    /**
     * Default notification type.
     */
    const TYPE_DEFAULT = 5;
    
    /**
     * Adding notification of type success.
     * @param integer $recipient Id of recipient user.
     * @param string $message Message of notification.
     * @param string|null $title Title of notification.
     * @return static
     */
    public function addSuccess($recipient, $message, $title = null)
    {
        return $this->add(self::TYPE_SUCCESS, $recipient, $message, $title);
    }
    
    /**
     * Adding notification of type danger.
     * @param integer $recipient Id of recipient user.
     * @param string $message Message of notification.
     * @param string|null $title Title of notification.
     * @return static
     */
    public function addDanger($recipient, $message, $title = null)
    {
        return $this->add(self::TYPE_DANGER, $recipient, $message, $title);
    }
    
    /**
     * Adding notification of type warning.
     * @param integer $recipient Id of recipient user.
     * @param string $message Message of notification.
     * @param string|null $title Title of notification.
     * @return static
     */
    public function addWarning($recipient, $message, $title = null)
    {
        return $this->add(self::TYPE_WARNING, $recipient, $message, $title);
    }
    
    /**
     * Adding notification of type info.
     * @param integer $recipient Id of recipient user.
     * @param string $message Message of notification.
     * @param string|null $title Title of notification.
     * @return static
     */
    public function addInfo($recipient, $message, $title = null)
    {
        return $this->add(self::TYPE_INFO, $recipient, $message, $title);
    }
    
    /**
     * Adding notification of type default.
     * @param integer $recipient Id of recipient user.
     * @param string $message Message of notification.
     * @param string|null $title Title of notification.
     * @return static
     */
    public function addDefault($recipient, $message, $title = null)
    {
        return $this->add(self::TYPE_DEFAULT, $recipient, $message, $title);
    }
}
