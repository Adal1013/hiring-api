<?php

namespace App\Http\Services\Candidates;

use App\Http\DataTransferObjects\Candidates\CandidateData;
use App\Models\Candidate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CandidateService
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
    public function create(CandidateData $candidateData): Candidate|Model|null;
}
