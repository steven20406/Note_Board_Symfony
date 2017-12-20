<?php

    /**
     * @Entity
     * @Table(name = "Comment")
     */
    class Comment
    {
        /**
         * @Id
         * @Column(type = "bigint")
         * @GeneratedValue
         */
        private $commentID;

        /**
         * @ManyToOne(targetEntity = "Boarddata", inversedBy = "comments")
         * @JoinColumn(name = "commentNoteID", referencedColumnName = "id")
         */
        private $commentNoteID;

        /**
         * @Column(type = "string")
         */
        private $commentUsername;

        /**
         * @Column(type = "string")
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
