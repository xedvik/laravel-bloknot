<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Domains\Auth\DTO\RegisterDTO;
use App\Domains\Auth\UseCases\RegisterUserUseCase;
use App\Http\Requests\RegisterRequest;

class ApiRegisterController extends Controller {

    public function __construct(
        private RegisterUserUseCase $registerUserUseCase,
    ){}

    public function auth(RegisterRequest $request)
    {
        $dto = new RegisterDTO(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password')
        );
        $response = $this->registerUserUseCase->execute($dto);
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