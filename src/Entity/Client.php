<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idclient;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="string",
     *     message="merci de saisir seulement des lettres."
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="string",
     *     message="merci de saisir seulement des lettres."
     * )
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="client")
     */
    private $addresses;

    /**
     * @ORM\OneToOne(targetEntity=Numero::class, mappedBy="client", cascade={"persist", "remove"})
     */
    private $numero;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="client")
     */
    private $commandes;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getIdclient(): ?int
    {
        return $this->idclient;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setClient($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getClient() === $this) {
                $address->setClient(null);
            }
        }

        return $this;
    }

    public function getNumero(): ?Numero
    {
        return $this->numero;
    }

    public function setNumero(?Numero $numero): self
    {
        // unset the owning side of the relation if necessary
        if ($numero === null && $this->numero !== null) {
            $this->numero->setClient(null);
        }

        // set the owning side of the relation if necessary
        if ($numero !== null && $numero->getClient() !== $this) {
            $numero->setClient($this);
        }

        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

}
