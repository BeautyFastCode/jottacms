<?php declare(strict_types=1);

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

/**
 * @Route(name="app_frontend_")
 */
final class TranslationController extends AbstractController
{
    /**
     * @Route("/translation.js/{_locale<%app.supported_locales%>}", name="translation_js")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $locale = $request->getLocale();
        $file = __DIR__.'/../../../translations/messages.'.$locale.'.yaml';

        $parsed = Yaml::parse(file_get_contents($file));
        $json = json_encode($parsed);

        $translations = $this->renderView('frontend/translation.js.twig', [ 'json' => $json ] );

        return new Response($translations, 200, ['Content-Type' => 'text/javascript']);
    }
}
