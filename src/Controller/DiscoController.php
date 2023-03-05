<?php

namespace App\Controller;

use App\Entity\Disco;
use App\Form\DiscoType;
use App\Repository\DiscoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/disco')]
class DiscoController extends AbstractController
{
    #[Route('/', name: 'app_disco_index', methods: ['GET'])]
    public function index(DiscoRepository $discoRepository): Response
    {
        return $this->render('disco/index.html.twig', [
            'discos' => $discoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_disco_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DiscoRepository $discoRepository): Response
    {
        $disco = new Disco();
        $form = $this->createForm(DiscoType::class, $disco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $discoRepository->save($disco, true);

            return $this->redirectToRoute('app_disco_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disco/new.html.twig', [
            'disco' => $disco,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_disco_show', methods: ['GET'])]
    public function show(Disco $disco): Response
    {
        return $this->render('disco/show.html.twig', [
            'disco' => $disco,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_disco_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Disco $disco, DiscoRepository $discoRepository): Response
    {
        $form = $this->createForm(DiscoType::class, $disco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $discoRepository->save($disco, true);

            return $this->redirectToRoute('app_disco_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('disco/edit.html.twig', [
            'disco' => $disco,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_disco_delete', methods: ['POST'])]
    public function delete(Request $request, Disco $disco, DiscoRepository $discoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disco->getId(), $request->request->get('_token'))) {
            $discoRepository->remove($disco, true);
        }

        return $this->redirectToRoute('app_disco_index', [], Response::HTTP_SEE_OTHER);
    }
}
