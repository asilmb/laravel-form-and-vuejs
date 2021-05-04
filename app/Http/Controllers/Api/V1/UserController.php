<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\DTO\Controller\Request\CreateUserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Services\MessagingServiceInterface;
use App\Http\Services\UserCompanyServiceInterface;
use App\Http\Services\UserServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @OA\Tag(name="User")
 */
class UserController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService,
        private SerializerInterface $serializer,
        private UserCompanyServiceInterface $userCompanyService,
        private MessagingServiceInterface $messagingService
    )
    {
    }

    /**
     * @OA\Get(
     *    tags={"User"},
     *    path="/api/v1/user",
     *    description="Get users",
     *    summary="Return users",
     *    @OA\Response(
     *        response=200,
     *        description="Array of users",
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
     *                   property="First name",
     *                   nullable=false,
     *                   description="First Name",
     *                   type="string"
     *               ),
     *              @OA\Property(
     *                   property="Last name",
     *                   nullable=false,
     *                   description="Last Name",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   nullable=true,
     *                   description="User email",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="company",
     *                   nullable=true,
     *                   description="User company",
     *                   type="object"
     *               ),
     *            )
     *        ),
     *    ),
     * )
     */
    public function index(): Response
    {
        $user = $this->userService->getAll();
        $data = $this->serializer->serialize($user, JsonEncoder::FORMAT);
        return new Response($data, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     tags={"User"},
     *     path="/api/v1/user",
     *     description="Create user",
     *     summary="Create user",
     *     @OA\RequestBody(
     *          description="New body",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(
     *                   property="First name",
     *                   nullable=false,
     *                   description="First Name",
     *                   type="string"
     *               ),
     *              @OA\Property(
     *                   property="Last name",
     *                   nullable=false,
     *                   description="Last Name",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   nullable=true,
     *                   description="User email",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   nullable=true,
     *                   description="User password",
     *                   type="string"
     *               ),
     *          ),
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Validation exceptions",
     *          @OA\JsonContent(
     *            type="object",
     *               @OA\Property(
     *                   property="id",
     *                   nullable=false,
     *                   description="Id",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="First name",
     *                   nullable=false,
     *                   description="First Name",
     *                   type="string"
     *               ),
     *              @OA\Property(
     *                   property="Last name",
     *                   nullable=false,
     *                   description="Last Name",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   nullable=true,
     *                   description="User email",
     *                   type="string"
     *               ),
     *        ),
     *     ),
     * )
     */
    public function create(UserStoreRequest $request): Response
    {
        $createUserRequest = $this->serializer->deserialize(
            json_encode($request->validated()),
            CreateUserRequest::class,
            JsonEncoder::FORMAT
        );

        $user = $this->userService->create($createUserRequest);
        $data = $this->serializer->serialize($user, JsonEncoder::FORMAT);

        return new Response($data, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *    tags={"User"},
     *    path="/api/v1/user/{id}",
     *    description="Get user by id",
     *    summary="Return user by id",
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="user id",
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="event",
     *        @OA\JsonContent(
     *            type="object",
     *               @OA\Property(
     *                   property="id",
     *                   nullable=false,
     *                   description="Id",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="First name",
     *                   nullable=false,
     *                   description="First Name",
     *                   type="string"
     *               ),
     *              @OA\Property(
     *                   property="Last name",
     *                   nullable=false,
     *                   description="Last Name",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   nullable=true,
     *                   description="User email",
     *                   type="string"
     *               ),
     *        ),
     *    ),
     * )
     */
    public function getById(int $id): Response
    {
        $user = $this->userService->getResponseById($id);
        $data = $this->serializer->serialize($user, JsonEncoder::FORMAT);

        return new Response($data, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     tags={"User"},
     *     path="/api/v1/user",
     *     description="Update user by id",
     *     summary="Update user by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User id",
     *     ),
     *     @OA\RequestBody(
     *          description="Update user body",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(
     *                   property="First name",
     *                   nullable=false,
     *                   description="First Name",
     *                   type="string"
     *               ),
     *              @OA\Property(
     *                   property="Last name",
     *                   nullable=false,
     *                   description="Last Name",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   nullable=true,
     *                   description="User email",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   nullable=true,
     *                   description="User password",
     *                   type="string"
     *               ),
     *          ),
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="user",
     *        @OA\JsonContent(
     *            type="object",
     *               @OA\Property(
     *                   property="id",
     *                   nullable=false,
     *                   description="Id",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="First name",
     *                   nullable=false,
     *                   description="First Name",
     *                   type="string"
     *               ),
     *              @OA\Property(
     *                   property="Last name",
     *                   nullable=false,
     *                   description="Last Name",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   nullable=true,
     *                   description="User email",
     *                   type="string"
     *               ),
     *        ),
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Validation exceptions",
     *
     *     ),
     * )
     */
    public function update(UserStoreRequest $request, int $id): Response
    {
        $updateUser = $this->serializer->deserialize(
            json_encode($request->validated()),
            CreateUserRequest::class,
            JsonEncoder::FORMAT
        );

        $user = $this->userService->update($id, $updateUser);
        $data = $this->serializer->serialize($user, JsonEncoder::FORMAT);
        return new Response($data, Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     tags={"User"},
     *     path="/api/v1/user/{id}",
     *     description="Delete user by id",
     *     summary="Delete user by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="user id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deleted"
     *     ),
     * )
     */
    public function delete(int $id): Response
    {
        $this->userService->deleteById($id);
        return new Response(null, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     tags={"user"},
     *     path="/api/v1/user/company/{id}",
     *     description="Appoint current user to id",
     *     summary="Appoint current user to id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="company id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointed"
     *     ),
     * )
     */
    public function appointCompanyById(int $id): Response
    {
        $user = $this->userCompanyService->appointToCompany(Auth::id(), $id);
     // $this->messagingService->send(($user->email ?? ''), []); // todo: fix data dependency
        return new Response(null, Response::HTTP_OK);
    }
}
