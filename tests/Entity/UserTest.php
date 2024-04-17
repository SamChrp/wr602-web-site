<?php

namespace App\Tests\Entity;

use App\Entity\Pdf;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetterAndSetter()
    {
        $user = new User();

        // Définition de données de test
        $email = 'test@test.com';
        $firstName = 'John';
        $lastName = 'Doe';
        $password = 'password';
        $roles = ['ROLE_USER'];
        $subscription = new Subscription();
        $pdfs = new ArrayCollection();
        $pdf = new Pdf();
        $pdfs->add($pdf);

        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($password);
        $user->setRoles($roles);
        $user->setSubscription($subscription);
        $user->addPdf($pdf);

        // Vérification des getters
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($roles, $user->getRoles());
        $this->assertEquals($subscription, $user->getSubscription());
        $this->assertEquals($pdfs, $user->getPdfs());
    }
}