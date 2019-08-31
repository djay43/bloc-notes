<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class TaskFixtures extends Fixture
{
    /**
     * 15 Random Tasks
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {

            $task = new Task();
            $task->setName($faker->word)
                 ->setDescription($faker->sentence(rand(3, 6)))
                 ->setEndedAt($faker->dateTimeBetween('now', '+150days'));
            $manager->persist($task);
        }

        $manager->flush();
    }
}
