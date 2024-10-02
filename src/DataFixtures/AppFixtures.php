<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tag;
use App\Entity\Offre;
use App\Entity\Service;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private $faker;
    private $manager;

    private const TAGS = ['PHP', 'SYMFONY', 'LARAVEL', 'JS', 'REACT', 'VUE', 'ANGULAR', 'SQL', 'POSTGRESQL'];
    private const SERVICES = ['MARKETING', 'DESIGN', 'DEVELOPMENT', 'SALES', 'ACCOUNTING', 'HR'];

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create('fr_FR');

        $this->loadTags();
        $this->loadServices();

        $manager->flush();

        $this->loadOffres();
        $manager->flush();
    }

    public function loadTags(): void
    {
        foreach (self::TAGS as $tagName) {
            $this->manager->persist($this->createTag($tagName));
        }
    }

    public function loadServices(): void
    {
        foreach (self::SERVICES as $serviceName) {
            $this->manager->persist(
                $this->createServices(
                    $serviceName,
                    $this->faker->phoneNumber,
                    $this->faker->email
                )
            );
        }
    }

    public function loadOffres(): void
    {
        for ($i = 0; $i < 25; $i++) {

            $service = $this->randomService();
            $tags = $this->randomTags();
            $this->manager->persist(
                $this->createOffre(
                    $this->faker->jobTitle,
                    $this->faker->paragraph(3),
                    $this->faker->randomFloat(6, 0, 9999),
                    $service,
                    $tags
                )
            );
        }
    }

    private function createServices(string $nom, string $telephone, string $email): Service
    {
        $service = new Service();
        $service
            ->setNom($nom)
            ->setTelephone($telephone)
            ->setEmail($email)
        ;

        return $service;
    }

    private function createTag(string $nom): Tag
    {
        $tag = new Tag();
        $tag->setNom($nom);

        return $tag;
    }

    private function createOffre(
        string $nom,
        string $description,
        string $salaire,
        Service $service,
        array $tags
    ): Offre {
        $offre = new Offre();
        $offre
            ->setNom($nom)
            ->setDescription($description)
            ->setSalaire($salaire)
            ->setService($service)
        ;

        foreach ($tags as $tag) {
            $offre->addTag($tag);
        }

        return $offre;
    }

    private function randomService(): Service
    {
        return $this->manager->getRepository(Service::class)->findByNom(self::SERVICES[array_rand(self::SERVICES)])[0];
    }

    private function randomTags(): array
    {
        $tags = [];
        for ($j = 0; $j < 3; $j++) {
            $tags[] = $this->manager->getRepository(Tag::class)->findByNom(self::TAGS[array_rand(self::TAGS)])[0];
        }
        return $tags;
    }
}
