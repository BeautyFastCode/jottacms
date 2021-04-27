<?php declare(strict_types=1);


namespace App\Model;


use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

trait TimestampableTrait
{
    /**
     * @ORM\Column(name="c_created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     *
     * @Assert\Type("DateTimeInterface")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(name="c_updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     *
     * @Assert\Type("DateTimeInterface")
     */
    private DateTimeInterface $updatedAt;

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
