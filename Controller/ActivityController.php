<?php

namespace Kitpages\ActivityBundle\Controller;

use Kitpages\DataGridBundle\Model\Field;
use Kitpages\DataGridBundle\Model\GridConfig;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActivityController extends Controller
{
    /**
     * @param array $filterList
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request, $filterList = array())
    {
        // create query builder
        $repository = $this->getDoctrine()->getRepository('\Kitpages\ActivityBundle\Entity\Activity');
        $qb = $repository->createQueryBuilder('item');
        $qb->where("1=1");
        foreach( $filterList as $field => $val) {
            $qb->andWhere('item.'.$field.' = :'.$field);
            $qb->setParameter($field, $val);
        }
        $qb->add('orderBy', 'item.createdAt DESC');

        $self = $this;
        $gridConfig = new GridConfig();
        $gridConfig
            ->setName("activity_grid")
            ->setCountFieldName('item.id')
            ->addField(new Field(
                'item.title',
                array(
                    'label' => 'Title',
                    'sortable' => true,
                    'filterable' => true,
                )
            ))
            ->addField(new Field(
                'item.category',
                array(
                    'label' => 'Catégorie',
                    'sortable' => true,
                    'filterable' => true,
                )
            ))
            ->addField(new Field(
                'item.createdAt',
                array(
                    'label' => 'Date',
                    'sortable' => true
                )
            ))
        ;

        $gridManager = $this->get('kitpages_data_grid.manager');
        $grid = $gridManager->getGrid($qb, $gridConfig, $request);

        return $this->render('KitpagesActivityBundle:Activity:list.html.twig', array('grid' => $grid));
    }
}
