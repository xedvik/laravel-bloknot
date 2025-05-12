<?php
namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Domains\Auth\DTO\RegisterDTO;
use App\Domains\Auth\UseCases\RegisterUserUseCase;
use App\Http\Requests\RegisterRequest;
class WebRegisterController extends Controller {

    public function __construct(private RegisterUserUseCase $registerUserUseCase){}

    public function index()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $dto = new RegisterDTO(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password')
        );
        $response = $this->registerUserUseCase->execute($dto);
        if(!$response->success){
            return back()->withErrors(['message' => $response->message]);
        }
        Auth::login($response->userModel);
        return redirect()->route('main');
    }
}