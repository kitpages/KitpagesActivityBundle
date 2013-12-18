<?php
/**
 * Created by Philippe Le Van.
 * Date: 20/07/13
 */

namespace Kitpages\ActivityBundle\Activity;

use Kitpages\ActivityBundle\Entity\Activity;
use Kitpages\ActivityBundle\KitpagesActivityEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;

class ActivityManager
{
    /** @var  EntityManager */
    protected $em;
    /** @var  EventDispatcherInterface */
    protected $dispatcher;

    public function __construct(
        EntityManager $em,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }
    public function createActivity (
        $category,
        $title,
        $message = null,
        $linkUrl = null
    )
    {
        $activity = new Activity();
        $activity->setCategory($category);
        $activity->setMessage($message);
        $activity->setTitle($title);
        $activity->setLinkUrl($linkUrl);
        return $this->registerActivity($activity);
    }

    public function registerActivity(Activity $activity)
    {
        $this->em->persist($activity);
        $this->em->flush();
        $event = new ActivityEvent();
        $event->setActivity($activity);
        $this->dispatcher->dispatch(KitpagesActivityEvents::AFTER_SAVE_ACTIVITY, $event);
        return $event->getActivity();
    }

    public function getActivityList($filterList = array())
    {
        $repository = $this->em->getRepository('\Kitpages\ActivityBundle\Entity\Activity');
        $qb = $repository->createQueryBuilder('item');
        $qb->where("1=1");
        foreach( $filterList as $field => $val) {
            $qb->andWhere('item.'.$field.' = :'.$field);
            $qb->setParameter($field, $val);
        }
        $qb->add('orderBy', 'item.createdAt DESC');
        $query = $qb->getQuery();
        $activityList = $query->getResult();
        return $activityList;
    }

}