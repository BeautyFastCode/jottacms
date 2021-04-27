<?php declare(strict_types=1);


namespace App\Model;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Webmozart\Assert\Assert as WebAssert;

trait ResourceTrait
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     *
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    private Uuid $uuid;

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function createUuid(): void
    {
        $this->uuid = Uuid::v4();
    }

    public function getId(): string
    {
        return (string) $this->uuid;
    }

    public function setId(string $id): void
    {
        WebAssert::uuid($id, sprintf('Invalid Uuid: %s', $id));

        $this->uuid = Uuid::fromString($id);
    }

}
