<?php

namespace Drupal\timezone_clock\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class TimezoneClockSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'timezone_clock_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'timezoneClock.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('timezoneClock.settings');

    $form['timezoneClock_country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('timezoneClock_country'),
    ];

    $form['timezoneClock_city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('timezoneClock_city'),
    ];

    $form['timezoneClock_timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Select timezone'),
      '#options' => [
        'America/Chicago' => $this->t('America/Chicago'),
        'America/New_York' => $this->t('America/New_York'),
        'Asia/Tokyo' => $this->t('Asia/Tokyo'),
        'Asia/Dubai' => $this->t('Asia/Dubai'),
        'Asia/Kolkata' => $this->t('Asia/Kolkata'),
        'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
        'Europe/Oslo' => $this->t('Europe/Oslo'),
        'Europe/London' => $this->t('Europe/London'),
      ],
      '#default_value' => $config->get('timezoneClock_timezone'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->configFactory->getEditable('timezoneClock.settings')
    // Set the submitted configuration setting.
      ->set('timezoneClock_country', $form_state->getValue('timezoneClock_country'))
      // You can set multiple configurations at once by making
      // multiple calls to set()
      ->set('timezoneClock_city', $form_state->getValue('timezoneClock_city'))
      ->set('timezoneClock_timezone', $form_state->getValue('timezoneClock_timezone'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
