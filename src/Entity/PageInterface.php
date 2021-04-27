<?php declare(strict_types=1);


namespace App\Entity;


use App\Model\PositionableInterface;
use App\Model\ResourceInterface;
use App\Model\SlugAwareInterface;
use App\Model\TimestampableInterface;
use App\Model\ToggleableInterface;
use App\Model\TranslatableInterface;
use Doctrine\Common\Collections\Collection;

interface PageInterface extends
    ResourceInterface,
    TimestampableInterface,
    SlugAwareInterface,
    ToggleableInterface,
    PositionableInterface,
    TranslatableInterface
{
    public function getTitle(): string;
    public function setTitle(string $title): void;

    public function getLead(): ?string;
    public function setLead(?string $lead): void;

    public function getIcon(): ?string;
    public function setIcon(?string $icon): void;

    public function getContents(): Collection;
    public function getContentsCount(): int;

    public function addContent(ContentInterface $content): void;
    public function removeContent(ContentInterface $content): void;
}
