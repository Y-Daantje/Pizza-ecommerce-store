<?php

namespace App\Entity;

use App\Repository\PizzaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PizzaRepository::class)]
class Pizza
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $discription = null;

    #[ORM\Column]
    private ?int $catagory_id = null;
    #[ORM\Column]
    private ?int $model_id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $modalInfo1 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $modalInfo2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $modalInfo3 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $modalInfo4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image2 = null;

    /**
     * @var Collection<int, PizzaPurchase>
     */
    #[ORM\OneToMany(mappedBy: 'pizza', targetEntity: PizzaPurchase::class)]
    private Collection $pizzaPurchases;

    public function __construct()
    {
        $this->pizzaPurchases = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }



    public function getDiscription(): ?string
    {
        return $this->discription;
    }

    public function setDiscription(string $discription): static
    {
        $this->discription = $discription;

        return $this;
    }

    public function getCatagoryId(): ?int
    {
        return $this->catagory_id;
    }

    public function setCatagoryId(int $catagory_id): static
    {
        $this->catagory_id = $catagory_id;

        return $this;
    }

    public function getModelId(): ?int
    {
        return $this->model_id;
    }

    public function setModelId(int $model_id): static
    {
        $this->model_id = $model_id;

        return $this;
    }

    public function getModalInfo1(): ?string
    {
        return $this->modalInfo1;
    }


    public function setModalInfo1(string $modalInfo1): static
    {
        $this->modalInfo1 = $modalInfo1;

        return $this;
    }

    public function getModalInfo2(): ?string
    {
        return $this->modalInfo2;
    }

    public function setModalInfo2(string $modalInfo2): static
    {
        $this->modalInfo2 = $modalInfo2;

        return $this;
    }

    public function getModalInfo3(): ?string
    {
        return $this->modalInfo3;
    }

    public function setModalInfo3(string $modalInfo3): static
    {
        $this->modalInfo3 = $modalInfo3;

        return $this;
    }

    public function getModalInfo4(): ?string
    {
        return $this->modalInfo4;
    }

    public function setModalInfo4(string $modalInfo4): static
    {
        $this->modalInfo4 = $modalInfo4;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(string $image2): static
    {
        $this->image2 = $image2;

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
            $pizzaPurchase->setPizza($this);
        }

        return $this;
    }

    public function removePizzaPurchase(PizzaPurchase $pizzaPurchase): static
    {
        if ($this->pizzaPurchases->removeElement($pizzaPurchase)) {
            // set the owning side to null (unless already changed)
            if ($pizzaPurchase->getPizza() === $this) {
                $pizzaPurchase->setPizza(null);
            }
        }

        return $this;
    }



 
}
