<?php declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\PageTranslation;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\SlugType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PageTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locale', TextType::class, [
                'disabled' => true
            ])
            ->add('title', TextType::class)
            ->add('slug', SlugType::class, [
                'target' => 'title'
            ])
            ->add('lead', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PageTranslation::class,
        ]);
    }
}
