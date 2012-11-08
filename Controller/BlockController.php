<?php

namespace Zorbus\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{

    public function defaultAction($block)
    {
        $parameters = json_decode($block->getParameters());
        $menu = $this->getDoctrine()->getRepository('ZorbusMenuBundle:Menu')->find($parameters->menu_id);
        $items = '';
        if ($menu)
        {
            $repo = $this->getDoctrine()->getRepository('ZorbusMenuBundle:Item');
            $query = $this->getDoctrine()->getEntityManager()
                    ->createQueryBuilder()
                    ->select('i')
                    ->from('ZorbusMenuBundle:Item', 'i')
                    ->orderBy('i.root, i.lft', 'ASC')
                    ->innerJoin('i.menu', 'm')
                    ->where('m.id = ' . $menu->getId() . ' and i.enabled = 1')
                    ->getQuery();

            $options = array(
                'decorate' => true,
                'rootOpen' => function($tree)
                {
                    if (count($tree) && ($tree[0]['lvl'] == 0))
                    {
                        return '<ul class="nav">';
                    }
                },
                'rootClose' => '</ul>',
                'childOpen' => function($child)
                {
                    if (count($child['__children']) && $child['lvl'] == 0)
                    {
                        $str = '<li class="dropdown">';
                    }
                    else
                    {
                        $str = '<li>';
                    }

                    return $str;
                },
                'childClose' => '</li>',
                'nodeDecorator' => function ($node)
                {
                    $str = '<a href="';

                    $str .= count($node['__children']) ? '#" class="dropdown-toggle" data-toggle="dropdown' : $node['url'];

                    $str .= '">' . $node['name'];

                    if (count($node['__children']) && $node['lvl'] == 0)
                    {
                        $str .= '<b class="caret"></b>';
                    }

                    $str .= '</a>';

                    if (count($node['__children']))
                    {
                        $str .= '<ul class="dropdown-menu">';
                    }

                    return $str;
                }
            );
            $items = $repo->buildTree($query->getArrayResult(), $options);
        }

        return $this->render('ZorbusMenuBundle:Block:default.html.twig', array(
                    'block' => $block, 'menu' => $menu, 'items' => $items
                ));
    }

}
