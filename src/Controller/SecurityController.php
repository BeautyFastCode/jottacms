<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class SecurityController extends AbstractController
{
    /**
     * @Route("/{_locale<%app.supported_locales%>}/login", name="app_login", priority="1")
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('frontend/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

//    /**
//     * @Route("/login", name="app_login", priority="1")
//     *
//     * @param AuthenticationUtils $authenticationUtils
//     *
//     * @return Response
//     */
//    public function login(AuthenticationUtils $authenticationUtils): Response
//    {
//        $error = $authenticationUtils->getLastAuthenticationError();
//        $lastUsername = $authenticationUtils->getLastUsername();
//
//        return $this->render('@EasyAdmin/page/login.html.twig', [
//            'last_username' => $lastUsername,
//            'error' => $error,
//            'page_title' => 'Admin Login',
//            'csrf_token_intention' => 'authenticate',
//            'target_path' => $this->generateUrl('app_admin_dashboard'),
//        ]);
//    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/logout", name="app_logout", priority="1")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
