<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.03.2015
 */
use yii\helpers\Html;
use skeeks\cms\widgets\base\hasModelsSmart\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\WidgetConfig */
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->fieldSet('Основное'); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>

