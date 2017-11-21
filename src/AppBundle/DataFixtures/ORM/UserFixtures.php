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
        $user->setUsername('scoom');
        $user->setEmail('scoom5@hotmail.com');
        $user->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user->setFirstName('Christopher');
        $user->setLastName('Soetaert');
        $user->setSkill($this->getReference('skill4'));
        $user->setStreetNumber("14");
        $user->setRoute("rue de l'égalité");
        $user->setLocality("Saint-Pierre-Des-Corps");
        $user->setCountry("France");
        $user->setRoles(["ROLE_USER"]);
        $user->setEnabled(1);

        $user2 = new User();
        $user2->setUsername('scoomdev');
        $user2->setEmail('soetaert.chris@gmail.com');
        $user2->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user2->setFirstName('Christopher');
        $user2->setLastName('Soetaert');
        $user2->setSkill($this->getReference('skill'));
        $user2->setStreetNumber("14");
        $user2->setRoute("rue de l'égalité");
        $user2->setLocality("Saint-Pierre-Des-Corps");
        $user2->setCountry("France");
        $user2->setRoles(["ROLE_ADMIN"]);
        $user2->setEnabled(1);

        $manager->persist($user);
        $manager->persist($user2);
        $manager->flush();

        $this->addReference('user', $user);
        $this->addReference('user2', $user2);
    }
}
