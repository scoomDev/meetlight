<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('scoomdev');
        $user->setEmail('soetaert.chris@gmail.com');
        $user->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user->setFirstName('Christopher');
        $user->setLastName('Soetaert');
        $user->setSkill($this->getReference('skill'));
        $user->setRoles(["ROLE_USER"]);
        $user->setEnabled(1);

        $manager->persist($user);
        $manager->flush();

        $this->addReference('user', $user);
    }
}
