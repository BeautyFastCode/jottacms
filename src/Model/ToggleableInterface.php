<?php declare(strict_types=1);


namespace App\Model;


interface ToggleableInterface
{
    public function isEnabled(): bool;

    public function setEnabled(bool $enabled): void;

    public function enable(): void;
    public function disable(): void;
}
