<?php declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Repository\PageRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route(name="app_frontend_")
 */
final class PageController extends AbstractController
{
    private PageRepositoryInterface $pageRepository;
    private TranslatorInterface $translator;

    public function __construct(PageRepositoryInterface $pageRepository, TranslatorInterface $translator)
    {
        $this->pageRepository = $pageRepository;
        $this->translator = $translator;
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/{slug}", name="page")
     *
     * @param string $_locale
     * @param string $slug
     *
     * @return Response
     */
    public function index(string $_locale, string $slug): Response
    {
        $page = $this->pageRepository->findOneActiveBySlug($slug, $_locale);

        if(is_null($page)) {

            $message = $this->translator->trans('error.pageNotFound');
            throw $this->createNotFoundException($message);
        }

        $page->setCurrentLocale($_locale);

        return $this->render('frontend/page/index.html.twig', ['page' => $page ]);
    }
}
