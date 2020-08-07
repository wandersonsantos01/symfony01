<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadesController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var EspecialidadeRepository
     */
    private $especialidadeRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        EspecialidadeRepository $especialidadeRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->especialidadeRepository = $especialidadeRepository;
    }

    /**
     * @Route("/especialidades", name="especialidades", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $dadosJson = json_decode($dadosRequest);

        $especialidade = new Especialidade();
        $especialidade->setDescricao($dadosJson->descricao);

        $this->entityManager->persist($especialidade);
        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }

    /**
     * @Route("/especialidades", methods={"GET"})
     * @return Response
     */
    public function listar(): Response
    {
        $especialidadesList = $this->especialidadeRepository->findAll();

        return new JsonResponse($especialidadesList);
    }

    /**
     * @Route("/especialidades/{id}", methods={"GET"})
     * @param int $id
     * @return JsonResponse
     */
    public function recuperar(int $id)
    {
        $especialidade = $this->especialidadeRepository->find($id);

        return new JsonResponse($especialidade);
    }

    /**
     * @Route("/especialidades/{id}", methods={"PUT"}   )
     * @param Request $request
     * @return Response
     */
    public function atualizar(int $id, Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $dadosJson = json_decode($dadosRequest);

        $especialidade = $this->especialidadeRepository->find($id);
        $especialidade->setDescricao($dadosJson->descricao);

        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }

    /**
     * @Route("/especialidades/{id}", methods={"DELETE"})
     * @param int $id
     * @return Response
     */
    public function deletar(int $id): Response
    {
        $especialidadeExistente = $this->especialidadeRepository->find($id);
        if (is_null($especialidadeExistente)) {
            return new Response('' . Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($especialidadeExistente);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_OK);
    }
}
