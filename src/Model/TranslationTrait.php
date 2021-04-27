<?php declare(strict_types=1);


namespace App\Model;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait TranslationTrait
{
    /**
     * @ORM\Column(name="c_locale", type="string", length=12)
     *
     * @Assert\Length(min=2, max=12)
     * @Assert\NotNull()
     */
    private string $locale;

    /**
     * @ORM\ManyToOne(targetEntity="TranslatableInterface", inversedBy="translations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="c_translatable_id", referencedColumnName="uuid",
     *      nullable=false, onDelete="cascade")
     * })
     *
     */
    private TranslatableInterface $translatable;

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getTranslatable(): TranslatableInterface
    {
        return $this->translatable;
    }

    public function setTranslatable(TranslatableInterface $translatable): void
    {
        $this->translatable = $translatable;
    }
}
