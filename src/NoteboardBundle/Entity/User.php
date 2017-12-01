<?php

namespace NoteboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class User
 *
 * @ORM\Table(name = "app_user")
 * @ORM\Entity(repositoryClass="NoteboardBundle\Repository\UserRepository")
 * @package NoteboardBundle\Entity
 */
class User implements AdvancedUserInterface, \Serializable {
    /**
     * @ORM\Id()
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type = "string", length = 25, unique = true)
     */
    private $username;

    /**
     * @ORM\Column(type = "string", length = 64)
     */
    private $password;

    /**
     * @ORM\Column(type = "string", length = 60, unique = true)
     */
    private $email;

    /**
     * @ORM\Column(name = "is_avtive", type = "boolean")
     */
    private $isAvtive;

    public function __construct() {
        $this->isAvtive = true;
    }

    /**
     * @see  \Serializable::serialize()
     */
    public function serialize() {
        return serialize([
                $this->id,
                $this->username,
                $this->password,
                $this->isAvtive
        ]);
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized) {
        list(
                $this->id,
                $this->username,
                $this->password,
                $this->isAvtive
                ) = unserialize($serialized);
    }

    /**
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles() {
        return array('ROLE_USER');
    }

    /**
     * @return string The password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return string|null The salt
     */
    public function getSalt() {
        return null;
    }

    /**
     * @return string The username
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired() {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked() {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired() {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled() {
        return $this->isAvtive;
    }
}