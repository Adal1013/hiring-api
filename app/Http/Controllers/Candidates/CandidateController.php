<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\Candidates\CandidateData;
use App\Http\Requests\StoreCandidateRequest;
use App\Http\Resources\Candidates\CandidateCollectionResource;
use App\Http\Resources\Candidates\CandidateResource;
use App\Http\Services\Candidates\CandidateService;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * @param CandidateService $candidateService
     */
    public function __construct(protected CandidateService $candidateService)
    {
    }

    /**
     * Display all resource
     *
     * @return CandidateCollectionResource
     */
    public function index(): CandidateCollectionResource
    {
        return new CandidateCollectionResource($this->candidateService->getAll());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return CandidateResource
     */
    public function show(int $id): CandidateResource
    {
        return new CandidateResource($this->candidateService->getById($id), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCandidateRequest $request
     * @return CandidateResource
     */
    public function store(StoreCandidateRequest $request): CandidateResource
    {
        $request->merge(['createdBy' => Auth::user()->id]);
        return new CandidateResource($this->candidateService->create(CandidateData::from($request)), 201);
    }
}
