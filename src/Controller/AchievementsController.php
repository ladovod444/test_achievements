<?php
namespace Drupal\test_achievements\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class AchievementsController.
 */
class AchievementsController extends ControllerBase {

  const PAGER_LIMIT = 20;

  /**
   * Display.
   * return rendered table data
   */
  public function display(){
    // Создать заголовки для таблицы
    $header = [
      'player_id',
      'achievement_date',
      'achievement_name',
      'achievement_competition_name',
      'achievement_sort',
      'sync_id'
    ];

    // Создать запрос к БД
    $query = \Drupal::database()->select('api_players_achievements', 'apa');
    $query->fields('apa');

    $table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')
      ->orderByHeader($header);
    // Выводить по 20 элементов.
    $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')
      ->limit(self::PAGER_LIMIT);
    $result = $pager->execute();

    // сформировать данные для таблицы
    foreach($result as $row) {
      $rows[] = array('data' => array(
        'player_id' => $row->player_id,
        'achievement_date' => $row->achievement_date,
        'achievement_name' => $row->achievement_name,
        'achievement_competition_name' => $row->achievement_competition_name,
        'achievement_sort' => $row->achievement_sort,
        'sync_id' => $row->sync_id,
      ));
    }
    // The table description.
    $data = array(
      '#markup' => t('Achievements')
    );

    // Создать таблицу.
    $data['achievements'] = array(
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    );

    // Добавить пагинатор
    $data['pager'] = array(
      '#type' => 'pager'
    );

    return $data;
  }
}
