<?php

    namespace NoteboardBundle\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;


    /**
     * @ORM\Entity(repositoryClass="NoteboardBundle\Repository\BoarddataRepository")
     * @ORM\Table(name = "boarddata")
     */
    class Boarddata
    {
        /**
         * @ORM\Id
         * @ORM\Column(type = "integer")
         * @ORM\GeneratedValue
         */
        private $id;

        /**
         * @ORM\Column(type = "string")
         * @Assert\NotBlank()
         * @Assert\Type(
         *     type="string"
         * )
         */
        private $userName;

        /**
         * @ORM\Column(type = "string")
         * @Assert\NotBlank()
         * @Assert\Type(
         *     type="string"
         * )
         */
        private $note;

        /**
         * @ORM\OneToMany(targetEntity = "Comment", mappedBy = "commentNoteID")
         */
        private $comments;

        public function __construct() {
            $this->comments = new ArrayCollection();
        }

        /**
         * @return ArrayCollection
         */
        public function getComments() {
            return $this->comments;
        }

        /**
         * @return integer
         */
        public function getId() {
            return $this->id;
        }

        /**
         * @return string
         */
        public function getUsername() {
            return $this->userName;
        }

        /**
         * @param string $userName
         */
        public function setUsername($userName) {
            $this->userName = $userName;
        }

        /**
         * @return string
         */
        public function getNote() {
            return $this->note;
        }

        /**
         * @param string $note
         */
        public function setNote($note) {
            $this->note = $note;
        }
    }
