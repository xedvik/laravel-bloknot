<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Domains\Auth\DTO\LoginDTO;
use App\Domains\Auth\UseCases\LoginUserUseCase;
use App\Http\Requests\LoginRequest;

class ApiAuthController extends Controller {

    public function __construct(
        private LoginUserUseCase $loginUseCase,
    ){}

    public function auth(LoginRequest $login)
    {
        $dto = new LoginDTO(
            email: $login->input('email'),
            password: $login->input('password')
        );
        $response = $this->loginUseCase->execute($dto);
        if(!$response->success){
            return response()->json([
                'status' => 'error',
                'message' => $response->message,
            ],401);
        }

        $token = $response->userModel->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => $response->message,
            'token' => $token,
        ]);
    }
}