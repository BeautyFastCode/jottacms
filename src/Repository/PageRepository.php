<?php declare(strict_types=1);

namespace App\Repository;

use App\Constant\OrderBy;
use App\Entity\Page;
use App\Entity\PageInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

/**
 * @method PageInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageInterface[]    findAll()
 * @method PageInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PageRepository extends BaseEntityRepository implements PageRepositoryInterface
{
    protected function getSupportsEntityName(): string
    {
        return Page::class;
    }

    public function findPagesForMenu(?string $locale): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.enabled = true')
        ;

        if(is_null($locale)) {

            $queryBuilder
                ->addSelect('t')
                ->leftJoin('p.translations', 't', null, null, 't.locale')
                ;

        } else {

            $queryBuilder
                ->addSelect('t')
                ->leftJoin('p.translations', 't', Join::WITH, 't.locale = :locale', 't.locale')
                ->setParameter('locale', $locale)
            ;
        }

        $queryBuilder->orderBy('p.position', OrderBy::ASC);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findOneActiveBySlug(string $slug, string $locale): ?PageInterface
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.enabled = true')
            ->addSelect('c, t, ct')
            ->leftJoin('p.translations', 't', Join::WITH, 't.locale = :locale', 't.locale')
            ->leftJoin('p.contents', 'c', Join::WITH, 'c.enabled = true')
            ->leftJoin('c.translations', 'ct', Join::WITH, 'ct.locale = :locale', 'ct.locale')
            ->andWhere('t.slug = :slug')
            ->setParameter('locale', $locale)
            ->setParameter('slug', $slug)
        ;

        $queryBuilder->orderBy('c.position', OrderBy::ASC);

        try {
            return $queryBuilder->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function qbForAssociationField(): \Closure
    {
        return function (QueryBuilder $queryBuilder) {
            $queryBuilder
                ->where('entity.enabled = true')
                ->orderBy('entity.position', OrderBy::ASC)
            ;
        };
    }

}
