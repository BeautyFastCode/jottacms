<?php declare(strict_types=1);


namespace App\Model;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait ToggleableTrait
{
    /**
     * @ORM\Column(name="c_enabled", type="boolean")
     *
     * @Assert\Type("bool")
     */
    private bool $enabled = true;

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function disable(): void
    {
        $this->enabled = false;
    }
}
