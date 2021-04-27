<?php declare(strict_types=1);


namespace App\Repository;


use App\Entity\PageInterface;

interface PageRepositoryInterface extends EntityRepository
{
    public function findPagesForMenu(?string $locale): array;
    public function findOneActiveBySlug(string $slug, string $locale): ?PageInterface;

    public function qbForAssociationField(): \Closure;
}
