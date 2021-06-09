<?php

declare(strict_types=1);

namespace App\Core\Goods\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Goods\Enum\Role;
use App\Core\Goods\Enum\UserStatus;
use App\Core\Goods\Repository\GoodsRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass=GoodsRepository::class, collection="goods")
 */
class Goods extends AbstractDocument
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $title;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $description;

    /**
     * @var string[]
     *
     * @MongoDB\Field(type="collection")
     */
    protected ?array $img = [];

    /**
     * @MongoDB\Field(type="int")
     */
    protected int $cost;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $dateOfPlacement;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $category;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $subcategory;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $city;

    /**
     * @var string[]
     *
     * @MongoDB\Field(type="collection")
     */
    protected ?array $userData = [];

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $check;

    public function __construct(
        string $title,
        string $description,
        array  $img,
        int    $cost,
        string $dateOfPlacement,
        string $category,
        string $subcategory,
        string $city,
        array  $userData,
        string $check
    ) {
        $this->title           = $title;
        $this->description     = $description;
        array_map([$this, 'addImg'], $img);
        $this->cost            = $cost;
        $this->dateOfPlacement = $dateOfPlacement;
        $this->category        = $category;
        $this->city            = $city;
        $this->subcategory     = $subcategory;
        array_map([$this, 'addUserData'], $userData);
        $this->check           = $check;
    }

    public function addImg(string $img): void
    {
        if (!in_array($img, $this->img, true)) {
            $this->img[] = $img;
        }
    }

    public function addUserData(string $userData): void
    {
        if (!in_array($userData, $this->userData, true)) {
            $this->userData[] = $userData;
        }
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }


    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }


    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return array<string>
     */
    public function getImg(): array
    {
        return $this->img;
    }

    /**
     * @param array<string> $img
     */
    public function setImg(array $img): void
    {
        $this->img = $img;
    }


    public function getCost(): int
    {
        return $this->cost;
    }


    public function setCost(int $cost): void
    {
        $this->cost = $cost;
    }


    public function getDateOfPlacement(): ?string
    {
        return $this->dateOfPlacement;
    }


    public function setDateOfPlacement(?string $dateOfPlacement): void
    {
        $this->dateOfPlacement = $dateOfPlacement;
    }


    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    public function getSubCategory(): ?string
    {
        return $this->subcategory;
    }

    public function setSubcategory(?string $subcategory): void
    {
        $this->subcategory = $subcategory;
    }

    /**
     * @return array<string>
     */
    public function getUserData(): array
    {
        return $this->userData;
    }

    /**
     * @param array<string> $userData
     */
    public function setUserData(array $userData): void
    {
        $this->userData = $userData;
    }

    public function getCheck(): ?string
    {
        return $this->check;
    }

    public function setCheck(?string $check): void
    {
        $this->check = $check;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }


    public function setCity(?string $city): void
    {
        $this->city = $city;
    }
}
