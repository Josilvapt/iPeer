<?php
require_once('system_base.php');

class AddGroupTestCase extends SystemBaseTestCase
{
    protected $groupId = 0;
    
    public function startCase()
    {
        $this->getUrl();
        $wd_host = 'http://localhost:4444/wd/hub';
        $this->web_driver = new PHPWebDriver_WebDriver($wd_host);
        $this->session = $this->web_driver->session('firefox');
        $this->session->open($this->url);
        
        $w = new PHPWebDriver_WebDriverWait($this->session);
        $this->session->deleteAllCookies();
        $login = PageFactory::initElements($this->session, 'Login');
        $home = $login->login('root', 'ipeeripeer');
    }
    
    public function endCase()
    {
        $this->session->deleteAllCookies();
        $this->session->close();
    }
    
    public function testAddGroup()
    {
        $this->session->open($this->url.'courses/home/2');
        $this->session->element(PHPWebDriver_WebDriverBy::LINK_TEXT, 'Create Groups (Manual)')->click();
        $title = $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "h1.title")->text();
        $this->assertEqual($title, 'APSC 201 - Technical Communication > Add Group');
        
        $groupNum = $this->session->element(PHPWebDriver_WebDriverBy::ID, 'GroupGroupNum');
        $this->assertEqual($groupNum->attribute('value'), 1);
        $this->assertTrue($groupNum->attribute('readonly'));
        
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[type="submit"]')->click();
        $msg = $this->session->element(PHPWebDriver_WebDriverBy::CLASS_NAME, 'error-message')->text();
        $this->assertEqual($msg, 'Please insert group name');
        
        $this->session->element(PHPWebDriver_WebDriverBy::ID, 'GroupGroupName')->sendKeys(' Amazing Group ');
        
        // adding Geoff Student
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'select[id="all_groups"] option[value="30"]')->click();
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[value="Assign >>"]')->click();
        
        // adding Van Hong Student
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'select[id="all_groups"] option[value="27"]')->click();
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[value="Assign >>"]')->click();
        
        // adding Denny Student
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'select[id="all_groups"] option[value="18"]')->click();
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[value="Assign >>"]')->click();
        
        // adding Trevor Student
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'select[id="all_groups"] option[value="23"]')->click();
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[value="Assign >>"]')->click();
        
        $count = count($this->session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'select[id="selected_groups"] option'));
        $this->assertEqual($count, 4);
        
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[type="submit"]')->click();
        $w = new PHPWebDriver_WebDriverWait($this->session);
        $session = $this->session;
        $w->until(
            function($session) {
                return count($session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "div[class='message good-message green']"));
            }
        );
        
        $msg = $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "div[class='message good-message green']")->text();
        $this->assertEqual($msg, 'The group was added successfully.');
        
        // checking duplicate group name error
        $this->session->open($this->url.'groups/add/2');
        $this->session->element(PHPWebDriver_WebDriverBy::ID, 'GroupGroupName')->sendKeys(' Amazing Group ');
        // adding Geoff Student
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'select[id="all_groups"] option[value="30"]')->click();
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[value="Assign >>"]')->click();
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[type="submit"]')->click();
        $w->until(
            function($session) {
                return count($session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "div[class='error-message']"));
            }
        );
        $msg = $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "div[class='error-message']");
        $this->assertEqual($msg->text(), 'A group with the name already exists.');
        $this->session->open($this->url.'groups/index/2');
    }
    
    public function testEditGroup()
    {
        $this->session->element(PHPWebDriver_WebDriverBy::LINK_TEXT, 'Amazing Group (4 members)')->click();
        $title = $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "h1.title")->text();
        $this->assertEqual($title, 'APSC 201 - Technical Communication > Groups > View');
        $this->groupId = end(explode('/', $this->session->url()));
        
        $this->checkViewLinks();
        
        $this->session->element(PHPWebDriver_WebDriverBy::LINK_TEXT, 'Edit this Group')->click();
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[type="submit"]')->click();
        // check that no duplicate name error appears
        $w = new PHPWebDriver_WebDriverWait($this->session);
        $session = $this->session;
        $w->until(
            function($session) {
                return count($session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "div[class='message good-message green']"));
            }
        );

        $this->session->open($this->url.'groups/edit/'.$this->groupId);
        $this->session->element(PHPWebDriver_WebDriverBy::ID, 'GroupGroupName')->sendKeys(' Two');
        
        // removing Van Hong Student
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'select[id="selected_groups"] option[value="30"]')->click();
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'select[id="selected_groups"] option[value="18"]')->click();
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'select[id="selected_groups"] option[value="23"]')->click();
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[value="<< Remove "]')->click();

        $count = count($this->session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'select[id="selected_groups"] option'));
        $this->assertEqual($count, 3);
        
        $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'input[type="submit"]')->click();
        $w = new PHPWebDriver_WebDriverWait($this->session);
        $session = $this->session;
        $w->until(
            function($session) {
                return count($session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "div[class='message good-message green']"));
            }
        );
        
        $msg = $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "div[class='message good-message green']")->text();
        $this->assertEqual($msg, 'The group was updated successfully.');
    }
    
    public function testDeleteGroup()
    {
        $this->session->open($this->url.'groups/delete/'.$this->groupId);
        $w = new PHPWebDriver_WebDriverWait($this->session);
        $session = $this->session;
        $w->until(
            function($session) {
                return count($session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "div[class='message good-message green']"));
            }
        );
        
        $msg = $this->session->element(PHPWebDriver_WebDriverBy::CSS_SELECTOR, "div[class='message good-message green']")->text();
        $this->assertEqual($msg, 'The group was deleted successfully.');
    }
    
    public function checkViewLinks()
    {
        $emails = $this->session->elements(PHPWebDriver_WebDriverBy::PARTIAL_LINK_TEXT, 'Email');
        $this->assertTrue(strpos($emails[0]->attribute('href'), 'emailer/write/U/18'));
        $this->assertTrue(strpos($emails[1]->attribute('href'), 'emailer/write/U/23'));
        $this->assertTrue(strpos($emails[2]->attribute('href'), 'emailer/write/U/27'));
        $this->assertTrue(strpos($emails[3]->attribute('href'), 'emailer/write/U/30'));
        $this->assertTrue(strpos($emails[4]->attribute('href'), 'emailer/write/G/'.$this->groupId));
        
        $back = $this->session->element(PHPWebDriver_WebDriverBy::LINK_TEXT, 'Back to Group Listing');
        $this->assertTrue(strpos($back->attribute('href'), 'groups/index/2'));
        
        
        $view = $this->session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'a[href="/users/view/18"]');
        $this->assertTrue(!empty($view));
        $view = $this->session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'a[href="/users/view/23"]');
        $this->assertTrue(!empty($view));
        $view = $this->session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'a[href="/users/view/27"]');
        $this->assertTrue(!empty($view));
        $view = $this->session->elements(PHPWebDriver_WebDriverBy::CSS_SELECTOR, 'a[href="/users/view/30"]');
        $this->assertTrue(!empty($view));
    }
}