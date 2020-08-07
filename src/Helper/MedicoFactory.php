<?php


namespace App\Helper;


use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;

class MedicoFactory
{
    /**
     * @var EspecialidadeRepository
     */
    private $especialidadeRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepository)
    {
        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function criarMedico(string $json): Medico
    {
        $dadosMedico = json_decode($json);
        $especialidadeId = $dadosMedico->especialidadeId;
        $especialidade = $this->especialidadeRepository->find($especialidadeId);

        $medico = new Medico();
        $medico
            ->setCrm($dadosMedico->crm)
            ->setNome($dadosMedico->nome)
            ->setEspecialidade($especialidade);

        return $medico;
    }
}