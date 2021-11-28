<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
       foreach ( range('A', 'M') as  $value) 
        { 
            $country = new Country();
            $country->setName( $value );

            for ($j=0; $j < rand(3,29); $j++) { 
                $city = new City();
                $city->setName( $country->getName()."#".$j);
                $city->setCountry( $country );
                $manager->persist($city);
            }
            $manager->persist($country);
        }

        $manager->flush();
    }
}
