<?php

namespace BankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass = "BankingBundle\Repository\TransactionRepository")
 * @ORM\Table(name = "transaction_list")
 */
class Transaction implements \JsonSerializable
{
    /**
     * Transaction ID
     *
     * @ORM\Id()
     * @ORM\Column(type = "bigint")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * Transaction 對應的 User ID
     *
     * @ORM\ManyToOne(targetEntity = "BankingBundle\Entity\User", inversedBy = "transactions")
     * @ORM\JoinColumn(name = "userId", referencedColumnName = "id")
     */
    private $userId;

    /**
     * 存款/提款 的金額
     *
     * @ORM\Column(type = "bigint")
     * @Assert\NotBlank()
     */
    private $amount;

    /**
     * 存款/提款 的時間
     *
     * @ORM\Column(type = "datetime")
     */
    private $at;

    /**
     * 完成 存款/提款 後的餘額
     *
     * @ORM\Column(type = "bigint")
     */
    private $balance;

    /**
     * 取得ID
     *
     * @return bigint
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 取得User ID
     *
     * @return bigint
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * 設定 User ID
     *
     * @param bigint $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * 取得存款/提款金額
     *
     * @return bigint
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     *設定 存款/提款 金額
     *
     * @param bigint $amount
     */
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    /**
     * 取得 存款/提款 時間
     *
     * @return Assert\DateTime
     */
    public function getAt() {
        return $this->at;
    }

    /**
     * 設定 存款/提款 時間
     *
     * @param Assert\DateTime $at
     */
    public function setAt($at) {
        $this->at = $at;
    }

    /**
     * 取得 存款/提款 後餘額
     *
     * @return bigint
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     * 設定 存款/提款 後餘額
     *
     * @param bigint $balance
     */
    public function setBalance($balance) {
        $this->balance = $balance;
    }

    /**
     * Json格式輸出權限
     *
     * @return array|mixed
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