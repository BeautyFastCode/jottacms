<?php declare(strict_types=1);

namespace App\Entity;

use App\Constant\Locale;
use App\Model\PositionableTrait;
use App\Model\ResourceTrait;
use App\Model\TimestampableTrait;
use App\Model\ToggleableTrait;
use App\Model\TranslatableTrait;
use App\Model\TranslationInterface;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="jotta_page")
 * @ORM\Entity(repositoryClass=PageRepository::class)
 *
 */
class Page implements PageInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use ToggleableTrait;
    use PositionableTrait;
    use TranslatableTrait;

    /**
     * @ORM\Column(name="c_icon", type="string", length=32, nullable=true)
     *
     * @Assert\Length(max=32)
     */
    private ?string $icon;

    /**
     * @var Collection<PageTranslationInterface>|PageTranslationInterface[]
     *
     * @ORM\OneToMany(targetEntity="PageTranslationInterface", mappedBy="translatable",
     *     fetch="EXTRA_LAZY", orphanRemoval=true, cascade={"persist", "merge", "remove"})
     *
     * @Assert\Valid()
     */
    private Collection $translations;

    /**
     * @var Collection|ContentInterface[]
     *
     * @ORM\OneToMany(targetEntity="ContentInterface", mappedBy="page",
     *     fetch="EXTRA_LAZY", orphanRemoval=true, cascade={"persist", "merge", "remove"})
     *
     * @Assert\Valid()
     */
    private Collection $contents;

    public function __construct()
    {
        self::createUuid();

        $this->translations = new ArrayCollection();
        $this->contents = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getTitle();
    }

    public function getTitle(): string
    {
        return $this->getTranslation()->getTitle();
    }

    public function setTitle(string $title): void
    {
        $this->getTranslation()->setTitle($title);
    }

    //todo: generate this virtual fields in one method

    public function getTitleEn(): string
    {
        return $this->getTranslation(Locale::EN)->getTitle();
    }

    public function setTitleEn(string $title): void
    {
        $this->getTranslation(Locale::EN)->setTitle($title);
    }

    public function getTitlePl(): string
    {
        return $this->getTranslation(Locale::PL)->getTitle();
    }

    public function setTitlePl(string $title): void
    {
        $this->getTranslation(Locale::PL)->setTitle($title);
    }

    public function getSlug(): string
    {
        return $this->getTranslation()->getSlug();
    }

    public function setSlug(string $slug): void
    {
        $this->getTranslation()->setSlug($slug);
    }

    public function getSlugEn(): string
    {
        return $this->getTranslation(Locale::EN)->getSlug();
    }

    public function setSlugEn(string $slug): void
    {
        $this->getTranslation(Locale::EN)->setSlug($slug);
    }

    public function getSlugPl(): string
    {
        return $this->getTranslation(Locale::PL)->getSlug();
    }

    public function setSlugPl(string $slug): void
    {
        $this->getTranslation(Locale::PL)->setSlug($slug);
    }

    public function getLead(): ?string
    {
        return $this->getTranslation()->getLead();
    }

    public function setLead(?string $lead): void
    {
        $this->getTranslation()->setLead($lead);
    }

    public function getLeadEn(): ?string
    {
        return $this->getTranslation(Locale::EN)->getLead();
    }

    public function setLeadEn(?string $lead): void
    {
        $this->getTranslation(Locale::EN)->setLead($lead);
    }

    public function getLeadPl(): ?string
    {
        return $this->getTranslation(Locale::PL)->getLead();
    }

    public function setLeadPl(?string $lead): void
    {
        $this->getTranslation(Locale::PL)->setLead($lead);
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function getContentsCount(): int
    {
        return $this->contents->count();
    }

    public function addContent(ContentInterface $content): void
    {
        if(!$this->contents->contains($content)) {

            $this->contents->set($content->getId(), $content);
            $content->setPage($this);
        }
    }

    public function removeContent(ContentInterface $content): void
    {
        if($this->contents->removeElement($content)) {

            if($content->getPage() === $this) {
                $content->setPage(null);
            }
        }
    }

    protected function createTranslation(): TranslationInterface
    {
        $pageTranslation = new PageTranslation();

        $pageTranslation->createUuid();
        $pageTranslation->setTitle('');
        $pageTranslation->setSlug('');

        return $pageTranslation;
    }

}
