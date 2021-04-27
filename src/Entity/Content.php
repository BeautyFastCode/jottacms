<?php declare(strict_types=1);

namespace App\Entity;

use App\Constant\Locale;
use App\Model\PositionableTrait;
use App\Model\ResourceTrait;
use App\Model\TimestampableTrait;
use App\Model\ToggleableTrait;
use App\Model\TranslatableTrait;
use App\Model\TranslationInterface;
use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="jotta_content")
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 */
class Content implements ContentInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use ToggleableTrait;
    use PositionableTrait;
    use TranslatableTrait;

    /**
     * @var Collection<ContentTranslationInterface>|ContentTranslationInterface[]
     *
     * @ORM\OneToMany(targetEntity="ContentTranslationInterface", mappedBy="translatable",
     *     fetch="EXTRA_LAZY", orphanRemoval=true, cascade={"persist", "merge", "remove"})
     *
     * @Assert\Valid()
     */
    private Collection $translations;

    /**
     * @ORM\ManyToOne(targetEntity="PageInterface", inversedBy="contents")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="c_page_id", referencedColumnName="uuid",
     *      nullable=false, onDelete="cascade")
     * })
     * @Gedmo\SortableGroup()
     *
     * @Assert\NotNull()
     */
    private PageInterface $page;

    public function __construct()
    {
        self::createUuid();

        $this->translations = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getTitle();
    }

    public function getTitle(): ?string
    {
        return $this->getTranslation()->getTitle();
    }

    public function setTitle(?string $title): void
    {
        $this->getTranslation()->setTitle($title);
    }

    public function getTitleEn(): ?string
    {
        return $this->getTranslation(Locale::EN)->getTitle();
    }

    public function setTitleEn(?string $title): void
    {
        $this->getTranslation(Locale::EN)->setTitle($title);
    }

    public function getTitlePl(): ?string
    {
        return $this->getTranslation(Locale::PL)->getTitle();
    }

    public function setTitlePl(?string $title): void
    {
        $this->getTranslation(Locale::PL)->setTitle($title);
    }

    public function getText(): ?string
    {
        return $this->getTranslation()->getText();
    }

    public function setText(?string $text): void
    {
        $this->getTranslation()->setText($text);
    }

    public function getTextEn(): string
    {
        return $this->getTranslation(Locale::EN)->getText();
    }

    public function setTextEn(string $title): void
    {
        $this->getTranslation(Locale::EN)->setText($title);
    }

    public function getTextPl(): string
    {
        return $this->getTranslation(Locale::PL)->getText();
    }

    public function setTextPl(string $title): void
    {
        $this->getTranslation(Locale::PL)->setText($title);
    }

    public function getPage(): PageInterface
    {
        return $this->page;
    }

    public function setPage(PageInterface $page): void
    {
        $this->page = $page;
    }

    protected function createTranslation(): TranslationInterface
    {
        $contentTranslation = new ContentTranslation();

        $contentTranslation->createUuid();
        $contentTranslation->setTitle('');
        $contentTranslation->setText('');

        return $contentTranslation;
    }
}
