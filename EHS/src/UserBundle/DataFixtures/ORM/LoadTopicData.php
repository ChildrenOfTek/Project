<?php
// src/UserBundle/DataFixtures/ORM/LoadRoleData.php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ForumBundle\Entity\Topic;

class LoadTopicData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $topic=[
            'Santé',
            'Association',
            'Membres',
            'Divers'
        ];
        $topics=[];
        for($i=0;$i<count($topic);$i++)
        {
            $topics[$i] = new Topic();
            $topics[$i]->setTitle($topic[$i]);
            $topics[$i]->setForum($this->getReference('Forum'.$i));
            $this->addReference('Topic'.$i, $topics[$i]);

            $manager->persist($topics[$i]);
        }

        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 5;
    }
}
