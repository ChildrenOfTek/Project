<?php
// src/UserBundle/DataFixtures/ORM/LoadRoleData.php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ForumBundle\Entity\Post;

class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $post=[
            'Santé',
            'Association',
            'Membres',
            'Divers'
        ];
        $posts=[];
            for($j=0;$j<count($post);$j++)
            {
                for($i=0;$i<count($post);$i++)
                {
                    $posts[$i] = new Post();
                    $posts[$i]->setContent($post[$i]);
                    //a changer par un get reference au user-admin
                    $posts[$i]->setAuthor($post[$i]);
                    $posts[$i]->setDateEdit(new \DateTime());
                    $posts[$i]->setTopic($this->getReference('Topic'.$i));

                    $manager->persist($posts[$i]);
                }
            }

        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 6;
    }
}
