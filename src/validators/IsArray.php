<?php

namespace bupy7\notify\ss\validators;

use Yii;
use yii\validators\Validator;
use bupy7\notify\ss\Module;

/**
 * Validator whether a variable is an array
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
class IsArray extends Validator
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Module::t('ERROR_VALIDATE_ARRAY');
        }
    }
    
    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!is_array($model->$attribute)) {
            $this->addError($model, $attribute, $this->message);
        }
    }
}
