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
        $user->setEmail('scoom@gmail.com');
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

        $user3 = new User();
        $user3->setUsername('benJt');
        $user3->setEmail('benjt123@gmail.com');
        $user3->setImageName('default-avatar.jpg');
        $user3->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user3->setFirstName('Benjamin');
        $user3->setLastName('Tourette');
        $user3->setSkill($this->getReference('skill'));
        $user3->setStreetNumber("14");
        $user3->setRoute("rue de l'égalité");
        $user3->setLocality("Talence");
        $user3->setCountry("France");
        $user3->setLat(48.862725);
        $user3->setLng(2.287592000000018);
        $user3->setRoles(["ROLE_USER"]);
        $user3->setEnabled(1);

        $user4 = new User();
        $user4->setUsername('wonderlandHP');
        $user4->setEmail('wonderlandhp@gmail.com');
        $user4->setImageName('default-avatar.jpg');
        $user4->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user4->setFirstName('Camille');
        $user4->setLastName('Mourlas');
        $user4->setSkill($this->getReference('skill2'));
        $user4->setStreetNumber("14");
        $user4->setRoute("rue de l'égalité");
        $user4->setLocality("Saint-Pierre-Des-Corps");
        $user4->setCountry("France");
        $user4->setLat(47.3864352);
        $user4->setLng(0.7143925999999965);
        $user4->setRoles(["ROLE_USER"]);
        $user4->setEnabled(1);

        $user5 = new User();
        $user5->setUsername('davidAD');
        $user5->setEmail('davidad123@gmail.com');
        $user5->setImageName('default-avatar.jpg');
        $user5->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user5->setFirstName('David');
        $user5->setLastName('Decelle');
        $user5->setSkill($this->getReference('skill'));
        $user5->setStreetNumber("10");
        $user5->setRoute("rue de beaumont");
        $user5->setLocality("Beaumont");
        $user5->setCountry("France");
        $user5->setLat(46.756722);
        $user5->setLng(0.42861340000001746);
        $user5->setRoles(["ROLE_USER"]);
        $user5->setEnabled(1);

        $user6 = new User();
        $user6->setUsername('Elsa Destange');
        $user6->setEmail('elsad123@gmail.com');
        $user6->setImageName('default-avatar.jpg');
        $user6->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user6->setFirstName('Elsa');
        $user6->setLastName('Destange');
        $user6->setSkill($this->getReference('skill5'));
        $user6->setStreetNumber("10");
        $user6->setRoute("Rue du Clos Gaultier");
        $user6->setLocality("Poitiers");
        $user6->setCountry("France");
        $user6->setLat(46.5650992);
        $user6->setLng(0.34077300000001287);
        $user6->setRoles(["ROLE_USER"]);
        $user6->setEnabled(1);


        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);
        $manager->persist($user6);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ SkillFixtures::class ];
    }
}
