<?php

namespace App\Http\DataTransferObjects\User;

use Spatie\LaravelData\Data;

class UserLoginData extends Data
{
    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(public string $username, public string $password)
    {
    }

    /**
     * @return string[]
     */
    public static function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }
}
