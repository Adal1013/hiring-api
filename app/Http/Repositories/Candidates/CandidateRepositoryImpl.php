<?php

namespace App\Http\Repositories\Candidates;

use App\Http\DataTransferObjects\Candidates\CandidateData;
use App\Models\Candidate;
use Illuminate\Database\Eloquent\Model;

class CandidateRepositoryImpl implements CandidateRepository
{
    /**
     * @param int $id
     * @return Candidate|Model|null
     */
    public function getById(int $id): Candidate|Model|null
    {
        return Candidate::findOrFail($id);
    }

    /**
     * @param CandidateData $candidateData
     * @return Candidate|Model|null
     */
    public function save(CandidateData $candidateData): Candidate|Model|null
    {
        return Candidate::create([
            'name' => $candidateData->name,
            'source' => $candidateData->source,
            'owner' =>  $candidateData->owner,
            'created_by' => $candidateData->createdBy
        ]);
    }
}
