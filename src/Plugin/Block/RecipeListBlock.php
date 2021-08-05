<?php

namespace Drupal\react_example\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'React rendering example' Block.
 *
 * @Block(
 *   id = "recipe_list_block",
 *   admin_label = @Translation("React example block"),
 *   category = @Translation("react_example"),
 * )
 */
class RecipeListBlock extends BlockBase implements
  ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The entity repository.
   *
   * @var \Drupal\Core\Entity\EntityRepositoryInterface
   */
  protected $entityRepository;

  /**
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManagerInterface $entity_type_manager,
    EntityRepositoryInterface $entity_repository,
    EntityFieldManagerInterface $entity_field_manager
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->entityRepository = $entity_repository;
    $this->entityFieldManager = $entity_field_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('entity.repository'),
      $container->get('entity_field.manager'),
    );
  }

  // TODO キャッシュ node-list 使った方がいい
  public function build() {
    $build = [];
    $recipes = $this->getRecipes();
    $recipes = json_encode($recipes);

    $fieldDefinitions = $this->entityFieldManager->getFieldDefinitions(
      'node',
      'recipe'
    );

    if (isset($fieldDefinitions['field_difficulty'])) {
      $difficulty = $fieldDefinitions['field_difficulty']->getFieldStorageDefinition(
      )->getSettings()['allowed_values'];
    }
    foreach ($difficulty as $name => $value) {
      $json_difficulty[] = [
        'id' => $name,
        'value' => $value,
      ];
    }
    $filter['difficulty'] =$json_difficulty;
    $filter = json_encode($filter);

    $time = $this->t('Time is: ') . time();
    $build['#markup'] = "<div id='recipe-list'></div>";
    $build['#markup'] .= "<div>{$time}</div>";
    $build['#cache'] = ['max-age' => 0];
    $build['#attached']['library'] = ['react_example/recipe_list'];
    $build['#attached']['drupalSettings']['react_example']['recipes'] = $recipes;
    $build['#attached']['drupalSettings']['react_example']['filters'] = $filter;
    return $build;
  }

  // TODO languageManagerをDI
  protected function getRecipes() {
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    /** @var  $storage \Drupal\Core\Entity\EntityStorageInterface */
    $storage = $this->entityTypeManager->getStorage('node');
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
      $node = $this->entityRepository->getTranslationFromContext(
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
