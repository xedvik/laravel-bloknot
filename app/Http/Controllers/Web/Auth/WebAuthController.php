<?php
namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Domains\Auth\DTO\LoginDTO;
use App\Domains\Auth\UseCases\LoginUserUseCase;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class WebAuthController extends Controller {

    public function __construct(private LoginUserUseCase $loginUseCase){}

    public function index()
    {
        return view('auth.login');
    }

    public function auth(LoginRequest $login)
    {
        $dto = new LoginDTO(
            email: $login->input('email'),
            password: $login->input('password')
        );
        $response = $this->loginUseCase->execute($dto);
        if(!$response->success){
            return back()->withErrors(['message' => $response->message]);
        }
        Auth::login($response->userModel);
        return redirect()->route('main');
    }
    public function logout(Request $request): RedirectResponse
{
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
}
}