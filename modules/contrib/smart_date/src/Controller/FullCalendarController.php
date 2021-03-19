<?php

namespace Drupal\smart_date\Controller;

use Drupal\fullcalendar_view\Controller\CalendarEventController;
use Drupal\smart_date_recur\Controller\Instances;
use Drupal\smart_date_recur\Entity\SmartDateOverride;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Calendar Event Controller, overridden to handle Smart Date events.
 */
class FullCalendarController extends CalendarEventController {

  // Fullcalendar is using defaultTimedEventDuration parameter
  // for event objects without a specified end value:
  // see https://fullcalendar.io/docs/v4/defaultTimedEventDuration -
  // so taking the value of 1 hour in seconds here,
  // not sure how to get this from the JS here.
  // TODO: Get this from the configuration of Fullcalendar somehow.
  /**
   * The default duration for a new event.
   *
   * @var int
   */
  protected $defaultTimedEventDuration = 60 * 60;

  /**
   * Update the event entity based on information passed in request.
   *
   * @param Symfony\Component\HttpFoundation\Request $request
   *   The Symfony-processed request from the user to update entity data.
   *
   * @return Symfony\Component\HttpFoundation\Response
   *   An HTTP reponse based on the outcome of the operation.
   */
  public function updateEvent(Request $request) {

    $user = $this->currentUser();

    if (empty($user)) {
      return new Response($this->t('Invalid User!'));
    }

    $csrf_token = $request->request->get('token');
    if (!$this->csrfToken->validate($csrf_token, $user->id())) {
      return new Response($this->t('Access denied!'));
    }

    $eid = $request->request->get('eid', '');
    $entity_type = $request->request->get('entity_type', '');
    $start_date = $request->request->get('start', '');
    $end_date = $request->request->get('end', '');
    $start_field = $request->request->get('start_field', '');
    $end_field = $request->request->get('end_field', '');
    if (empty($eid) || empty($start_date) || empty($start_field) || empty($entity_type)) {
      return new Response($this->t('Parameter Missing.'));
    }

    $recurring = FALSE;
    $id = explode('-', $eid);
    $entity = $this->entityTypeManager()->getStorage($entity_type)->load($id[0]);
    if (count($id) > 1) {
      if ($id[1] == 'D') {
        $delta = $id[2];
      }
      elseif ($id[1] == 'R') {
        /* @var \Drupal\smart_date_recur\Entity\SmartDateRule $rule */
        $rule = $this->entityTypeManager()
          ->getStorage('smart_date_rule')
          ->load($id[2]);
        // Load overridden instances from rule object.
        $instances = $rule->getRuleInstances();
        $rruleindex = $id[4];
        $instance = $instances[$rruleindex];
        $recurring = TRUE;
      }
    }

    if (empty($entity) || !$entity->access('update')) {
      return new Response($this->t('Access denied!'));
    }

    if (!$entity->hasField($start_field)) {
      // Can't process without $start_field.
      return new Response($this->t('Invalid start date.'));
    }

    // Field definitions.
    $fields_def = $entity->getFieldDefinition($start_field);
    $start_type = $fields_def->getType();

    if ($start_type != 'smartdate') {
      parent::updateEvent($request);
      return new Response(1);
    }

    if ($recurring) {
      $endDate = strtotime($end_date);
      $duration = (strtotime($end_date) - strtotime($start_date)) / 60;
      $starttime = (date('H:i:s', strtotime($start_date)));
      // Check if allday event (one day or multiple days long)
      if ($starttime == '00:00:00') {
        if (empty($endDate)) {
          // This is a regular event becoming all day.
          $endDate = strtotime($start_date) + 1439 * 60;
          $duration = 0;
        }
        elseif ((strtotime($end_date) - strtotime($start_date)) % 86400 == 0) {
          $endDate = strtotime($end_date) + 1439 * 60;
          $duration = 0;
        }
      }
      elseif (empty($endDate)) {
        // This is allday event becoming regular event.
        $endDate = strtotime($start_date) + $this->defaultTimedEventDuration;
        $duration = $this->defaultTimedEventDuration / 60;
      }
      if (isset($instance['oid'])) {
        $override = SmartDateOverride::load($instance['oid']);
        $override
          ->set('value', strtotime($start_date));
        $override
          ->set('end_value', $endDate);
        $override
          ->set('duration', $duration);
      }
      else {
        $values = [
          'rrule'       => $rule->id(),
          'rrule_index' => $rruleindex,
          'value'       => strtotime($start_date),
          'end_value'   => $endDate,
          'duration'    => $duration,
        ];
        $override = SmartDateOverride::create($values);
      }
      $override->save();
      $instancesController = new Instances();
      $instancesController->applyChanges($rule);
    }
    else {
      $entity->{$start_field}[$delta]->value = strtotime($start_date);
      $duration = $entity->{$start_field}[$delta]->duration;
      $this->calculateEndDateFromDuration($duration, $end_date, $start_date);
      $entity->{$end_field}[$delta]->end_value = $end_date;
      if ($duration != $entity->{$start_field}[$delta]->duration) {
        $entity->{$start_field}[$delta]->duration = $duration;
      }
      $entity->save();
    }
    // Log the content changed.
    $this->loggerFactory->get($entity_type)->notice('%entity_type: updated %title', [
      '%entity_type' => $entity->getType(),
      '%title' => $entity->getTitle(),
    ]);
    return new Response(1);
  }

  /**
   * Calculating for switch between all day and regular events.
   *
   * @param int $duration
   *   Duration in minutes.
   * @param string|null $endDate
   *   End value to populate.
   * @param string $startDate
   *   Start value of the date.
   */
  protected function calculateEndDateFromDuration(int &$duration, ?string &$endDate, string $startDate) {
    if ($duration % 1440 == '1439') {
      // This means an allday event is to become a regular event.
      if (empty($endDate)) {
        $endDate = strtotime($startDate) + $this->defaultTimedEventDuration;
        $duration = $this->defaultTimedEventDuration / 60;
      }
      else {
        $endDate = strtotime($endDate) + 1439 * 60;
      }
    }
    else {
      // This means an regular event is to become an allday event.
      if (empty($endDate)) {
        // If https://fullcalendar.io/docs/defaultAllDayEventDuration = 1 day.
        $endDate = strtotime($startDate) + 1439 * 60;
        $duration = 1439;
      }
      else {
        $endDate = strtotime($endDate);
      }
    }
  }

}
