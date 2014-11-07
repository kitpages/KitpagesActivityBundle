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
        $linkUrl = null,
        $reference = null,
        $data = array()
    )
    {
        $activity = new Activity();
        $activity->setCategory($category);
        $activity->setMessage($message);
        $activity->setTitle($title);
        $activity->setLinkUrl($linkUrl);
        $activity->setReference($reference);
        $activity->setData($data);
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

    public function getActivityListQueryBuilder( $filterList = array(), $orderBy = "createdAt DESC" )
    {
        $qb = $this->em->createQueryBuilder();
        $qb ->select('item')
            ->from('\Kitpages\ActivityBundle\Entity\Activity', 'item')
        ;

        // manager order
        preg_match('/^\s*(\w+)\s+(\w+)\s*$/', $orderBy, $matches);
        $orderByField = $matches[1];
        $orderByOrder = $matches[2];
        $qb->orderBy( 'item.'.$orderByField, $orderByOrder );

        // manager filters
        foreach( $filterList as $field => $val) {
            // if val == "*", consider val as a wildcard => no filter
            if ($val === '*') {
                continue;
            }
            // if val ends by "*" and not escapted by '\*', wildcard in filter, then like
            $isLike = false;
            if ((substr($val, -1) === "*") && (substr($val, -2) !== '\\*')) {
                $isLike = true;
                $val = substr($val, 0, strlen($val) - 1) . '%';
            }
            if (substr($val, 0, 1) === "*") {
                $isLike = true;
                $val = '%' . substr($val, 1);
            }

            if ($isLike === true) {
                $qb->andWhere('item.' . $field . ' like :' . $field);
            } else {
                $qb->andWhere('item.' . $field . ' = :' . $field);
            }

            $qb->setParameter($field, $val);
        }
        return $qb;
    }

    public function getActivityList( $filterList = array(), $orderBy = "createdAt DESC" )
    {
        $qb = $this->getActivityListQueryBuilder($filterList, $orderBy);
        $query = $qb->getQuery();
        $activityList = $query->getResult();
        return $activityList;
    }

}