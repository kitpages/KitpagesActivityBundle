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
}
