<?php declare(strict_types=1);


namespace App\Menu;


use App\Repository\PageRepositoryInterface;

final class MenuService
{
    private PageRepositoryInterface $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getPages(?string $locale): array
    {
        return $this->pageRepository->findPagesForMenu($locale);
    }
}
