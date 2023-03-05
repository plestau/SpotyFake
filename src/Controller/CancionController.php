<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Form\CancionType;
use App\Repository\CancionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/cancion')]
class CancionController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/', name: 'app_cancion_index', methods: ['GET'])]
    public function index(CancionRepository $cancionRepository): Response
    {
        return $this->render('cancion/index.html.twig', [
            'cancions' => $cancionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cancion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CancionRepository $cancionRepository): Response
    {
        $cancion = new Cancion();
        $form = $this->createForm(CancionType::class, $cancion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cancionRepository->save($cancion, true);

            return $this->redirectToRoute('app_cancion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cancion/new.html.twig', [
            'cancion' => $cancion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cancion_show', methods: ['GET'])]
    public function show(Cancion $cancion): Response
    {
        return $this->render('cancion/show.html.twig', [
            'cancion' => $cancion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cancion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cancion $cancion, CancionRepository $cancionRepository): Response
    {
        $form = $this->createForm(CancionType::class, $cancion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cancionRepository->save($cancion, true);

            return $this->redirectToRoute('app_cancion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cancion/edit.html.twig', [
            'cancion' => $cancion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cancion_delete', methods: ['POST'])]
    public function delete(Request $request, Cancion $cancion, CancionRepository $cancionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cancion->getId(), $request->request->get('_token'))) {
            $cancionRepository->remove($cancion, true);
        }

        return $this->redirectToRoute('app_cancion_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/cancion/{id}/reproducir", name="app_reproducir_cancion")
     */
    public function reproducir(Cancion $cancion): Response
    {
        $cancion->setReproducciones($cancion->getReproducciones() + 1);
        $this->entityManager->persist($cancion);
        $this->entityManager->flush();

        return $this->render('cancion/reproduciendo.html.twig', [
            'cancion' => $cancion,
        ]);
    }

    /**
     * @Route("/buscar-canciones", name="buscar_canciones")
     */
    public function buscarCanciones(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('q', TextType::class, [
                'label' => 'Buscar canciones:',
                'required' => false,
            ])
            ->add('Buscar', SubmitType::class)
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $query = $data['q'];
            
            $canciones = $this->getDoctrine()->getRepository(Cancion::class)->buscarPorTitulo($query);
            
            return $this->render('cancion/buscar_resultados.html.twig', [
                'canciones' => $canciones,
            ]);
        }
        
        return $this->render('cancion/buscar.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
}
