<?php
namespace App\DTOs;

use Spatie\LaravelData\Data;

class RegisterRequestDTO extends Data
{
    public string $name;
    public string $email;
    public string $password;

}