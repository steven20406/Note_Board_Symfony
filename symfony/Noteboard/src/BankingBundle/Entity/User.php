<?php

namespace BankingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name = "user")
 */
class User implements \JsonSerializable
{
    /**
     * 使用者User ID
     *
     * @ORM\Id()
     * @ORM\Column(type = "bigint")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * 使用者名稱
     *
     * @ORM\Column(type = "string")
     * @Assert\NotBlank()
     * @Assert\Type(type = "string")
     */
    private $username;

    /**
     * 使用者餘額
     *
     * @ORM\Column(type = "bigint")
     * @Assert\NotBlank()
     */
    private $balance;

    /**
     * 使用者交易資料
     *
     * @ORM\OneToMany(targetEntity = "BankingBundle\Entity\Transaction", mappedBy = "userId")
     */
    private $transactions;

    /**
     * @ORM\Version()
     * @ORM\Column(type = "integer")
     */
    private $version;

    /**
     * 儲存使用者資料的陣列
     *
     * User constructor.
     */
    public function __construct() {
        $this->transactions = new ArrayCollection();
    }

    /**
     * 取得使用者ID
     *
     * @return bigint
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 取得使用者名稱
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * 設定使用者名稱
     *
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * 取得使用者餘額
     *
     * @return bigint
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     * 設定使用者餘額
     *
     * @param bigint $balance
     */
    public function setBalance($balance) {
        $this->balance = $balance;
    }

    /**
     * 取得交易資料陣列
     *
     * @return ArrayCollection
     */
    public function getTransactions() {
        return $this->transactions;
    }

    /**
     * @return integer
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @param integer $version
     */
    public function setVersion($version) {
        $this->version = $version;
    }

    /**
     * Json格式輸出權限
     *
     * @return array|mixed
     */
    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'balance' => $this->getBalance()
        ];
    }
}