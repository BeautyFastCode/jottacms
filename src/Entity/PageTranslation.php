<?php declare(strict_types=1);


namespace App\Entity;


use App\Model\ResourceTrait;
use App\Model\TranslatableInterface;
use App\Model\TranslationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="jotta_page_translation")
 * @ORM\Entity()
 *
 * @UniqueEntity("slug") //todo: slug + locale, translatable + locale
 */
class PageTranslation implements PageTranslationInterface
{
    use ResourceTrait;
    use TranslationTrait;

    /**
     * @ORM\Column(name="c_title", type="string", length=255)
     *
     * @Assert\Length(min=2, max=255)
     * @Assert\NotNull()
     */
    private string $title;

    /**
     * @ORM\Column(name="c_slug", type="string", length=190, unique=true)
     *
     * @Assert\Length(max=190)
     */
    private string $slug;

    /**
     * @ORM\Column(name="c_lead", type="text", nullable=true)
     *
     * @Assert\Length(min=2)
     */
    private ?string $lead;

    /**
     * @ORM\ManyToOne(targetEntity="PageInterface", inversedBy="translations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="c_page_id", referencedColumnName="uuid",
     *      nullable=false, onDelete="cascade")
     * })
     *
     */
    private TranslatableInterface $translatable;

    public function __toString(): string
    {
        return (string) $this->getTitle();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getLead(): ?string
    {
        return $this->lead;
    }

    public function setLead(?string $lead): void
    {
        $this->lead = $lead;
    }
}
