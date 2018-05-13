<?php

namespace Drupal\ejemplodrupal\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;

use Drupal\Core\Url;
use Drupal\Core\Link;
/**
 * Plugin implementation of the 'entity_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "entity_field_formatter",
 *   label = @Translation("Entity field formatter"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */

// Aqui se construye Y se renderiza
class EntityFieldFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'enlace_vista' => ''
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $formulario = parent::settingsForm($form, $form_state);//Variable formulario.

    $formulario['enlace_vista'] = [ 
      '#type' => 'textfield',
      '#title' => $this->t('Ingrese el path de la vista'),
      '#default_value' => $this->getSetting('enlace_vista'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE
    ];
    //TODO ESTO ALMACENA UNA CONFIGURACION
    return $formulario;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    
    //Verificamos si esta vacio la configuracion o si trae algo.
    if( !empty($this->getSetting('enlace_vista')) ){
      $summary[] =
        $this->t('El enlace a la vista es: @path',
        ['@path'=>$this->getSetting('enlace_vista')]
      );
    }
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $items = $this->getEntitiesToView( $items, $langcode);
    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(EntityInterface $entity) {

    global $base_url;
    $label = $entity->label();
    $id = $entity->id();
    // http://localhost/drupal8/web/actores/id
        // $urlView = $base_url . '/' . $this->getSetting('path_view') .'/'. $id;
        // $url = Url::fromUri($urlView);


        $urlView = $base_url . '/' . $this->getSetting('enlace_vista') .'/'. $id;
        $url = Url::fromUri($urlView);
    //<a href="$url"> $label </a>
    $link = Link::fromTextAndUrl($label,$url);
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return $link->toString();
  }

}
