<?php

namespace App\Http\Controllers\Api\Auth;

use App\Common\Helpers\Query\OracleProcedure;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\User\Employee;
use App\Models\User\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use PDO;

class LoginController extends Controller
{
    public function __invoke(UserLoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $procedure = new OracleProcedure('AuthenticateUser', [
            'pUname' => ['value' => $validated['username']],
            'pPSW' => ['value' => $validated['password']],
            'pUserIP' => ['value' => $request->server('REMOTE_ADDR')],
            'pDeviceInfo' => ['value' => $request->server('HTTP_USER_AGENT')],
            'pIsVerified' => ['value' => 0, 'isOut' => true, 'type' => PDO::PARAM_INT],
            'pRes' => ['value' => 0, 'isOut' => true, 'type' => PDO::PARAM_INT],
        ]);
        $procedure->call();
        $result = $procedure->getOutputParams();

        $user = Student::find($validated['username']);

        if (empty($user)) {
            $user = Employee::where("hname", $validated['username'])->first();
        }

        if ($result['pIsVerified']['value'] != 1 || empty($user)) {
            throw ValidationException::withMessages([
                'user' => ['The provided credentials are incorrect']
            ]);
        }

        $token = $user->createToken('Auth Token')->accessToken;
        return response()->json(['res' => [
            'access_token' => $token,
        ]]);
    }
}
