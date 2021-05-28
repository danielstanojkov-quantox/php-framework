<?php

namespace App\Models;

use App\Core\Model;

class RegisterModel extends Model
{
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $password = '';
    public string $passwordConfirm = '';

    public function register()
    {
        echo "creating user...";
    }

    public function rules(): array
    {
        return [
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN => 8], [self::RULE_MAX => 24]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH => 'password']],
        ];
    }
}
