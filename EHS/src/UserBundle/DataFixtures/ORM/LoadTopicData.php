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
        $lorem='On sait depuis longtemps que travailler avec du texte lisible
         et contenant du sens est source de distractions, et empêche de se concentrer
          sur la mise en page elle-même. L\'avantage du Lorem Ipsum sur un texte
           générique comme \'Du texte. Du texte. Du texte.\' est qu\'il possède
            une distribution de lettres plus ou moins normale, et en tout cas
             comparable avec celle du français standard. De nombreuses suites
              logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem
               Ipsum leur faux texte par défaut, et une recherche pour
                \'Lorem Ipsum\' vous conduira vers de nombreux sites qui n\'en sont
                 encore qu\'à leur phase de construction. Plusieurs versions sont
                  apparues avec le temps, parfois par accident, souvent
                   intentionnellement (histoire d\'y rajouter de petits clins
                    d\'oeil, voire des phrases embarassantes).';
        $topic=[
            'Santé',
            'Association',
            'Membres',
            'Divers'
        ];
        $topics=[];

        $user=[
            'admin-user',
            'user-user',
            'admin-user',
            'user-user'
        ];
        for($i=0;$i<count($topic);$i++)
        {
            $topics[$i] = new Topic();
            $topics[$i]->setTitle($topic[$i]);
            $topics[$i]->setForum($this->getReference('Forum'.$i));
            $topics[$i]->setContent($lorem);
            $topics[$i]->setDateCreated(new \DateTime());
            $topics[$i]->setAuthor($this->getReference($user[$i]));
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
