<?php
/**
 * Settings form for user_welcome module
 */

namespace Drupal\user_welcome\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Extends ConfigFormBase to change settings for UserWelcome module
 */
class UserWelcomeForm extends ConfigFormBase
{
    public static $CONFIG_NAME = 'user_welcome.settings';

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $formState)
    {
        $form = parent::buildForm($form, $formState);
        $config = $this->config(self::$CONFIG_NAME);
        $form['message'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Message'),
            '#default_value' => $config->get('message'),
            '#description' => 'When enabled, this message will be displayed to all users regardless of authentication status'
        ];
        $form['displayMessage'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Display message'),
            '#default_value' => $config->get('displayMessage'),
            '#description' => 'When checked, the above message will display. If unchecked, only authenticated users will see their information'
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'user_welcome_form';
    }

    /**
     * {@inheritdoc}
     */
    public function getEditableConfigNames()
    {
        return [
            self::$CONFIG_NAME
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function submitForm(array &$form, FormStateInterface $formState)
    {
        $config = $this->config(self::$CONFIG_NAME);
        $config->set('user_welcome.message', $formState->getValue('message'));
        $config->set('user_welcome.displayMessage', $formState->getValue('displaymessage'));
        $config->save();
        return parent::submitForm($form, $formState);
    }
}