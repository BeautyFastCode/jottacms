<?php declare(strict_types=1);

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="app_frontend_")
 */
final class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index_no_locale")
     */
    public function indexNoLocale(): RedirectResponse
    {
        return $this->redirectToRoute('app_frontend_homepage', ['_locale' => 'en']);
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('frontend/home/index.html.twig');
    }
}
