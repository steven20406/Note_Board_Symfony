<?php

namespace BankingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="BankingBundle\Repository\UserRepository")
 * @ORM\Table(name = "user")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\Column(type = "bigint")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type = "string")
     * @Assert\NotBlank()
     * @Assert\Type(type = "string")
     */
    private $username;

    /**
     * @ORM\Column(type = "bigint")
     * @Assert\NotBlank()
     */
    private $balance;

    /**
     * @ORM\OneToMany(targetEntity = "BankingBundle\Entity\Transaction", mappedBy = "userId")
     */
    private $transactions;

    public function __construct() {
        $this->transactions = new ArrayCollection();
    }

    /**
     * @return bigint
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return bigint
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     * @param bigint  $balance
     */
    public function setBalance($balance) {
        $this->balance = $balance;
    }

    /**
     * @return ArrayCollection
     */
    public function getTransactions() {
        return $this->transactions;
    }
}