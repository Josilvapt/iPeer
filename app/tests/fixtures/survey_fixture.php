<?php
/**
 * SurveyFixture
 *
 * @uses CakeTestFixture
 * @package   CTLT.iPeer
 * @author    Pan Luo <pan.luo@ubc.ca>
 * @copyright 2012 All rights reserved.
 * @license   MIT {@link http://www.opensource.org/licenses/MIT}
 */
class SurveyFixture extends CakeTestFixture
{
    public $name = 'Survey';

    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'course_id' => array('type' => 'integer'),
        'user_id' => array('type' => 'integer'),
        'name' => array('type' => 'string'),
        'due_date' => array('type' => 'datetime'),
        'release_date_begin' => array('type' => 'datetime'),
        'release_date_end' => array('type' => 'datetime'),
        'released' => array('type' => 'integer'),
        'creator_id' => array('type' => 'integer'),
        'created' => array('type' => 'datetime'),
        'updater_id' => array('type' => 'integer'),
        'modified' => array('type' => 'datetime')
    );

    public $records = array(
        array('id' => 1, 'course_id' => 1, 'user_id' => 3, 'name' => 'Math303 Survey', 'due_date' => '2012-06-16 12:28:0',
        'release_date_begin' => '2011-06-16 12:28:07', 'release_date_end' => '2013-06-16 12:28:07', 'released' => 0,
        'creator_id' => 0, 'created' => '2011-06-16 12:28:07', 'updater_id' => null, 'modified' => null),
        array('id' => 2, 'course_id' => 1, 'user_id' => 3, 'name' => 'Math304 Survey', 'due_date' => '2012-06-16 12:28:0',
        'release_date_begin' => '2011-06-16 12:28:07', 'release_date_end' => '2013-06-16 12:28:07', 'released' => 0,
        'creator_id' => 0, 'created' => '2011-06-16 12:28:07', 'updater_id' => null, 'modified' => null),
        array('id' => 3, 'course_id' => 1, 'user_id' => 3, 'name' => 'Empty Survey', 'due_date' => '2012-06-16 12:28:0',
        'release_date_begin' => '2011-06-16 12:28:07', 'release_date_end' => '2013-06-16 12:28:07', 'released' => 0,
        'creator_id' => 0, 'created' => '2011-06-16 12:28:07', 'updater_id' => null, 'modified' => null)
    );
}