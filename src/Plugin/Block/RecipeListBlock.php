<?php

namespace Drupal\react_example\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'React rendering example' Block.
 *
 * @Block(
 *   id = "recipe_list_block",
 *   admin_label = @Translation("React example block"),
 *   category = @Translation("react_example"),
 * )
 */
class RecipeListBlock extends BlockBase {

  // TODO キャッシュ node-list 使うとか考えろ
  public function build() {
    $build = [];
    $recipes = $this->getRecipes();
    $json = json_encode($recipes);

    $time = $this->t('Time is: ') . time();
    $build['#markup'] = "<div id='recipe-list'></div>";
    $build['#markup'] .= "<div>{$time}</div>";
    $build['#cache'] = ['max-age' => 0];
    $build['#attached']['library'] = ['react_example/recipe_list'];
    $build['#attached']['drupalSettings']['react_example']['recipes'] = $json;
    return $build;
  }

  // TODO DIしろ.サービス分けるとかしろ.
  protected function getRecipes() {
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    /** @var  $storage \Drupal\Core\Entity\EntityStorageInterface */
    $storage = \Drupal::service('entity_type.manager')->getStorage('node');
    $nodes = $storage->loadByProperties(
      ['type' => 'recipe']
    );

    $keys = [
      'title',
      'field_cooking_time',
      'field_difficulty',
      'field_preparation_time',
      'field_recipe_category',
    ];

    $results = [];
    /** @var  $node \Drupal\node\NodeInterface */
    foreach ($nodes as $node) {
      $node = \Drupal::service('entity.repository')->getTranslationFromContext(
        $node,
        $langcode
      );

      $item = [];
      $item['id'] = $node->id();
      $item['url'] = $node->toUrl()->toString();
      foreach ($keys as $key) {
        $item[$key] = $node->get($key)->value;
      }
      $results[] = $item;
    }
    return $results;
  }

}
