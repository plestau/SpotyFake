<?php
namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Disco;
use App\Entity\Cantante;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $entityManager = $this->doctrine->getManager();

        // Obtener las últimas 10 canciones
        $cancionesNuevas = $entityManager->getRepository(Cancion::class)->findBy([], ['id' => 'DESC'], 5);

        // Contar cuántas veces se reproduce cada canción
        $contadorCanciones = [];

        // Obtener el número de reproducciones de cada cantante
        $cantantes = $entityManager->getRepository(Cantante::class)->findAll();
        foreach ($cantantes as $cantante) {
            $contadorCanciones[$cantante->getId()] = $cantante->getReproduccionesTotales();
        }

        // Ordenar las canciones por popularidad
        $cancionesPopulares = $entityManager->getRepository(Cancion::class)->findBy([], ['reproducciones' => 'DESC'], 5);

        $form = $this->createFormBuilder()
            ->add('Buscar', TextType::class)
            ->add('buscar', SubmitType::class, array('label' => 'Buscar'))
            ->getForm();
            $form ->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $query = $data['Buscar'];
                $canciones = $this->buscarCancionesPorTitulo($query);
                $discos = $this->buscarDiscosPorTitulo($query);
                $cantantes = $this->buscarCantantesPorNombre($query);
            }
        return $this->render('home/index.html.twig', [
            'cancionesNuevas' => $cancionesNuevas,
            'cancionesTendencia' => $cancionesPopulares,
            'cantantesTendencia' => $cantantes,
            'contadorCanciones' => $contadorCanciones,
            'form' => $form->createView(),
            'canciones' => $canciones ?? null,
            'discos' => $discos ?? null,
            'cantantes' => $cantantes ?? null,
        ]);
    }
    private function buscarCancionesPorTitulo(string $query) {
        $entityManager = $this->doctrine->getManager();
        $canciones = $entityManager->getRepository(Cancion::class)->buscarPorTituloCancion($query);
        return $canciones;
    }
    private function buscarDiscosPorTitulo(string $query) {
        $entityManager = $this->doctrine->getManager();
        $discos = $entityManager->getRepository(Disco::class)->buscarPorTituloDisco($query);
        return $discos;
    }
    private function buscarCantantesPorNombre(string $query) {
        $entityManager = $this->doctrine->getManager();
        $cantantes = $entityManager->getRepository(Cantante::class)->buscarPorNombre($query);
        return $cantantes;
    }
}
