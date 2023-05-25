<?php

namespace App\Http\Services\Candidates;

use App\Exceptions\GeneralException;
use App\Http\DataTransferObjects\Candidates\CandidateData;
use App\Http\Repositories\Candidates\CandidateRepository;
use App\Models\Candidate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CandidateServiceImpl implements CandidateService
{
    /**
     * @param CandidateRepository $candidateRepository
     */
    public function __construct(protected CandidateRepository $candidateRepository)
    {
    }

    /**
     * @return Collection|array
     */
    public function getAll(): Collection|array
    {
        return $this->candidateRepository->getAll();
    }

    /**
     * @param int $id
     * @return Candidate|Model|null
     */
    public function getById(int $id): Candidate|Model|null
    {
        return $this->candidateRepository->getById($id);
    }

    /**
     * @param CandidateData $candidateData
     * @return Candidate|Model|null
     * @throws GeneralException
     */
    public function create(CandidateData $candidateData): Candidate|Model|null
    {
        DB::beginTransaction();
        try {
            $candidate = $this->candidateRepository->save($candidateData);
            DB::commit();
            return $candidate;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Ha ocurrido un error al crear un candidato: ' . $exception->getMessage());
            throw new GeneralException('Ha ocurrido un error, contactar con el administrador.', 500);
        }
    }
}
