<?php

declare(strict_types=1);

namespace App\Api\Goods\Dto;

class UserResponseDto
{
    public ?string $id;

    public ?string $firstName;

    public ?string $lastName;

    public ?int $age;

    public ?string $phone;

    public string $email;

    public ?string $dateOfBirth;

    public ?string $regDate;

    public ?string $cityUser;

    public ?float $rating;

    public ?string $status;

    public array $roles;
}
