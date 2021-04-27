<?php declare(strict_types=1);


namespace App\Filter\Admin;


use App\Constant\OrderBy;
use App\Entity\Page;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PageFilterType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Page::class,
            'query_builder' => function (EntityRepository $repository) {

                return $repository
                    ->createQueryBuilder('p')
                    ->orderBy('p.position', OrderBy::ASC)
                    ;
            }
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
