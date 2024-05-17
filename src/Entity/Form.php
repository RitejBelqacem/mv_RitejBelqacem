<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Form
{
    /**
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $adresseSource;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $adresseDestination;

    /**
     * @Assert\NotBlank
     */
    private $message;

    // Getters and Setters

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresseSource(): ?string
    {
        return $this->adresseSource;
    }

    public function setAdresseSource(string $adresseSource): self
    {
        $this->adresseSource = $adresseSource;

        return $this;
    }

    public function getAdresseDestination(): ?string
    {
        return $this->adresseDestination;
    }

    public function setAdresseDestination(string $adresseDestination): self
    {
        $this->adresseDestination = $adresseDestination;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
