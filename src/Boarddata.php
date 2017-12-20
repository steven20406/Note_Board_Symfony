<?php

    use Doctrine\Common\Collections\ArrayCollection;

    /**
     * @Entity
     * @Table(name = "Boarddata")
     */
    class Boarddata
    {
        /**
         * @Id @Column(type = "integer")
         * @GeneratedValue
         */
        private $id;

        /**
         * @Column(type = "string")
         */
        private $userName;

        /**
         * @Column(type = "string")
         */
        private $note;

        /**
         * @OneToMany(targetEntity = "Comment", mappedBy = "commentNoteID")
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
