<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Skill;

class SkillFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $skill = new Skill();
        $skill->setSkill('Photographe');

        $skill2 = new Skill();
        $skill2->setSkill('Maquilleur/euse');

        $skill3 = new Skill();
        $skill3->setSkill('Styliste');

        $skill4 = new Skill();
        $skill4->setSkill('Coiffeur/euse');

        $manager->persist($skill);
        $manager->persist($skill2);
        $manager->persist($skill3);
        $manager->persist($skill4);
        $manager->flush();

        $this->addReference('skill', $skill);
    }
}
