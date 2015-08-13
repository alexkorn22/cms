<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 30.04.2015
 */
namespace skeeks\cms\relatedProperties\userPropertyTypes;
use skeeks\cms\components\Cms;
use skeeks\cms\models\CmsContentElement;
use skeeks\cms\relatedProperties\PropertyType;
use yii\helpers\ArrayHelper;

/**
 * Class UserPropertyTypeSelectFile
 * @package skeeks\cms\relatedProperties\userPropertyTypes
 */
class UserPropertyTypeSelectFile extends PropertyType
{
    public $code = self::CODE_STRING;
    public $name = "Стандартный выбор файла";

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'type'  => 'Тип',
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
        ]);
    }

    /**
     * @return \yii\widgets\ActiveField
     */
    public function renderForActiveForm()
    {
        $field = parent::renderForActiveForm();

        $field->widget(\skeeks\cms\modules\admin\widgets\formInputs\OneImage::className(),
        [
            'filesModel' => $this->model
        ]);

        return $field;
    }


    /**
     * Файл с формой настроек, по умолчанию лежит в той же папке где и компонент.
     *
     * @return string
     */
    public function getConfigFormFile()
    {
        $class = new \ReflectionClass($this->className());
        return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views/_formUserPropertyTypeDate.php';
    }
}