<?php declare(strict_types=1);


namespace App\Model;


use Doctrine\Common\Collections\Collection;

interface TranslatableInterface
{
    public function createDefaultTranslations(): void;

    public function getTranslations(): Collection;
    public function getTranslationsCount(): int;

    public function hasTranslation(TranslationInterface $translation): bool;

    public function addTranslation(TranslationInterface $translation): void;
    public function removeTranslation(TranslationInterface $translation): void;

    public function getTranslation(?string $locale = null): TranslationInterface;

    public function setCurrentLocale(string $currentLocale): void;
}
