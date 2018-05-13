<?php

namespace Drupal\ejemplodrupal\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'pais_widget_type' widget.
 *
 * @FieldWidget(
 *   id = "pais_widget_type",
 *   label = @Translation("Pais widget type"),
 *   field_types = {
 *     "pais_field_type"
 *   }
 * )
 */
class PaisWidgetType extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element + [
      '#type' => 'select',
      '#title' => $this->t('Seleccione un país'),
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
      '#options' => \Drupal::service('country_manager')->getList()
    ];
    return $element;
  }

}

