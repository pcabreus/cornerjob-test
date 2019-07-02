<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoffeeRepository")
 * @ORM\Table(name="app_coffee")
 * @ApiResource(
 *      normalizationContext={"groups"={"coffee:read"}, "swagger_definition_name"="Read", "access_control"={""}},
 *      denormalizationContext={"groups"={"coffee:write", "coffee:buy"}, "swagger_definition_name"="Write"},
 *      attributes={
 *          "pagination_items_per_page" = 10,
 *          "access_control"="is_granted('ROLE_CUSTOMER')"
 *      },
 *      itemOperations={
 *          "get",
 *          "put"={"access_control"="is_granted('ROLE_ADMIN')"},
 *          "delete"={"access_control"="is_granted('ROLE_ADMIN')"},
 *          "buy_coffee"={
 *              "method"="POST",
 *              "path"="/coffee/{id}/buy",
 *              "controller"=App\Controller\Action\BuyCoffeeAction::class,
 *              "denormalization_context"={"groups"={"coffee:buy"}},
 *          }
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isPublished"})
 * @ApiFilter(SearchFilter::class, properties={"name": "partial"})
 * @ApiFilter(RangeFilter::class, properties={"price"})
 * @ApiFilter(PropertyFilter::class)
 */
class Coffee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"coffee:read", "coffee:write", "offer:read"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"coffee:read", "coffee:write"})
     * @ORM\Column(type="integer")
     */
    private $intensity;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @Groups({"coffee:read", "coffee:write"})
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @Groups({"coffee:read", "coffee:write"})
     * @ORM\Column(type="boolean")
     */
    private $isPublished = true;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="coffee")
     */
    private $orders;

    /**
     * @Groups("coffee:buy")
     * @Assert\LessThanOrEqual(propertyPath="stock", message="Out of stock. This coffee have only `{{ compared_value }}` units left.")
     * @var int
     */
    private $units = 0;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIntensity(): ?int
    {
        return $this->intensity;
    }

    public function setIntensity(int $intensity): self
    {
        $this->intensity = $intensity;

        return $this;
    }
    
    /**
     * @SerializedName("price")
     * @Groups("coffee:read")
     */
    public function getTextPrice(): ?float
    {
        return $this->price / 100;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @SerializedName("price")
     * @Groups("coffee:write")
     */
    public function setTextPrice($price): self
    {
        $this->price = intval($price * 100);

        return $this;
    } 

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCoffee($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getCoffee() === $this) {
                $order->setCoffee(null);
            }
        }

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnits(): int
    {
        return $this->units;
    }

    public function getUnitsAndClean(): int
    {
        $units = $this->units;

        $this->units = 0;
        return $units;
    }

    /**
     * @param int $units
     */
    public function setUnits(int $units = 0): void
    {
        $this->units = $units;
    }

}
