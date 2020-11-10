<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetRepository")
 */
class Budget
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $candidateName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $candidateEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $candidatePhone;


    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $deliveryDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $finalPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Project", mappedBy="budget", cascade={"persist", "remove"})
     */
    //Proyecto asociaso al aceptar una solicitud de presupuesto
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="budget")
     */
    //Solicitante del presupuesto
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\App", inversedBy="budgets")
     */
    private $apps;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Feature", inversedBy="budgets")
     */
    private $features;

    public function __construct()
    {
        $this->apps = new ArrayCollection();
        $this->features = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCandidateName(): ?string
    {
        return $this->candidateName;
    }

    public function setCandidateName(string $candidateName): self
    {
        $this->candidateName = $candidateName;

        return $this;
    }

    public function getCandidateEmail(): ?string
    {
        return $this->candidateEmail;
    }

    public function setCandidateEmail(string $candidateEmail): self
    {
        $this->candidateEmail = $candidateEmail;

        return $this;
    }

    public function getCandidatePhone(): ?string
    {
        return $this->candidatePhone;
    }

    public function setCandidatePhone(string $candidatePhone): self
    {
        $this->candidatePhone = $candidatePhone;
        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(?\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getFinalPrice(): ?float
    {
        return $this->finalPrice;
    }

    public function setFinalPrice(?float $finalPrice): self
    {
        $this->finalPrice = $finalPrice;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        // set (or unset) the owning side of the relation if necessary
        $newBudget = null === $project ? null : $this;
        if ($project->getBudget() !== $newBudget) {
            $project->setBudget($newBudget);
        }

        return $this;
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

    /**
     * @return Collection|App[]
     */
    public function getApps(): Collection
    {
        return $this->apps;
    }

    public function addApp(App $app): self
    {
        if (!$this->apps->contains($app)) {
            $this->apps[] = $app;
        }

        return $this;
    }

    public function removeApp(App $app): self
    {
        if ($this->apps->contains($app)) {
            $this->apps->removeElement($app);
        }

        return $this;
    }

    /**
     * @return Collection|Feature[]
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(Feature $feature): self
    {
        if (!$this->features->contains($feature)) {
            $this->features[] = $feature;
        }

        return $this;
    }

    public function removeFeature(Feature $feature): self
    {
        if ($this->features->contains($feature)) {
            $this->features->removeElement($feature);
        }

        return $this;
    }


}
