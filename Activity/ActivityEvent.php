<?php
/**
 * Created by Philippe Le Van.
 * Date: 20/07/13
 */

namespace Kitpages\ActivityBundle\Activity;


use Kitpages\ActivityBundle\Entity\Activity;
use Symfony\Component\EventDispatcher\Event;

class ActivityEvent
    extends Event
{
    /** @var  Activity */
    protected $activity;

    /**
     * @param \Kitpages\ActivityBundle\Entity\Activity $activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
    }

    /**
     * @return \Kitpages\ActivityBundle\Entity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }


}