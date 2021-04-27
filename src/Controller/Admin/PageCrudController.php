<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Constant\OrderBy;
use App\Entity\Page;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

final class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function createEntity(string $entityFqcn): Page
    {
        /** @var Page $entity */
        $entity = new $entityFqcn();
        $entity->createDefaultTranslations();

        return $entity;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['position' => OrderBy::ASC])
            ;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $queryBuilder
            ->addSelect('t')
            ->leftJoin('entity.translations', 't', null, null, 't.locale')
        ;

        return $queryBuilder;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('General')->setIcon('fas fa-file-alt');

        yield TextField::new('icon')
            ->setTemplatePath('admin/crud/field/icon.html.twig');

        yield TextField::new('title')->onlyOnIndex();

        yield BooleanField::new('enabled');
        yield IntegerField::new('position');

        yield NumberField::new('contentsCount')->setLabel('Contents')->hideOnForm();
        yield NumberField::new('translationsCount')->setLabel('Translations')->hideOnForm();


        if ($pageName !== Crud::PAGE_INDEX ) {

            yield FormField::addPanel('Translations (English)')->setIcon('fas fa-language');
            yield TextField::new('titleEn')->setVirtual(true)->setLabel('Title');
            yield SlugField::new('slugEn')
                ->setTargetFieldName('titleEn')->setVirtual(true)->setLabel('Slug');
            yield TextEditorField::new('leadEn')->setVirtual(true)->setLabel('Lead');


            yield FormField::addPanel('Translations (Polish)')->setIcon('fas fa-language');
            yield TextField::new('titlePl')->setVirtual(true)->setLabel('Title');
            yield SlugField::new('slugPl')
                ->setTargetFieldName('titlePl')->setVirtual(true)->setLabel('Slug');
            yield TextEditorField::new('leadPl')->setVirtual(true)->setLabel('Lead');
        }

        if($pageName === Crud::PAGE_DETAIL) {

            yield FormField::addPanel('Contents')->setIcon('fas fa-list');
            yield CollectionField::new('contents')
                ->setTemplatePath('admin/crud/field/contents.html.twig')
                ->onlyOnDetail()
            ;
        }

        yield FormField::addPanel('Timestamp')->setIcon('fas fa-clock')->onlyOnDetail();
        yield DateTimeField::new('createdAt')->onlyOnDetail();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }

}
