<?php

namespace App\Services\AuthServices;

use App\DTOs\Service\DTOServiceResponse;
use App\Models\User;
use App\Services\IService\AuthServicesContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthServicesWithPassword implements AuthServicesContract
{

    public function register(Request $request):DTOServiceResponse{

        try {
            Log::info('arriva a questo punto o no ? ? ??  ?');

            $user =User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return new DTOServiceResponse(success:true,singleItem: $user , statusCode: 200);
        }catch (\Exception $exception){
            return new DTOServiceResponse(success:false,singleItem: null , statusCode: 500);
        }
    }

    /**
     * @throws \Exception
     */
    public function login(Request $request): DTOServiceResponse
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                throw new \Exception('Invalid credentials');
            }
            //$user = Auth::user();
            //return $user->createToken('API Token')->plainTextToken;
            $user = User::where('email',$request->email)->first();
            return new DTOServiceResponse(success: true , singleItem: $user , statusCode: 200);
        }catch (\Exception $exception){
            return new DTOServiceResponse(success:false,singleItem: null , statusCode: 500);
        }
    }
}
