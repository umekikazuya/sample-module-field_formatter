<?php

declare(strict_types=1);

namespace Drupal\sample_module_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\sample_module_formatter\Enum\Era;

/**
 * Plugin implementation of the '和暦対応' formatter.
 *
 * @FieldFormatter(
 *   id = "japanese_era_date",
 *   label = @Translation("和暦対応"),
 *   field_types = {"datetime"},
 * )
 */
final class JapaneseEraDateFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $date = new DrupalDateTime($item->date);

      // Convert the date to Japanese era format here.
      $markup = $this->convertDateTime($date);

      $elements[$delta] = ['#markup' => $markup];
    }

    return $elements;
  }

  /**
   * 日付データの加工.
   */
  private function convertDateTime(DrupalDateTime $date) {
    $era = Era::fromDateTime($date);

    return $date->format('Y年m月d日') . '(' . $era->getJapaneseName() . '生まれ)';
  }

}
