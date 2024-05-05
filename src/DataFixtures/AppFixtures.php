<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Livres;
use App\Entity\Categorie;
use Faker\Factory as FakerFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    

    {  
        
        $faker = Factory::create('fr_FR');
        for($j=1;$j<=3;$j++){
            $cat=new Categorie();
            $cat->setLibelle($faker->name())
            ->setSlug($faker->name())
            ->setDescription($faker->paragraph(3));
            $manager->persist($cat);


        for ($i=0; $i < 100; $i++) {
        $Livre = new Livres();
        $Livre->setTitre($faker->name)
        ->setEditeur($faker->company()  )
        ->setISBN($faker->isbn13())
        ->setPrix($faker->numberBetween(1, 1000))
        ->setEditedAt(new \DateTimeImmutable('01-01-2024'))
        ->setSlug($faker->name)
        ->setResume($faker->sentence(20))
        ->setQte(random_int(1, 100))
        ->setImage($faker->imageUrl(300, 300));
    $manager->persist($Livre);
   
    }

        $manager->flush();
    }
}}
