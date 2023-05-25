<?php

namespace App\Http\Repositories\Candidates;

use App\Cache\BaseCache;
use App\Http\DataTransferObjects\Candidates\CandidateData;
use App\Models\Candidate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CandidateRepositoryDecorator extends BaseCache implements CandidateRepository
{
    /**
     * @param CandidateRepository $candidateRepository
     */
    public function __construct(CandidateRepository $candidateRepository)
    {
        parent::__construct($candidateRepository, 'candidate');
    }

    /**
     * @return Collection|array
     */
    public function getAll(): Collection|array
    {
        return $this->cache::remember($this->key, self::TTL, function () {
            return $this->repository->getAll();
        });
    }

    /**
     * @param int $id
     * @return Candidate|Model|null
     */
    public function getById(int $id): Candidate|Model|null
    {
        return $this->cache::remember($this->key, self::TTL, function () use ($id) {
            return $this->repository->getById($id);
        });
    }

    /**
     * @param CandidateData $candidateData
     * @return Candidate|Model|null
     */
    public function save(CandidateData $candidateData): Candidate|Model|null
    {
        $this->forget($this->key);
        return $this->repository->save($candidateData);
    }
}
