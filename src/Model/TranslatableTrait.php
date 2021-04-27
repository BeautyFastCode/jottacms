<?php declare(strict_types=1);


namespace App\Model;


use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Webmozart\Assert\Assert as WebAssert;

trait TranslatableTrait
{
    /**
     * @var Collection|TranslationInterface[]
     *
     * @ORM\OneToMany(targetEntity="TranslationInterface", mappedBy="translatable",
     *     fetch="EXTRA_LAZY", orphanRemoval=true, cascade={"persist", "merge", "remove"})
     *
     * @Assert\Valid()
     */
    private Collection $translations;

    private ?string $currentLocale = null;
    private string $fallbackLocale = 'en';

    /**
     * Create resource translation model.
     *
     * @return TranslationInterface
     */
    abstract protected function createTranslation(): TranslationInterface;

    public function createDefaultTranslations(): void
    {
        $translation = $this->createTranslation();
        $translation->setLocale('en');

        $this->addTranslation($translation);

        $translation = $this->createTranslation();
        $translation->setLocale('pl');

        $this->addTranslation($translation);
    }

    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function getTranslationsCount(): int
    {
        return $this->translations->count();
    }

    public function hasTranslation(TranslationInterface $translation): bool
    {
        return $this->translations->containsKey($translation->getLocale());
    }

    public function addTranslation(TranslationInterface $translation): void
    {
        if(!$this->hasTranslation($translation)) {

            $this->translations->set($translation->getLocale(), $translation);
            $translation->setTranslatable($this);
        }
    }

    public function removeTranslation(TranslationInterface $translation): void
    {
        if($this->translations->removeElement($translation)) {

            if($translation->getTranslatable() === $this) {
                $translation->setTranslatable(null);
            }
        }
    }

    public function getTranslation(?string $locale = null): TranslationInterface
    {
        $locale = $locale ?: $this->currentLocale;
        $locale = $locale ?: $this->fallbackLocale;

        WebAssert::notNull($locale, 'No locale has been set and current locale is undefined.');

        $expr = new Comparison('locale', '=', $locale);
        $translation = $this->translations->matching(new Criteria($expr))->first();

        WebAssert::notFalse($translation, sprintf('Not found translation for locale %s', $locale));

        return $translation;
    }

    public function setCurrentLocale(string $currentLocale): void
    {
        $this->currentLocale = $currentLocale;
    }
}
