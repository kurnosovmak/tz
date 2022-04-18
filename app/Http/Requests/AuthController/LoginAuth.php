<?php

namespace App\Http\Requests\AuthController;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginAuth extends FormRequest
{
    /**
     * @var mixed
     */


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $isValidCredentials = $this->checkCredentials($this->email, $this->password);

        return [
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string',
            function ($attribute, $value, $fail) use ($isValidCredentials) {
                if ($isValidCredentials) {
                    $fail('The provided credentials are incorrect.');
                }
            }
        ];
    }

    private function checkCredentials($login, $password): bool
    {
        return Auth::attempt(['email' => $login, 'password' => $password]);
    }
}
