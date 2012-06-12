<?php
App::import('Model', 'GroupEvent');

class GroupEventTestCase extends CakeTestCase {
    public $name = 'GroupEvent';
    public $fixtures = array(
        'app.course', 'app.role', 'app.user', 'app.group',
        'app.roles_user', 'app.event', 'app.event_template_type',
        'app.group_event', 'app.evaluation_submission',
        'app.survey_group_set', 'app.survey_group',
        'app.survey_group_member', 'app.question',
        'app.response', 'app.survey_question', 'app.user_course', 'app.evaluation_rubric', 'app.rubrics_criteria',
        'app.user_enrol', 'app.groups_member', 'app.survey', 'app.rubric', 'app.faculty', 'app.course_department',
        'app.department', 'app.user_faculty'
    );
    public $GroupEvent = null;

    function startCase()
    {
        $this->GroupEvent = ClassRegistry::init('GroupEvent');
    }

    function endCase()
    {
    }

    function startTest($method)
    {
    }

    function endTest($method)
    {
    }

    function testCourseInstance()
    {
        $this->assertTrue(is_a($this->GroupEvent, 'GroupEvent'));
    }

    function testUpdateGroups()
    {
        $data = array();
        $data['Member'] = array(3);

        $this->GroupEvent->updateGroups(1, $data);
        $searched = $this->GroupEvent->find('all', array('conditions' => array('event_id' => 1)));
        $this->assertEqual($searched[0]['GroupEvent']['group_id'], 3);
        $this->assertEqual($searched[0]['GroupEvent']['event_id'], 1);
        $this->assertEqual(sizeof($searched), 1);

        $incorrectData = $this->GroupEvent->updateGroups(1, null);
        $this->assertFalse($incorrectData);
    }

    function testGetGroupIDsByEventId()
    {
        //Test valid event with groups
        $groups = $this->GroupEvent->getGroupIDsByEventId(1);
        $this->assertEqual(Set::extract('/GroupEvent/group_id', $groups), array(1,2));

        //Test valid event with no groups
        $groups = $this->GroupEvent->getGroupIDsByEventId(3);
        $this->assertEqual($groups, null);

        //Test invalid event
        $groups = $this->GroupEvent->getGroupIDsByEventId(999);
        $this->assertEqual($groups, null);
    }

    function testGetGroupListByEventId()
    {
        //Test valid event with groups
        $groups = $this->GroupEvent->getGroupListByEventId(1);
        $this->assertEqual(Set::extract('/GroupEvent/group_id', $groups), array(1,2));

        //Test valid event with no groups
        $groups = $this->GroupEvent->getGroupListByEventId(3);
        $this->assertEqual($groups, null);

        //Test invalid event
        $groups = $this->GroupEvent->getGroupListByEventId(999);
        $this->assertEqual($groups, null);
    }

    function testGetGroupEventByEventIdGroupId()
    {
        //Test valid event and valid group
        $group = $this->GroupEvent->getGroupEventByEventIdGroupId(1, 1);
        $this->assertEqual($group['GroupEvent']['group_id'], '1');
        $this->assertEqual($group['GroupEvent']['event_id'], '1');

        //Test valid event and not related valid group
        $group = $this->GroupEvent->getGroupEventByEventIdGroupId(1, 3);
        $this->assertEqual($group, null);

        //Test valid event and invalid group
        $group = $this->GroupEvent->getGroupEventByEventIdGroupId(1, 999);
        $this->assertEqual($group, null);

        //Test invalid event and valid group
        $group = $this->GroupEvent->getGroupEventByEventIdGroupId(999,1);
        $this->assertEqual($group, null);

        //Test invalid event and invalid group
        $group = $this->GroupEvent->getGroupEventByEventIdGroupId(999, 999);
        $this->assertEqual($group, null);
    }

    function testGetGroupEventByUserId()
    {
        //Test valid user in group
        $groups = $this->GroupEvent->getGroupEventByUserId(3, 1);
        $this->assertEqual(Set::extract('/GroupEvent/group_id', $groups), array(1,2));

        //Test valid user not in group
        $groups = $this->GroupEvent->getGroupEventByUserId(1, 1);
        $this->assertEqual(Set::extract('/GroupEvent/group_id', $groups), null);

        //Test invalid user
        $groups = $this->GroupEvent->getGroupEventByUserId(999, 1);
        $this->assertEqual(Set::extract('/GroupEvent/group_id', $groups), null);

        //Test invalid event
        $groups = $this->GroupEvent->getGroupEventByUserId(3, 999);
        $this->assertEqual(Set::extract('/GroupEvent/group_id', $groups), null);
    }

