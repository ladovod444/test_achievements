<?php

namespace Drupal\test_achievements;

/**
 * Class AchievementsDataService.
 */
class AchievementsDataService {

  const TEST_SYCN_ID = 5;

  public function getAchievementsData() {
    return array('sync_id' => self::TEST_SYCN_ID);
  }
}
