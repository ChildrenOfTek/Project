<?php
// src/UserBundle/DataFixtures/ORM/LoadRoleData.php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ForumBundle\Entity\Forum;

class LoadForumData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $forum=[
            'Santé',
            'Association',
            'Membres',
            'Divers'
        ];
        $desc=[
            'Un endroit pour discuter Santé',
            'Parlons de l\'association',
            'Discussions entre membres',
            'Expression libre'
        ];
        $forums=[];
        for($i=0;$i<count($forum);$i++)
        {
            $forums[$i] = new Forum();
            $forums[$i]->setLibForum($forum[$i]);
            $forums[$i]->setDescription($desc[$i]);
            $this->addReference('Forum'.$i, $forums[$i]);
            $manager->persist($forums[$i]);
        }

        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 4;
    }
}
