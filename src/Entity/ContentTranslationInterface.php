<?php declare(strict_types=1);


namespace App\Entity;


use App\Model\ResourceInterface;
use App\Model\TranslationInterface;

interface ContentTranslationInterface extends
    ResourceInterface,
    TranslationInterface
{
    public function getTitle(): ?string;
    public function setTitle(?string $title): void;

    public function getText(): ?string;
    public function setText(?string $text): void;
}
