<?php
// src/UserBundle/DataFixtures/ORM/LoadUserData.php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AssociationBundle\Entity\Archive;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadArchiveDta extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $archive= new Archive();
        $date = new \DateTime();
        $archive->setDateCreation($date);
        $archive->setTitreArchive('Statuts');
        $archive->setImageName('STATUTS_DECLARATION_MG-FB.doc');
        $archive->setUpdatedAt($date);

        $archive1=new Archive();
        $archive1->setDateCreation($date);
        $archive1->setTitreArchive('Communiqué du 23 Janvier');
        $archive1->setUpdatedAt($date);
        $archive1->setImageName('communique_bilan_du_23_janvier.docx');

        $archive2=new Archive();
        $archive2->setDateCreation($date);
        $archive2->setTitreArchive('PV AG CONSTITUTIVE 17déc 2015');
        $archive2->setUpdatedAt($date);
        $archive2->setImageName('PV_AG_CONSTITUTIVE_17dec_2015signee_FB.pdf');

        $archive3=new Archive();
        $archive3->setDateCreation($date);
        $archive3->setTitreArchive('Flyer Rencontre Citoyenne');
        $archive3->setUpdatedAt($date);
        $archive3->setImageName('Flyer_Rencontre_Citoyenne.pdf');

        $manager->persist($archive);
        $manager->persist($archive1);
        $manager->persist($archive2);
        $manager->persist($archive3);
        //$manager->persist($userUser);
        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 8;
    }
}
