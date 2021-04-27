<?php declare(strict_types=1);


namespace App\Entity;


use App\Model\ResourceTrait;
use App\Model\TranslatableInterface;
use App\Model\TranslationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="jotta_content_translation")
 * @ORM\Entity()
 */
class ContentTranslation implements ContentTranslationInterface
{
    use ResourceTrait;
    use TranslationTrait;

    /**
     * @ORM\Column(name="c_title", type="string", length=255, nullable=true)
     *
     * @Assert\Length(max=255)
     */
    private ?string $title;

    /**
     * @ORM\Column(name="c_text", type="text", nullable=true)
     *
     */
    private ?string $text;

    /**
     * @ORM\ManyToOne(targetEntity="ContentInterface", inversedBy="translations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="c_content_id", referencedColumnName="uuid",
     *      nullable=false, onDelete="cascade")
     * })
     *
     */
    private TranslatableInterface $translatable;

    public function __toString(): string
    {
        return is_null($this->getTitle()) ? $this->getId() : $this->getTitle();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

}
