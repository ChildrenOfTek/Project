<?php
// src/UserBundle/DataFixtures/ORM/LoadArticleData.php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ArticleBundle\Entity\Article;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $titre=[
            'Un joli article de démo',
            'Deuxième pour le remplissage'

        ];
        $content=[
            'Article démo',
            'Un petit article de présentation tout simple !'

        ];
        $user=[
            'admin-user',
            'admin-user'
        ];

        $articles=[];
        for($i=0;$i<count($titre);$i++)
        {
            $articles[$i]= new Article();
            $articles[$i]->setDateArticle(new \DateTime());
            $articles[$i]->setDatePublication(new \DateTime(''));
            $articles[$i]->setTitreArticle($titre[$i]);
            $articles[$i]->setContent($content[$i]);
            $articles[$i]->setUpdatedAt(new \DateTime());
            $articles[$i]->setOnline(true);
            $articles[$i]->setUser($this->getReference($user[$i]));
            $articles[$i]->addTag($this->getReference('Santé'));
            $articles[$i]->addTag($this->getReference('Informations'));
            $articles[$i]->addTag($this->getReference('Association'));
            $manager->persist($articles[$i]);
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
