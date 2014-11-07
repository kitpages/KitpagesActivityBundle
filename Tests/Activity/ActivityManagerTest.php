<?php
namespace Kitpages\ActivityBundle\Tests\Manager;

use Kitpages\ActivityBundle\Tests\BundleOrmTestCase;
use Kitpages\ActivityBundle\Entity\Activity;
use Kitpages\ActivityBundle\Activity\ActivityManager;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ActivityManagerTest extends BundleOrmTestCase
{
    /** @var  ActivityManager */
    protected $manager;

    /** @var  EventDispatcher */
    protected $dispatcher;

    protected function setUp()
    {
        parent::setUp();
        $this->dispatcher = new EventDispatcher();
        $this->manager = new ActivityManager(
            $this->getEntityManager(),
            $this->dispatcher
        );
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testCreateActivity()
    {
        $activity = $this->manager->createActivity("test", 'mon titre', 'mon message');
        $this->assertTrue($activity->getId() > 0);
    }

    public function testGetActivityList()
    {
        $activity = $this->manager->createActivity("phpunit", 'mon titre', 'mon message');
        $this->assertTrue($activity->getId() > 0);
        $activityList = $this->manager->getActivityList();
        $this->assertEquals(2, count($activityList));
    }

    public function testGetActivityListFiltered()
    {

        $this->manager->createActivity("phpunit", 'title1', 'mon message', null, "user.12", array("cnt" => 12, "foo" => "bar"));
        sleep(1);
        $this->manager->createActivity("test.cat2", 'title2', 'mon message', null, "locality.23.user.12");
        sleep(1);
        $this->manager->createActivity("test.cat1", 'gloubi.title', 'mon message');

        $activityList = $this->manager->getActivityList();
        $this->assertEquals(4, count($activityList));

        $activityList = $this->manager->getActivityList(
            array(
                "category" => "test*"
            )
        );
        $this->assertEquals(2, count($activityList));
        $this->assertEquals("title2", $activityList[1]->getTitle());

        $activityList = $this->manager->getActivityList(
            array(
                "reference" => "*user.12"
            )
        );
        $this->assertEquals(2, count($activityList));
        $this->assertEquals("title1", $activityList[1]->getTitle());

        $activityList = $this->manager->getActivityList(
            array(
                "category" => "phpunit",
                "reference" => "*user.12"
            )
        );
        $this->assertEquals(1, count($activityList));
        $this->assertEquals("title1", $activityList[0]->getTitle());

        $activityList = $this->manager->getActivityList(
            array(
                "reference" => "*user.12"
            ),
            "createdAt ASC"
        );
        $this->assertEquals(2, count($activityList));
        $this->assertEquals("title2", $activityList[1]->getTitle());

    }

}
