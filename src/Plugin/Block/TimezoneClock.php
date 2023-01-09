<?php

namespace Drupal\timezone_clock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\timezone_clock\Services\TimezoneServices;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Cache\Cache;

/**
 * This block provides lifestyle library list.
 *
 * @Block(
 *   id = "timezone_clock_block",
 *   admin_label = @Translation("Timezone Clock Block"),
 * )
 */
class TimezoneClock extends BlockBase implements ContainerFactoryPluginInterface {

  const REQDATEFORMAT = 'l, d F Y';

  const REQTIMEFORMAT = 'g:i A';
  /**
   * The Timezone service.
   *
   * @var \Drupal\timezone_clock\Services\TimezoneServices
   */
  protected $timezoneService;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('timezone_clock.timezoneClock')
    );
  }

  /**
   * Construct the timezone and configFactory object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\timezone_clock\Services\TimezoneServices $timezoneService
   *   The Timezone service.
   */
  public function __construct(array $configuration, $plugin_id, array $plugin_definition, TimezoneServices $timezoneService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->timezoneService = $timezoneService;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Invalidate block cache to show updated time.
    Cache::invalidateTags(['config:timezone_clock.settings']);
    return [
      '#theme' => 'timezone_clock',
      '#country' => $this->timezoneService->getCountry(),
      '#city' => $this->timezoneService->getCity(),
      '#timezone' => $this->timezoneService->getTimezone(),
      '#formatted_datetime' => $this->getDateTimeInFormat(),
      '#attached' => [
        'library' => [
          'timezone_clock/timezone',
        ],
      ],
    ];
  }

  /**
   * Returns the date and time array in REQDATEFORMAT and REQTIMEFORMAT format .
   *
   * @return array
   *   An array of formatted date and time string.
   */
  private function getDateTimeInFormat() {
    // Get the current date time in the timezone selected by admin.
    // Service provides the date in the format 19th Sept 2022 - 11:15 AM.
    // Change the format of the date returned by service.
    $datetime = DrupalDateTime::createFromFormat(
      $this->timezoneService::DATETIMEFORMAT,
      $this->timezoneService->getCurrentTime());
    $formatted_date = $datetime->format(static::REQDATEFORMAT);
    $formatted_time = $datetime->format(static::REQTIMEFORMAT);
    return ['date' => $formatted_date, 'time' => $formatted_time];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), [
      'config:timezone_clock.settings',
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
