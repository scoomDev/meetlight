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

        $skill5 = new Skill();
        $skill5->setSkill('Modèle');

        $manager->persist($skill);
        $manager->persist($skill2);
        $manager->persist($skill3);
        $manager->persist($skill4);
        $manager->persist($skill5);
        $manager->flush();

        $this->setReference('skill', $skill);
        $this->setReference('skill2', $skill2);
        $this->setReference('skill3', $skill3);
        $this->setReference('skill4', $skill4);
        $this->setReference('skill5', $skill5);
    }
}
