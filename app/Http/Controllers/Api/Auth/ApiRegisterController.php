<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Domains\Auth\DTO\RegisterDTO;
use App\Domains\Auth\UseCases\RegisterUserUseCase;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class ApiRegisterController extends Controller {

    public function __construct(
        private RegisterUserUseCase $registerUserUseCase,
    ){}

    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        try {
            $dto = new RegisterDTO(
                name: $registerRequest->input('name'),
                email: $registerRequest->input('email'),
                password: $registerRequest->input('password')
            );

            $response = $this->registerUserUseCase->execute($dto);

            if(!$response->success){
                return response()->json([
                    'status' => 'error',
                    'message' => $response->message,
                ], 422);
            }

            $token = $response->userModel->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => $response->message,
                'token' => $token,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Произошла ошибка при регистрации',
            ], 500);
        }
    }
}
