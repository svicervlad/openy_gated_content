<?php

namespace Drupal\openy_gc_log\Field;

use Drupal\Core\Field\FieldItemList;
use Drupal\Core\TypedData\ComputedItemListTrait;
use Drupal\openy_gc_log\Entity\LogEntityInterface;

/**
 * Class PayloadFieldItemList.
 *
 * Computed field for LogEntity.
 * Composed from event_type related fields.
 *
 * @package Drupal\openy_gc_log\Field
 */
class PayloadFieldItemList extends FieldItemList {

  use ComputedItemListTrait;

  /**
   * Compute value.
   *
   * @inheritDoc
   */
  protected function computeValue() {
    /* @var \Drupal\openy_gc_log\Entity\LogEntity $log */
    $log = $this->getEntity();

    $value = '';
    $eventType = $log->get('event_type')->value;
    if ($eventType === LogEntityInterface::EVENT_TYPE_ENTITY_VIEW) {
      $entityType = $log->get('entity_type')->value;
      $bundle = $log->get('entity_bundle')->value;
      $entityId = $log->get('entity_id')->value;

      $value = "$entityType:$bundle/$entityId";
    }

    $this->list[0] = $this->createItem(0, $value);
  }

}