    function testGetGroupsByEventId()
    {
        //Test valid event with groups
        $groups = $this->GroupEvent->getGroupsByEventId(1);
        $this->assertEqual($groups[0]['GroupEvent']['id'], '1');
        $this->assertEqual($groups[0]['GroupEvent']['group_id'], '1');
        $this->assertEqual($groups[0]['GroupEvent']['event_id'], '1');
        $this->assertEqual($groups[1]['GroupEvent']['id'], '2');
        $this->assertEqual($groups[1]['GroupEvent']['group_id'], '2');
        $this->assertEqual($groups[1]['GroupEvent']['event_id'], '1');
        //Test valid event with no groups
        $groups = $this->GroupEvent->getGroupsByEventId(3);
        $this->assertEqual($groups, null);

        //Test invalid event
        $groups = $this->GroupEvent->getGroupsByEventId(999);
        $this->assertEqual($groups, null);
    }

    function testGetLowMark()
    {
        $event = $this->GroupEvent->getLowMark(1, 2, 100, 0);
    }

    function testGetNotReviewed()
    {
        //Test event with not reviewed
        $events = $this->GroupEvent->getNotReviewed(1);
        $this->assertEqual(Set::extract('/GroupEvent/id', $events), array(2));

        //Test event with reviewed only
        $events = $this->GroupEvent->getNotReviewed(2);
        $this->assertEqual(Set::extract('/GroupEvent/id', $events), null);

        //Test invalid event
        $events = $this->GroupEvent->getNotReviewed(999);
        $this->assertEqual(Set::extract('/GroupEvent/id', $events), null);
    }

    function testGetLateGroupMembers()
    {
        $events = $this->GroupEvent->getLateGroupMembers(1);
        $this->assertEqual($events, 1);

        $events = $this->GroupEvent->getLateGroupMembers(999);
        $this->assertFalse($events);

        $events = $this->GroupEvent->getLateGroupMembers(null);
        $this->assertFalse($events);
    }

    function testGetLate()
    {
        //Test events with late groups
        $events = $this->GroupEvent->getLate(1);
        $this->assertEqual(Set::extract('/GroupEvent/id', $events), array(1, 2));

        //Test events with no late groups
        $events = $this->GroupEvent->getLate(2);
        $this->assertEqual(Set::extract('/GroupEvent/id', $events), null);

        //Test invalid event
        $events = $this->GroupEvent->getLate(999);
        $this->assertEqual(Set::extract('/GroupEvent/id', $events), null);
    }

    function testGetGroupEventByEventId()
    {
        //Test valid event
        $groups = $this->GroupEvent->getGroupEventByEventId(1);
        $this->assertEqual(Set::extract('/GroupEvent/id', $groups), array(1, 2));

        //Test valid event with no groups
        $groups = $this->GroupEvent->getGroupEventByEventId(3);
        $this->assertEqual($groups, null);

        //Test invalid event
        $groups = $this->GroupEvent->getGroupEventByEventId(999);
        $this->assertEqual($groups, null);
    }

    function testGetGroupEventByEventIdAndGroupId()
    {
        //Test valid event and valid group
        $group = $this->GroupEvent->getGroupEventByEventIdAndGroupId(2, 1);
        $this->assertEqual($group, 3);

        //Test valid event and valid group not in group-event
        $group = $this->GroupEvent->getGroupEventByEventIdAndGroupId(3, 3);
        $this->assertEqual($group, null);

        //Test invalid event and valid group
        $group = $this->GroupEvent->getGroupEventByEventIdAndGroupId(999, 1);
        $this->assertEqual($group, null);

        //Test valid event and invalid group
        $group = $this->GroupEvent->getGroupEventByEventIdAndGroupId(1, 999);
        $this->assertEqual($group, null);

        //Test invalid event and invalid group
        $group = $this->GroupEvent->getGroupEventByEventIdAndGroupId(999, 9);
        $this->assertEqual($group, null);

    }
}