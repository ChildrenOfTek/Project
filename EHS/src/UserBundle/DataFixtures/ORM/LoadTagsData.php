<?php
// src/UserBundle/DataFixtures/ORM/LoadRoleData.php

namespace UserBundle\DataFixtures\ORM;

use ArticleBundle\Entity\Tags;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\Role;

class LoadTagsData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Pour ajouter un tag à la liste des fixtures,
        // le mettre à la suite dans le tableau $lib
        $lib=[
            'Santé',
            'Informations',
            'Association',
            'Politique',
            'Evenements',
            'Lorem',
            'Ipsum',
            'Classe',
            'Debut',
            'Fin',
            'Milieu',
            'Forum',
            'Santéé',
            'Informationss',
            'Associations',
            'Politiques',
            'Evenementss',
            'Lorems',
            'Ipsums',
            'Classes',
            'Debuts',
            'Fins',
            'Milieus',
            'Forums'

        ];
        for($i=0;$i<count($lib);$i++)
        {
            $tag[$i]=new Tags();
            $tag[$i]->setLibelle($lib[$i]);
            $this->addReference($lib[$i],$tag[$i]);
            $manager->persist($tag[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 3;
    }
}
