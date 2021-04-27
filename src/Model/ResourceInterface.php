<?php declare(strict_types=1);


namespace App\Model;


use Symfony\Component\Uid\Uuid;

interface ResourceInterface
{
    public function getUuid(): Uuid;

    public function getId(): string;
    public function setId(string $id): void;
}
