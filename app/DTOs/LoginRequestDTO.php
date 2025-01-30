<?php
namespace App\DTOs;

use Spatie\LaravelData\Data;

class LoginRequestDTO extends Data
{
    public string $email;
    public string $password;

}