<?php declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class NavbarExtension extends AbstractExtension
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_active', [$this, 'isActive']),
        ];
    }

    public function isActive(string $pageSlug):bool
    {
        $request = $this->requestStack->getCurrentRequest();
        $slug = $request->attributes->get('slug');

        return $pageSlug === $slug;
    }
}
