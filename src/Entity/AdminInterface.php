<?php declare(strict_types=1);


namespace App\Entity;


use App\Model\ResourceInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface AdminInterface extends UserInterface, ResourceInterface
{
    public function getEmail(): ?string;
    public function setEmail(string $email): void;

    public function setRoles(array $roles): void;
    public function setPassword(string $password): void;

}
