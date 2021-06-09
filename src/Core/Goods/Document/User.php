<?php

declare(strict_types=1);

namespace App\Core\Goods\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Goods\Enum\Role;
use App\Core\Goods\Enum\UserStatus;
use App\Core\Goods\Repository\UserRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(repositoryClass=UserRepository::class, collection="users")
 */
class User extends AbstractDocument implements UserInterface
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $firstName;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $lastName;

    /**
     * @MongoDB\Field(type="int")
     */
    protected ?int $age = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $phone = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $email;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $dateOfBirth = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $regDate = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $cityUser = null;

    /**
     * @MongoDB\Field(type="float")
     */
    protected ?float $rating = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $status;

    /**
     * @var string[]
     *
     * @MongoDB\Field(type="collection")
     */
    protected array $roles = [];

    public function __construct(
        string $firstName,
        string $lastName,
        int    $age,
        string $phone,
        string $email,
        string $dateOfBirth,
        string $regDate,
        string $cityUser,
        float  $rating,
        string $status,
        array  $roles
    ) {
        $this->firstName   = $firstName;
        $this->lastName    = $lastName;
        $this->age         = $age;
        $this->phone       = $phone;
        $this->email       = $email;
        $this->dateOfBirth = $dateOfBirth;
        $this->regDate     = $regDate;
        $this->cityUser    = $cityUser;
        $this->rating      = $rating;
        $this->status      = $status;

        array_map([$this, 'addRole'], $roles);

        $this->addDefaultRole();
    }


    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array<string> $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;

        $this->addDefaultRole();
    }

    public function addRole(string $role): void
    {
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
    }


    public function getId(): ?string
    {
        return $this->id;
    }


    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): void
    {
        $this->age = $age;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?string $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getRegDate(): ?string
    {
        return $this->regDate;
    }

    public function setRegDate(?string $regDate): void
    {
        $this->regDate = $regDate;
    }

    public function getCityUser(): ?string
    {
        return $this->cityUser;
    }

    public function setCityUser(?string $cityUser): void
    {
        $this->cityUser = $cityUser;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): void
    {
        $this->rating = $rating;
    }

    private function addDefaultRole(): void
    {
        $this->addRole(Role::USER);
    }

    public function getPassword(): string
    {
        return $this->phone;
    }

    public function getSalt(): string
    {
        return md5($this->status);
    }

    public function getUsername(): string
    {
        return $this->status;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }


    public function eraseCredentials(): void
    {
    }
}
