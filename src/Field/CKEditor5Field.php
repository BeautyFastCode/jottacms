<?php declare(strict_types=1);


namespace App\Field;


use App\Form\Admin\CKEditor5Type;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

final class CKEditor5Field implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/crud/field/ckeditor5.html.twig')
            ->setFormType(CKEditor5Type::class)
            ;
    }
}
