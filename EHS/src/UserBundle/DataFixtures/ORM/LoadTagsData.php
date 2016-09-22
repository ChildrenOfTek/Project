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
        $tag1=new Tags();
        $tag1->setLibelle("Santé");

        $tag2=new Tags();
        $tag2->setLibelle("Info");

        $tag3=new Tags();
        $tag3->setLibelle("Association");

        $manager->persist($tag1);
        $manager->persist($tag2);
        $manager->persist($tag3);
        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 3;
    }
}
