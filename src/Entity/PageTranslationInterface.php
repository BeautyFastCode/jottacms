<?php declare(strict_types=1);


namespace App\Entity;


use App\Model\ResourceInterface;
use App\Model\SlugAwareInterface;
use App\Model\TranslationInterface;

interface PageTranslationInterface extends
    ResourceInterface,
    SlugAwareInterface,
    TranslationInterface
{
    public function getTitle(): string;
    public function setTitle(string $title): void;

    public function getLead(): ?string;
    public function setLead(?string $lead): void;
}
