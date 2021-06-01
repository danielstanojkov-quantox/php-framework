<?php

namespace App\Models;

use App\Core\UserModel;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $passwordConfirm = '';

    public function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'firstName',
            'lastName',
            'email',
            'password',
            'status'
        ];
    }

    public function getDisplayName(): string
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->status = self::STATUS_INACTIVE;
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN => 8], [self::RULE_MAX => 24]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH => 'password']],
        ];
    }

    public function labels(): array
    {
        return [
            'firstName' => 'First name',
            'lastName' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'passwordConfirm' => 'Confirm Password',
        ];
    }
}
