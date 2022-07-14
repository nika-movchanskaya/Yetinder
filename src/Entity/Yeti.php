<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Yeti
{
     /**
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Name must be at least {{ limit }} characters long",
     *      maxMessage = "Name cannot be longer than {{ limit }} characters"
     * )
     */
    protected $name;

    /**
     * @Assert\GreaterThan(
     *      value = 10,
     *      message = "This value should be greater than {{ compared_value }}"
     * )
     */
    protected $height;

    /**
     * @Assert\GreaterThan(
     *      value = 10,
     *      message = "This value should be greater than {{ compared_value }}"
     * )
     */
    protected $weight;
    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Address must be at least {{ limit }} characters long",
     *      maxMessage = "Address cannot be longer than {{ limit }} characters"
     * )
     */
    protected $address;
    protected $rating;
    protected $photo;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }
    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }
    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }
    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }
}
?>