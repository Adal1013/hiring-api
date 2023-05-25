<?php

namespace App\Http\Repositories\Candidates;

use App\Http\DataTransferObjects\Candidates\CandidateData;
use App\Models\Candidate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CandidateRepository
{
    /**
     * @return Collection|array
     */
    public function getAll(): Collection|array;

    /**
     * @param int $id
     * @return Candidate|Model|null
     */
    public function getById(int $id): Candidate|Model|null;

    /**
     * @param CandidateData $candidateData
     * @return Candidate|Model|null
     */
    public function save(CandidateData $candidateData): Candidate|Model|null;
}
