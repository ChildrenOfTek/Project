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

        $encoded = $encoder->encodePassword($userAdmin, 'admin');

        $userAdmin->setUsername('admin');
        $userAdmin->setPassword($encoded);
        $userAdmin->setNom('Guillossou');
        $userAdmin->setPrenom('Michelle');
        $userAdmin->setAdresse('6 avenue de la Devinière');
        $userAdmin->setCp('44000');
        $userAdmin->setVille('Nantes');
        $userAdmin->setTelephone('0123456789');
        $userAdmin->setEmail('vincent.lene.dl@gmail.com');
        $userAdmin->setNewsletter(false);
        $userAdmin->setBirthDate(new \DateTime());
        $userAdmin->setUserRoles($this->getReference('admin-group'));

        $userUser = new User();

        $encoded = $encoder->encodePassword($userUser, 'user');

        $userUser->setUsername('user');
        $userUser->setPassword($encoded);
        $userUser->setNom('user');
        $userUser->setPrenom('user');
        $userUser->setAdresse('user');
        $userUser->setCp('44000');
        $userUser->setVille('user');
        $userUser->setTelephone('0123456789');
        $userUser->setEmail('test@test.fr');
        $userUser->setNewsletter(false);
        $userUser->setBirthDate(new \DateTime());
        $userUser->setUserRoles($this->getReference('user-group'));

        $userPress = new User();

        $userPress->setUsername('usero');
        $userPress->setPassword($encoded);
        $userPress->setNom('user');
        $userPress->setPrenom('user');
        $userPress->setAdresse('user');
        $userPress->setCp('44000');
        $userPress->setVille('user');
        $userPress->setTelephone('0123456789');
        $userPress->setEmail('testo@test.fr');
        $userPress->setNewsletter(false);
        $userPress->setBirthDate(new \DateTime());
        $userPress->setUserRoles($this->getReference('press-group'));

        $manager->persist($userAdmin);
        $manager->persist($userUser);
        $manager->persist($userPress);
        $manager->flush();

        $this->addReference('admin-user', $userAdmin);
        $this->addReference('user-user', $userUser);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}
