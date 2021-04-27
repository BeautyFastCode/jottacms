<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Constant\DateTimeFormat;
use App\Entity\Content;
use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="app_admin_")
 */
final class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin')
            ->renderContentMaximized()
//            ->renderSidebarMinimized()
            ;
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateTimeFormat(DateTimeFormat::NORMAL)
            ->setPaginatorPageSize(10)
//            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->addFormTheme('admin/crud/form/ckeditor5_widget.html.twig')
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-tachometer-alt');

        yield MenuItem::section('CMS');
        yield MenuItem::linkToCrud('Pages', 'fas fa-file-alt', Page::class);
        yield MenuItem::linkToCrud('Contents', 'fas fa-list', Content::class);
        yield MenuItem::section('Other');
        yield MenuItem::linkToUrl('Back to the frontend', 'fa fa-long-arrow-alt-left', '/');
        yield MenuItem::linkToLogout('Sign out', 'fa fa-sign-out-alt');
    }

    public function configureActions(): Actions
    {
        return Actions::new()
            ->add(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)

            ->add(Crud::PAGE_DETAIL, Action::EDIT)
            ->add(Crud::PAGE_DETAIL, Action::INDEX)
            ->add(Crud::PAGE_DETAIL, Action::DELETE)
            ->add(Crud::PAGE_DETAIL, Action::NEW)

            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_EDIT, Action::DELETE)
            ->add(Crud::PAGE_EDIT, Action::NEW)
            ->add(Crud::PAGE_EDIT, Action::DETAIL)

            ->add(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ;
    }
}
