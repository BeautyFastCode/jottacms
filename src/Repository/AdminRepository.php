<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Admin;
use App\Entity\AdminInterface;

/**
 * @method AdminInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminInterface[]    findAll()
 * @method AdminInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class AdminRepository extends BaseUserRepository implements AdminRepositoryInterface
{
    protected function getSupportsEntityName(): string
    {
        return Admin::class;
    }
}
