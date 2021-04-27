<?php declare(strict_types=1);


namespace App\Controller\Admin;


use App\Constant\OrderBy;
use App\Entity\Content;
use App\Field\CKEditor5Field;
use App\Filter\Admin\PageFilter;
use App\Repository\PageRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

final class ContentCrudController extends AbstractCrudController
{
    private PageRepositoryInterface $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Content::class;
    }

    public function createEntity(string $entityFqcn): Content
    {
        /** @var Content $entity */
        $entity = new $entityFqcn();
        $entity->createDefaultTranslations();

        return $entity;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['page.position' => OrderBy::ASC, 'position' => OrderBy::ASC])
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

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(PageFilter::new('page'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('General')->setIcon('fas fa-list');


        yield TextField::new('title')->onlyOnIndex();

        yield AssociationField::new('page')
            ->setQueryBuilder($this->pageRepository->qbForAssociationField())
        ;

        yield BooleanField::new('enabled');
        yield IntegerField::new('position');
        yield NumberField::new('translationsCount')->setLabel('Translations')->hideOnForm();

        if ($pageName !== Crud::PAGE_INDEX) {

            yield FormField::addPanel('Translations (English)')->setIcon('fas fa-language');
            yield TextField::new('titleEn', 'Title')->setVirtual(true);
            yield CKEditor5Field::new('textEn', 'Text')->setVirtual(true);

            yield FormField::addPanel('Translations (Polish)')->setIcon('fas fa-language');
            yield TextField::new('titlePl')->setVirtual(true)->setLabel('Title');
            yield CKEditor5Field::new('textPl', 'Text')->setVirtual(true);
        }

        yield FormField::addPanel('Timestamp')->setIcon('fas fa-clock')->onlyOnDetail();
        yield DateTimeField::new('createdAt')->onlyOnDetail();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }

}
