<?php
/**
 * Created by PhpStorm.
 * User: dpino
 * Date: 8/17/16
 * Time: 1:13 PM
 */

namespace Drupal\islandora\ParamConverter;


use Drupal\Core\ParamConverter\EntityConverter;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\Component\Uuid\Uuid;

class UuidEntityConverter extends EntityConverter implements ParamConverterInterface {
  /**
   * @inheritDoc
   */
  public function convert($value, $definition, $name, array $defaults) {

    // Try to load fedora entity by UUID or ID depending on $value.
    if (!(is_int($value) || ctype_digit((string) $value)) && Uuid::isValid($value)) {
      $entities = $storage->loadByProperties(['uuid' => $value]);
      $entity = ($entities) ? reset($entities) : NULL;
    }
    else {
      $entity = parent::convert($value, $definition, $name, $defaults);
    }
    return $entity;
  }

  /**
   * @inheritDoc
   */
  public function applies($definition, $name, Route $route) {
    /*if (!empty($definition['type']) && strpos($definition['type'], 'entity:') === 0) {
      $entity_type_id = substr($definition['type'], strlen('entity:'));
      if (strpos($definition['type'], '{') !== FALSE) {
        $entity_type_slug = substr($entity_type_id, 1, -1);
        return $name != $entity_type_slug && in_array($entity_type_slug, $route->compile()->getVariables(), TRUE);
      }
      return $this->entityManager->hasDefinition($entity_type_id);
    }
    return FALSE;*/

    return parent::applies($definition, $name, $route); // TODO: Change the autogenerated stub
  }


}