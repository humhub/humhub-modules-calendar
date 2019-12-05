<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2019 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\calendar\assets\ReminderFormAssets;
use humhub\modules\calendar\models\forms\ReminderSettings;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\modules\ui\view\components\View;
use humhub\widgets\Button;
use humhub\libs\Html;

/* @var $this View */
/* @var $settings ReminderSettings */
/* @var $form ActiveForm */

if (!isset($form)) {
    $form = ActiveForm::begin();
}

$options = [
    'class' => 'calendar-reminder-settings',
    'data' => [
        'ui-widget' => 'calendar.reminder.Form',
        'ui-init' => 1,
        'max-reminder' => Yii::$app->getModule('calendar')->maxReminder
    ]
];

ReminderFormAssets::register($this);
?>

<?= Html::beginTag('div', $options) ?>

    <?php if($settings->hasDefaults()) : ?>
        <?= $form->field($settings, 'useDefaults')->checkbox(['data-action-change' => 'checkUseDefaults']) ?>
        <br>
    <?php endif; ?>

    <div class="calendar-reminder-items">

        <?php foreach ($settings->reminders as $index => $reminder): ?>
            <?php if ($reminder->disabled) : ?>
                <?php continue; ?>
            <?php endif; ?>

            <div class="row" data-reminder-index="<?= $index ?>">
                <div class="col-md-3">
                    <?= $form->field($reminder, "[$index]unit")->dropDownList(ReminderSettings::getUnitSelection())->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($reminder, "[$index]value")->textInput(['type' => 'number', 'min' => 1, 'max' => 100])->label(false) ?>
                </div>
                <div class="col-md-7">
                    <?= Button::danger()->action('delete')
                        ->icon('fa-times')->xs()->visible(!$reminder->isNewRecord)
                        ->style('margin: 7px 0')->loader(false) ?>

                    <?= Button::primary()->action('add')
                        ->icon('fa-plus')->xs()->visible($reminder->isNewRecord)
                        ->style('margin: 7px 0')->loader(false) ?>
                </div>
            </div>
        <?php endforeach; ?>


    </div>

<?= Html::endTag('div') ?>