<?php declare(strict_types=1);


namespace App\Model;


interface TranslationInterface
{
    public function getLocale(): string;
    public function setLocale(string $locale): void;

    public function getTranslatable(): TranslatableInterface;
    public function setTranslatable(TranslatableInterface $translatable): void;
}
