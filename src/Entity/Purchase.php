<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $zippCode = null;



    #[ORM\Column(length: 255)]
    private ?string $orderNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $deliveryMethod = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(length: 255)]
    private ?string $phone_number = null;

    /**
     * @var Collection<int, PizzaPurchase>
     */
    #[ORM\OneToMany(mappedBy: 'purchase', targetEntity: PizzaPurchase::class, cascade: ['persist', 'remove'])]
    private Collection $pizzaPurchases;

    public function __construct()
    {
        $this->pizzaPurchases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getZippCode(): ?string
    {
        return $this->zippCode;
    }

    public function setZippCode(string $zippCode): static
    {
        $this->zippCode = $zippCode;

        return $this;
    }



    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): static
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getDeliveryMethod(): ?string
    {
        return $this->deliveryMethod;
    }

    public function setDeliveryMethod(string $deliveryMethod): static
    {
        $this->deliveryMethod = $deliveryMethod;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    /**
     * @return Collection<int, PizzaPurchase>
     */
    public function getPizzaPurchases(): Collection
    {
        return $this->pizzaPurchases;
    }

    public function addPizzaPurchase(PizzaPurchase $pizzaPurchase): static
    {
        if (!$this->pizzaPurchases->contains($pizzaPurchase)) {
            $this->pizzaPurchases->add($pizzaPurchase);
            $pizzaPurchase->setPurchase($this);
        }

        return $this;
    }

    public function removePizzaPurchase(PizzaPurchase $pizzaPurchase): static
    {
        if ($this->pizzaPurchases->removeElement($pizzaPurchase)) {
            // set the owning side to null (unless already changed)
            if ($pizzaPurchase->getPurchase() === $this) {
                $pizzaPurchase->setPurchase(null);
            }
        }

        return $this;
    }
}
