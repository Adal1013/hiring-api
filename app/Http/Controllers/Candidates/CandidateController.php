<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\Candidates\CandidateData;
use App\Http\Requests\StoreCandidateRequest;
use App\Http\Resources\Candidates\CandidateCollectionResource;
use App\Http\Resources\Candidates\CandidateResource;
use App\Http\Services\Candidates\CandidateService;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;


class CandidateController extends Controller
{
    /**
     * @param CandidateService $candidateService
     */
    public function __construct(protected CandidateService $candidateService)
    {
    }

    /**
     * Display all resources.
     * Mostramos todos los registros de candidatos.
     * @return CandidateCollectionResource
     *
     * @OA\Get(
     *     path="/api/v1/auth/leads",
     *     tags={"Candidates"},
     *     summary="Obtener todos los candidatos",
     *     operationId="getCandidates",
     *
     *     @OA\Response(response="200", description="Listar Candidatos"),
     *     @OA\Response(response="401", description="Unauthorized."),
     *     @OA\Response(response="500", description="Server error."),
     *     security={
     *         {"bearerAuth"={}}
     *     }
     * )
     */
    public function index(): CandidateCollectionResource
    {
        return new CandidateCollectionResource($this->candidateService->getAll());
    }

    /**
     * Display the specified resource.
     * Mostramos el regitro especifico solicitado.
     * @param int $id
     * @return CandidateResource
     *
     * @OA\Get(
     *     path="/api/v1/auth/lead/{id}",
     *     tags={"Candidates"},
     *     summary="Obtener un candidato por su ID",
     *     operationId="getCandidate",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del candidato",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Candidato encontrado"),
     *     @OA\Response(response="401", description="Unauthorized."),
     *     @OA\Response(response="404", description="Candidato no encontrado"),
     *     @OA\Response(response="500", description="Server error."),
     *     security={
     *         {"bearerAuth"={}}
     *     }
     * )
     */
    public function show(int $id): CandidateResource
    {
        return new CandidateResource($this->candidateService->getById($id), 200);
    }

    /**
     * Store a newly created resource in storage.
     * Crea un nuevo registro de candidatos.
     * @param StoreCandidateRequest $request
     * @return CandidateResource
     *
     * @OA\Post(
     *     path="/api/v1/auth/lead",
     *     tags={"Candidates"},
     *     summary="Crea un candidato",
     *     operationId="createCandidate",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "source", "owner"},
     *             @OA\Property(property="name", type="string", example="Adalberto Avila"),
     *             @OA\Property(property="source", type="string", example="Linkedin"),
     *             @OA\Property(property="owner", type="int", example="2"),
     *         )
     *     ),
     *     @OA\Response(response="201", description="Candidato creado exitosamente."),
     *     @OA\Response(response="401", description="Unauthorized."),
     *     @OA\Response(response="422", description="Validation Error."),
     *     @OA\Response(response="500", description="Server error."),
     *     security={
     *         {"bearerAuth"={}}
     *     }
     * )
     */
    public function store(StoreCandidateRequest $request): CandidateResource
    {
        $request->merge(['createdBy' => Auth::user()->id]);
        return new CandidateResource($this->candidateService->create(CandidateData::from($request)), 201);
    }
}
