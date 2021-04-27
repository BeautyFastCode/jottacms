<?php declare(strict_types=1);


namespace App\Model;


interface PositionableInterface
{
    public function getPosition(): int;
    public function setPosition(int $position): void;
}
