<?php

namespace Drupal\timezone_clock\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class TimezoneClockSettingsForm extends ConfigFormBase {

  const SETTINGS = 'timezone_clock.settings';

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
    return [static::SETTINGS];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['timezoneClock_country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('timezone_clock.country'),
    ];

    $form['timezoneClock_city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('timezone_clock.city'),
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
      '#default_value' => $config->get('timezone_clock.timezone'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->configFactory->getEditable(static::SETTINGS)
    // Set the submitted configuration setting.
      ->set('timezone_clock.country', $form_state->getValue('timezoneClock_country'))
      // You can set multiple configurations at once by making
      // multiple calls to set()
      ->set('timezone_clock.city', $form_state->getValue('timezoneClock_city'))
      ->set('timezone_clock.timezone', $form_state->getValue('timezoneClock_timezone'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
