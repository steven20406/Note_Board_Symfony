<?php

namespace BankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass = "BankingBundle\Repository\TransactionRepository")
 * @ORM\Table(name = "transaction")
 */
class Transaction implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type = "bigint")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity = "BankingBundle\Entity\User", inversedBy = "transactions")
     * @ORM\JoinColumn(name = "userId", referencedColumnName = "id")
     */
    private $userId;

    /**
     * @ORM\Column(type = "bigint")
     * @Assert\NotBlank()
     */
    private $amount;

    /**
     * @ORM\Column(type = "datetime")
     */
    private $at;

    /**
     * @ORM\Column(type = "bigint")
     */
    private $balance;

    /**
     * @return bigint
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return bigint
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param bigint $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * @return bigint
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @param bigint $amount
     */
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    /**
     * @return Assert\DateTime
     */
    public function getAt() {
        return $this->at;
    }

    /**
     * @param Assert\DateTime $at
     */
    public function setAt($at) {
        $this->at = $at;
    }

    /**
     * @return bigint
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     * @param bigint $balance
     */
    public function setBalance($balance) {
        $this->balance = $balance;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'userid' => $this->userId,
            'amount' => $this->amount,
            'at' => $this->at
        ];
    }
}