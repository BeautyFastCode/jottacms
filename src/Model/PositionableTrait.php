<?php declare(strict_types=1);


namespace App\Model;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

trait PositionableTrait
{
    /**
     * @ORM\Column(name="c_position", type="integer", options={"default"="1"})
     * @Gedmo\SortablePosition()
     *
     * @Assert\Range(min="1")
     */
    private int $position = 1;

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }
}
