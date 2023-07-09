<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\ExcelData;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        // Création d'un user "normal"
        $user = new User();
        $user->setEmail("user@excelapi.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);
        
        // Création d'un user admin
        $userAdmin = new User();
        $userAdmin->setEmail("admin@excelapi.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $manager->persist($userAdmin);
        
        for ($i = 0; $i < 20; $i++) {
            $excelData = new ExcelData;
            $excelData->setName('Data '.$i);
            $excelData->setData(['TestData'.$i]);
            if($i % 2 == 0) {
                $excelData->setUser($user);
            } else {
                $excelData->setUser($userAdmin);
            }
            $manager->persist($excelData);
        }

        $manager->flush();
    }
}
