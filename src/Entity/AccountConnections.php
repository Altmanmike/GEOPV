<?php

namespace App\Entity;

use App\Repository\AccountConnectionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountConnectionsRepository::class)]
class AccountConnections
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip3 = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_logged = null;

    #[ORM\OneToOne(inversedBy: 'accountConnections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp1(): ?string
    {
        return $this->ip1;
    }

    public function setIp1(?string $ip1): self
    {
        $this->ip1 = $ip1;

        return $this;
    }

    public function getIp2(): ?string
    {
        return $this->ip2;
    }

    public function setIp2(?string $ip2): self
    {
        $this->ip2 = $ip2;

        return $this;
    }

    public function getIp3(): ?string
    {
        return $this->ip3;
    }

    public function setIp3(?string $ip3): self
    {
        $this->ip3 = $ip3;

        return $this;
    }

    public function getNbLogged(): ?int
    {
        return $this->nb_logged;
    }

    public function setNbLogged(?int $nb_logged): self
    {
        $this->nb_logged = $nb_logged;

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

}
