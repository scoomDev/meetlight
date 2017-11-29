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
        $user->setImageName('default-avatar.jpg');
        $user->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user->setFirstName('Christopher');
        $user->setLastName('Soetaert');
        $user->setSkill($this->getReference('skill4'));
        $user->setStreetNumber("60");
        $user->setRoute("rue Louis Braille");
        $user->setLocality("Mons-en-Baroeul");
        $user->setCountry("France");
        $user->setLat(50.6377714);
        $user->setLng(3.0962342000000262);
        $user->setRoles(["ROLE_USER"]);
        $user->setEnabled(1);

        $user2 = new User();
        $user2->setUsername('scoomarts');
        $user2->setEmail('soetaert.chris@gmail.com');
        $user2->setImageName('default-avatar.jpg');
        $user2->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user2->setFirstName('Christopher');
        $user2->setLastName('Soetaert');
        $user2->setSkill($this->getReference('skill'));
        $user2->setStreetNumber("14");
        $user2->setRoute("rue de l'égalité");
        $user2->setLocality("Saint-Pierre-Des-Corps");
        $user2->setCountry("France");
        $user2->setLat(47.3864352);
        $user2->setLng(0.7143925999999965);
        $user2->setRoles(["ROLE_ADMIN"]);
        $user2->setEnabled(1);

        $manager->persist($user);
        $manager->persist($user2);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
                SkillFixtures::class
        ];
    }
}
