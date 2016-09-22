<?php
// src/UserBundle/DataFixtures/ORM/LoadRoleData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\Role;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $role_user = new Role();
        $role_user->setName('user');
        $role_user->setRole('ROLE_USER');
        $role_admin = new Role();
        $role_admin->setName('admin');
        $role_admin->setRole('ROLE_ADMIN');

        $manager->persist($role_user);
        $manager->persist($role_admin);
        $manager->flush();

        $this->addReference('admin-group', $role_admin);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}
