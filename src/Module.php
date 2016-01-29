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
        $this->registerTranslations();
    }
    
    /**
     * Translates a message to the specified language.
     * @param string $message the message to be translated.
     * @param array $params the parameters that will be used to replace the corresponding placeholders in the message.
     * @param string $language the language code (e.g. `en-US`, `en`). If this is null, the current of application
     * language.
     * @return string
     */
    static public function t($message, $params = [], $language = null)
    {
        return Yii::t('bupy7/notify/ss', $message, $params, $language);
    }
    
    /**
     * Registration of translation class.
     */
    protected function registerTranslations()
    {
        Yii::$app->i18n->translations['bupy7/notify/ss'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@bupy7/notify/ss/messages',
            'fileMap' => [
                'bupy7/notify/ss' => 'core.php',
            ],
        ];
    }
}

