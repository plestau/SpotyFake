<?php

namespace App\Controller;

use App\Entity\Cantante;
use App\Form\CantanteType;
use App\Repository\CantanteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cantante')]
class CantanteController extends AbstractController
{
    #[Route('/', name: 'app_cantante_index', methods: ['GET'])]
    public function index(CantanteRepository $cantanteRepository): Response
    {
        return $this->render('cantante/index.html.twig', [
            'cantantes' => $cantanteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cantante_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CantanteRepository $cantanteRepository): Response
    {
        $cantante = new Cantante();
        $form = $this->createForm(CantanteType::class, $cantante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cantanteRepository->save($cantante, true);

            return $this->redirectToRoute('app_cantante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cantante/new.html.twig', [
            'cantante' => $cantante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cantante_show', methods: ['GET'])]
    public function show(Cantante $cantante): Response
    {
        $reproduccionesTotales = $cantante->getReproduccionesTotales();

        return $this->render('cantante/show.html.twig', [
            'cantante' => $cantante,
            'reproduccionesTotales' => $reproduccionesTotales
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cantante_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cantante $cantante, CantanteRepository $cantanteRepository): Response
    {
        $form = $this->createForm(CantanteType::class, $cantante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cantanteRepository->save($cantante, true);

            return $this->redirectToRoute('app_cantante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cantante/edit.html.twig', [
            'cantante' => $cantante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cantante_delete', methods: ['POST'])]
    public function delete(Request $request, Cantante $cantante, CantanteRepository $cantanteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cantante->getId(), $request->request->get('_token'))) {
            $cantanteRepository->remove($cantante, true);
        }

        return $this->redirectToRoute('app_cantante_index', [], Response::HTTP_SEE_OTHER);
    }


}
