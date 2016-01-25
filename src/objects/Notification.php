<?php

namespace bupy7\notify\ss\objects;

use Yii;
use yii\base\Object;

/**
 * Object of notification to user.
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
class Notification extends Object
{
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $message;
    /**
     * @var integer
     */
    public $type;
    /**
     * @var integer
     */
    public $recipient;
    /**
     * @var boolean
     */
    public $readed;
}
