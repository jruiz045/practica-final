<?php

namespace App\Controller;

use App\Entity\App;
use App\Form\AppType;
use App\Repository\AppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app")
 */
class AppController extends AbstractController
{
    /**
     * @Route("/", name="app_index", methods={"GET"})
     */
    public function index(AppRepository $appRepository): Response
    {
        return $this->render('app/index.html.twig', [
            'apps' => $appRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $app = new App();
        $form = $this->createForm(AppType::class, $app);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($app);
            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('app/new.html.twig', [
            'app' => $app,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_show", methods={"GET"})
     */
    public function show(App $app): Response
    {
        return $this->render('app/show.html.twig', [
            'app' => $app,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, App $app): Response
    {
        $form = $this->createForm(AppType::class, $app);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('app/edit.html.twig', [
            'app' => $app,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_delete", methods={"DELETE"})
     */
    public function delete(Request $request, App $app): Response
    {
        if ($this->isCsrfTokenValid('delete'.$app->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($app);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_index');
    }
}
