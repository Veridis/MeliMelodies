<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav navbar-nav navbar-center',
            ),
        ));

        $menu->addChild('Accueil', array('route' => 'home'));
        $menu->addChild('Présentation', array('route' => 'presentation'));
        $menu->addChild('Contact', array('route' => 'contact'));
        $menu->addChild('Multimédia')
            ->setAttribute('dropdown', true)
            ->setAttribute('divider_prepend', true);
        $menu['Multimédia']->addChild('Image', array(
            'route' => 'multimedia',
            'routeParameters' => array('category' => 'image'),
        ));
        $menu['Multimédia']->addChild('Audio', array(
            'route' => 'multimedia',
            'routeParameters' => array('category' => 'audio'),
        ));
        $menu['Multimédia']->addChild('Vidéo', array(
            'route' => 'multimedia',
            'routeParameters' => array('category' => 'video'),
        ));
        $menu->addChild('Livre d\'or', array('route' => 'guestbook'));

        return $menu;
    }

    public function adminMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav navbar-nav navbar-center',
            ),
        ));

        $menu->addChild('News', array('route' => 'admin-news'));
        $menu->addChild('Multimédias', array('route' => 'admin-medias'));
        $menu->addChild('Contacts', array('route' => 'admin-contacts'));
        $menu->addchild('Presentation', array('route' => 'admin-presentation'));
        $menu->addchild('Livre d\'or', array('route' => 'admin-guestbook'));

        return $menu;
    }
}