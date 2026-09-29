<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'user_id' => 'U' . strtoupper(Str::random(9)),
            'email' => $input['email'],
            'password' => $input['password'],
            'first_name' => $input['name'],
            'last_name' => '-',
            'role' => 'student',
            'is_active' => true,
            'current_role' => 'student',
            'profile_picture' => null,
        ]);
    }
}
