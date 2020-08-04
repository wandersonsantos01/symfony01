<?php


namespace App\Controller;


use App\Entity\Medico;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicosController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/medicos", methods={"POST"})
     */
    public function novo(Request $response) : Response
    {
        $corpoRequisicao = $response->getContent();
        $dadosMedico = json_decode($corpoRequisicao);

        $medico = new Medico();
        $medico->crm = $dadosMedico->crm;
        $medico->nome = $dadosMedico->nome;

        $this->entityManager->persist($medico);
        $this->entityManager->flush();

        return new JsonResponse($medico);
        
    }

    /**
     * @Route("/medicos", methods={"GET"})
     */
    public function listar() : Response
    {
        $medicos = $this->getDoctrine()->getRepository(Medico::class);
        $medicosList = $medicos->findAll();

        return new JsonResponse($medicosList);
    }

    /**
     * @Route("/medicos/{id}", methods={"GET"})
     */
    public function recuperar(Request $request): Response
    {
        $medicos = $this->getDoctrine()->getRepository(Medico::class);
        $medico = $medicos->find($request->get("id"));

        $codigoRetorno = is_null($medico) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse($medico, $codigoRetorno);
    }
}