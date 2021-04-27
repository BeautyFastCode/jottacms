<?php declare(strict_types=1);


namespace App\Entity;


use App\Model\PositionableInterface;
use App\Model\ResourceInterface;
use App\Model\TimestampableInterface;
use App\Model\ToggleableInterface;
use App\Model\TranslatableInterface;

interface ContentInterface extends
    ResourceInterface,
    TimestampableInterface,
    ToggleableInterface,
    PositionableInterface,
    TranslatableInterface
{
    public function getTitle(): ?string;
    public function setTitle(?string $title): void;

    public function getText(): ?string;
    public function setText(?string $text): void;

    public function getPage(): PageInterface;
    public function setPage(PageInterface $page): void;
}
