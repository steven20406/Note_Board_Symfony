<?php

    namespace NoteboardBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;

    /**
     * @ORM\Entity(repositoryClass="NoteboardBundle\Repository\CommentRepository")
     * @ORM\Table(name = "comment")
     */
    class Comment
    {
        /**
         * @ORM\Id
         * @ORM\Column(type = "bigint")
         * @ORM\GeneratedValue
         */
        private $commentID;

        /**
         * @ORM\ManyToOne(targetEntity = "Boarddata", inversedBy = "comments")
         * @ORM\JoinColumn(name = "commentNoteID", referencedColumnName = "id")
         */
        private $commentNoteID;

        /**
         * @ORM\Column(type = "string")
         * @Assert\NotBlank()
         * @Assert\Type(
         *     type="string"
         * )
         */
        private $commentUsername;

        /**
         * @ORM\Column(type = "string")
         * @Assert\NotBlank()
         * @Assert\Type(
         *     type="string"
         * )
         */
        private $commentNotetext;

        /**
         * @return integer
         */
        public function getCommentID() {
            return $this->commentID;
        }

        /**
         * @param integer $commentID
         */
        public function setCommentID($commentID) {
            $this->commentID = $commentID;
        }

        /**
         * @return integer
         */
        public function getCommentNoteID() {
            return $this->commentNoteID;
        }

        /**
         * @param integer $commentNoteID
         */
        public function setCommentNoteID($commentNoteID) {
            $this->commentNoteID = $commentNoteID;
        }

        /**
         * @return string
         */
        public function getCommentUsername() {
            return $this->commentUsername;
        }

        /**
         * @param string $commentUsername
         */
        public function setCommentUsername($commentUsername) {
            $this->commentUsername = $commentUsername;
        }

        /**
         * @return string
         */
        public function getCommentNotetext() {
            return $this->commentNotetext;
        }

        /**
         * @param string $commentNotetext
         */
        public function setCommentNotetext($commentNotetext) {
            $this->commentNotetext = $commentNotetext;
        }
    }
