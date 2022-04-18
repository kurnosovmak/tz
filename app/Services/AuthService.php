<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    /**
     * Login user.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function verificationLoginAndPassword(string $email,string $password): bool
    {
        $user = $this->getUserByEmail($email);

        if(!$user || !Hash::check($password, $password)) {
            return false;
        }
        return true;
    }


    /**
     * Generate token.
     *
     * @param User $user
     * @return string
     */
    public function generateToken(User $user): string
    {
        return $user->createToken('api')->plainTextToken;
    }


    /**
     * Logout user.
     *
     * @return bool
     */
    public function logout(): bool
    {
        $user = request()->user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return true;
    }

    /**
     * Register new user.
     *
     * @param string $email
     * @param string $password
     * @return User|false
     */
    public function register(string $email,string $password): User|false
    {
        if($this->getUserByEmail($email)){
            return false;
        }

        return User::create([
            'name' => $email,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }

    /**
     * Get user.
     *
     * @param string $email
     * @return User|null
     */
    private function getUserByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }
}
