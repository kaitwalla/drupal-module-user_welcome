<?php
/**
 * Settings form for user_welcome module
 */

namespace Drupal\user_welcome\Form;

use Drupal;
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
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);
        $config = $this->config(self::$CONFIG_NAME);
        $form['message'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Message'),
            '#default_value' => $config->get('message'),
            '#description' => 'A custom message to display to users'
        ];
        $form['displayMessage'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Only show to logged-in users'),
            '#default_value' => $config->get('displayMessage'),
            '#description' => 'When checked, the above message will display only to authenticated users'
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
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $config = $this->config(self::$CONFIG_NAME);
        $config->set('message', $form_state->getValue('message'));
        $config->set('displayMessage', $form_state->getValue('displayMessage'));
        $config->save();
        // TODO: Narrowly scope the cache flush to only what is actually needed
        drupal_flush_all_caches();
        return parent::submitForm($form, $form_state);
    }
}