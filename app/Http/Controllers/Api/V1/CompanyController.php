<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\DTO\Controller\Request\CreateCompanyRequest;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Services\CompanyServiceInterface;
use Illuminate\Http\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @OA\Tag(name="Company")
 */
class CompanyController extends Controller
{
    public function __construct(
        private CompanyServiceInterface $companyService,
        private SerializerInterface $serializer
    )
    {
    }

    /**
     * @OA\Get(
     *    tags={"Company"},
     *    path="/api/v1/company",
     *    description="Get companies",
     *    summary="Return companies",
     *    @OA\Response(
     *        response=200,
     *        description="Array of companies",
     *        @OA\JsonContent(
     *            type="array",
     *            @OA\Items(
     *               @OA\Property(
     *                   property="id",
     *                   nullable=false,
     *                   description="Id",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="title",
     *                   nullable=false,
     *                   description="Name",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   nullable=true,
     *                   description="Company email",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="logo_url",
     *                   nullable=true,
     *                   description="Company logo url",
     *                   type="string"
     *                ),
     *                @OA\Property(
     *                   property="website",
     *                   nullable=true,
     *                   description="Company website url",
     *                   type="string"
     *                ),
     *            )
     *        ),
     *    ),
     * )
     */
    public function index(): Response
    {
        $company = $this->companyService->getAll();
        $data    = $this->serializer->serialize($company, JsonEncoder::FORMAT);
        return new Response($data, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     tags={"Company"},
     *     path="/api/v1/company",
     *     description="Create company",
     *     summary="Create company",
     *     @OA\RequestBody(
     *          description="New body",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="title",
     *                  nullable=false,
     *                  description="Tile",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="content",
     *                  nullable=false,
     *                  description="Content",
     *                  type="string"
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Validation exceptions",
     *          @OA\JsonContent(
     *            type="object",
     *            @OA\Property(
     *                  property="id",
     *                  nullable=false,
     *                  description="Id",
     *                  type="integer"
     *            ),
     *            @OA\Property(
     *                  property="title",
     *                  nullable=false,
     *                  description="Title",
     *                  type="string"
     *            ),
     *            @OA\Property(
     *                  property="content",
     *                  nullable=false,
     *                  description="Content",
     *                  type="string"
     *            ),
     *            @OA\Property(
     *                  property="createAt",
     *                  nullable=false,
     *                  description="Create at",
     *                  type="integer"
     *            ),
     *            @OA\Property(
     *                  property="updateAt",
     *                  nullable=false,
     *                  description="Update At",
     *                  type="integer"
     *            ),
     *        ),
     *     ),
     * )
     */
    public function create(CompanyStoreRequest $request): Response
    {
        $company = $this->companyService->create($this->createAndValidateRequest($request));
        $data    = $this->serializer->serialize($company, JsonEncoder::FORMAT);

        return new Response($data, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *    tags={"Company"},
     *    path="/api/v1/company/{id}",
     *    description="Get company by id",
     *    summary="Return company by id",
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="company id",
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="event",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(
     *                  property="id",
     *                  nullable=false,
     *                  description="Id",
     *                  type="integer"
     *            ),
     *            @OA\Property(
     *                  property="title",
     *                  nullable=false,
     *                  description="Title",
     *                  type="string"
     *            ),
     *            @OA\Property(
     *                  property="content",
     *                  nullable=false,
     *                  description="Content",
     *                  type="string"
     *            ),
     *            @OA\Property(
     *                  property="createAt",
     *                  nullable=false,
     *                  description="Create at",
     *                  type="integer"
     *            ),
     *            @OA\Property(
     *                  property="updateAt",
     *                  nullable=false,
     *                  description="Update At",
     *                  type="integer"
     *            ),
     *        ),
     *    ),
     * )
     */
    public function getById(int $id): Response
    {
        $company = $this->companyService->getResponseById($id);
        $data    = $this->serializer->serialize($company, JsonEncoder::FORMAT);

        return new Response($data, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     tags={"Company"},
     *     path="/api/v1/company",
     *     description="Update company by id",
     *     summary="Update company by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Company id",
     *     ),
     *     @OA\RequestBody(
     *          description="Update company body",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="title",
     *                  nullable=false,
     *                  description="Tile",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="content",
     *                  nullable=false,
     *                  description="Content",
     *                  type="string"
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="company",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(
     *                  property="id",
     *                  nullable=false,
     *                  description="Id",
     *                  type="integer"
     *            ),
     *            @OA\Property(
     *                  property="title",
     *                  nullable=false,
     *                  description="Title",
     *                  type="string"
     *            ),
     *            @OA\Property(
     *                  property="content",
     *                  nullable=false,
     *                  description="Content",
     *                  type="string"
     *            ),
     *            @OA\Property(
     *                  property="createAt",
     *                  nullable=false,
     *                  description="Create at",
     *                  type="integer"
     *            ),
     *            @OA\Property(
     *                  property="updateAt",
     *                  nullable=false,
     *                  description="Update At",
     *                  type="integer"
     *            ),
     *        ),
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Validation exceptions",
     *
     *     ),
     * )
     */
    public function update(CompanyStoreRequest $request, int $id): Response
    {
        $company = $this->companyService->update($id, $this->createAndValidateRequest($request));
        $data    = $this->serializer->serialize($company, JsonEncoder::FORMAT);
        return new Response($data, Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     tags={"Company"},
     *     path="/api/v1/company/{id}",
     *     description="Delete company by id",
     *     summary="Delete company by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="company id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deleted"
     *     ),
     * )
     */
    public function delete(int $id): Response
    {
        $this->companyService->deleteById($id);
        return new Response(null, Response::HTTP_OK);
    }

    private function createAndValidateRequest(CompanyStoreRequest $request): CreateCompanyRequest
    {
        $createCompanyRequest = $this->serializer->deserialize(
            $request->getValidatedData(),
            CreateCompanyRequest::class,
            JsonEncoder::FORMAT
        );
        $logo = $request->getLogo();
        if (!empty($logo)) {
            $createCompanyRequest->setLogo($logo);
        }
        return $createCompanyRequest;
    }


}
