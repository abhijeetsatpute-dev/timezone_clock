<?php

namespace Drupal\timezone_clock\Services;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Custom service to provide timezone data from admin config form.
 */
class TimezoneServices {

  const DATETIMEFORMAT = 'jS M Y - h:i:s A';

  /**
   * The cron configuration.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * Constructs a new automated cron runner.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->get('timezone_clock.settings');
  }

  /**
   * Returns the time in timezone selected by admin.
   *
   * In the format eg. 19th Sept 2022 - 11:15 AM.
   *
   * @return string
   *   A formatted date string using the chosen format.
   */
  public function getCurrentTime() {
    // Create the date in given timezone.
    $current_time = new DrupalDateTime('now', $this->getTimezone());
    // Create the date in given format.
    $result = $current_time->format(static::DATETIMEFORMAT);
    return $result;
  }

  /**
   * Returns the country added by admin in config form.
   *
   * @return string
   *   A country from the timezone config form.
   */
  public function getCountry() {
    return $timezone = $this->config->get('timezone_clock.country');
  }

  /**
   * Returns the city added by admin in config form.
   *
   * @return string
   *   A city from the timezone config form.
   */
  public function getCity() {
    return $timezone = $this->config->get('timezone_clock.city');
  }

  /**
   * Returns the timezone selected by admin in config form.
   *
   * @return string
   *   A city from the timezone config form.
   */
  public function getTimezone() {
    return $timezone = $this->config->get('timezone_clock.timezone');
  }

}
