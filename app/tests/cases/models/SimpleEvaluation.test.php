<?php
App::import('Model', 'SimpleEvaluation');

class SimpleEvaluationTestCase extends CakeTestCase
{
    public $name = 'SimpleEvaluation';
    public $fixtures = array(
        'app.course', 'app.role', 'app.user', 'app.group',
        'app.roles_user', 'app.event', 'app.event_template_type',
        'app.group_event', 'app.evaluation_submission',
        'app.survey_group_set', 'app.survey_group',
        'app.survey_group_member', 'app.question',
        'app.response', 'app.survey_question', 'app.user_course',
        'app.user_enrol', 'app.groups_member', 'app.survey', 'app.simple_evaluation'
    );
    public $Course = null;
    public $empty = null;

    function startCase()
    {
        /*$this->SimpleEvaluation = ClassRegistry::init('SimpleEvaluation');
        $admin = array('User' => array('username' => 'root',
            'password' => 'ipeer'));
        $this->controller = new FakeController();
        $this->controller->constructClasses();
        $this->controller->startupProcess();
        $this->controller->Component->startup($this->controller);
        $this->controller->Auth->startup($this->controller);
        ClassRegistry::addObject('view', new View($this->Controller));
        ClassRegistry::addObject('auth_component', $this->controller->Auth);

        $this->controller->Auth->login($admin);*/
    }

    function endCase()
    {
        /*$this->controller->Component->shutdown($this->controller);
        $this->controller->shutdownProcess();*/
    }

    function startTest($method)
    {
        // extra setup stuff here
    }
}