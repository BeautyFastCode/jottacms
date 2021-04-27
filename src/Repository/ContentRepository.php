<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Content;
use App\Entity\ContentInterface;

/**
 * @method ContentInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentInterface[]    findAll()
 * @method ContentInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ContentRepository extends BaseEntityRepository implements ContentRepositoryInterface
{
    protected function getSupportsEntityName(): string
    {
        return Content::class;
    }
}
