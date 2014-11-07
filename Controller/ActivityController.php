<?php

namespace Kitpages\ActivityBundle\Controller;

use Kitpages\DataGridBundle\Grid\Field;
use Kitpages\DataGridBundle\Grid\GridConfig;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActivityController extends Controller
{
    /**
     * @param array $filterList
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request, $filterList = array(), $orderBy = 'createdAt DESC')
    {
        $qb = $this->get("kitpages_activity.activity_manager")->getActivityListQueryBuilder($filterList, $orderBy);

        $gridConfig = new GridConfig();
        $gridConfig->setQueryBuilder($qb);
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

        $gridManager = $this->get('kitpages_data_grid.grid_manager');
        $grid = $gridManager->getGrid($gridConfig, $request);

        return $this->render('KitpagesActivityBundle:Activity:list.html.twig', array('grid' => $grid));
    }
}
