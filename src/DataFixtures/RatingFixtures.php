<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\BookmarkFactory;
use App\Factory\RatingFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use function Zenstruck\Foundry\repository;

class RatingFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $users = repository(User::class);

        foreach ($users as $user) {
            foreach (BookmarkFactory::randomRange(3, 7) as $bookmark) {
                RatingFactory::createOne([
                    'user' => $user,
                    'bookmark' => $bookmark,
                ]);
            }
        }
    }

    public function getDependencies()
    {
        return [
            BookmarkFixtures::class,
            UserFixtures::class,
        ];
    }
}
