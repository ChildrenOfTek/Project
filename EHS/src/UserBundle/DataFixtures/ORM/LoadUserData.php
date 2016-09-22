<?php
// src/UserBundle/DataFixtures/ORM/LoadUserData.php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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

        $encoder = $this->container->get('security.password_encoder');

        $userAdmin = new User();

        $encoded = $encoder->encodePassword($userAdmin, 'test');

        $userAdmin->setUsername('test');
        $userAdmin->setPassword($encoded);
        $userAdmin->setNom('test');
        $userAdmin->setPrenom('test');
        $userAdmin->setAdresse('test');
        $userAdmin->setCp('test');
        $userAdmin->setVille('test');
        $userAdmin->setTelephone('0123456789');
        $userAdmin->setEmail('test@test.fr');
        $userAdmin->setNewsletter(false);
        $userAdmin->setBirthDate(new \DateTime());
        $userAdmin->setUserRoles($this->getReference('admin-group'));

        $manager->persist($userAdmin);
        $manager->flush();

        $this->addReference('admin-user', $userAdmin);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}
