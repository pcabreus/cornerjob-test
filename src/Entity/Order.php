<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="app_order")
 * @ApiResource(
        normalizationContext={"groups"={"order:read"}},
        denormalizationContext={"groups"= {"order:write"}},
 *      attributes={
 *          "access_control"="is_granted('ROLE_CUSTOMER')"
 *      },
 *     itemOperations={
 *          "get"={"access_control"="is_granted('ROLE_CUSTOMER') and object.user == user"},
 *          "put"={"access_control"="is_granted('ROLE_ADMIN')"},
 *          "delete"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     collectionOperations={
 *          "get"={"access_control"="is_granted('ROLE_CUSTOMER') and object.user == user"},
 *          "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"offer:read", "offer:write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Groups({"offer:read", "offer:write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Coffee", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coffee;

    /**
     * @Groups({"offer:read"})
     * @ORM\Column(type="integer")
     */
    private $amount = 0;

    /**
     * @Groups({"offer:read", "offer:write"})
     * @ORM\Column(type="integer")
     */
    private $quantity = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCoffee(): ?Coffee
    {
        return $this->coffee;
    }

    public function setCoffee(?Coffee $coffee): self
    {
        $this->coffee = $coffee;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @SerializedName("amount")
     * @Groups({"offer:write"})
     *
     * @return float|null
     */
    public function getTextAmount(): ?float
    {
        return $this->amount / 100;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
