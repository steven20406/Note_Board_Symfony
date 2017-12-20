<?php

namespace NoteboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="NoteboardBundle\Repository\CommentRepository")
 * @ORM\Table(name = "comment")
 */
class Comment {
    /**
     * @ORM\Id
     * @ORM\Column(type = "bigint")
     * @ORM\GeneratedValue
     */
    private $comment_id;

    /**
     * @ORM\ManyToOne(targetEntity = "Boarddata", inversedBy = "comments")
     * @ORM\JoinColumn(name = "comment_note_id", referencedColumnName = "id")
     */
    private $comment_note_id;

    /**
     * @ORM\Column(type = "string")
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     */
    private $comment_username;

    /**
     * @ORM\Column(type = "string")
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     */
    private $comment_notetext;

    /**
     * @return integer
     */
    public function getCommentId() {
        return $this->comment_id;
    }

    /**
     * @param integer $comment_id
     */
    public function setCommentId($comment_id) {
        $this->comment_id = $comment_id;
    }

    /**
     * @return integer
     */
    public function getCommentNoteId() {
        return $this->comment_note_id;
    }

    /**
     * @param integer $comment_note_id
     */
    public function setCommentNoteId($comment_note_id) {
        $this->comment_note_id = $comment_note_id;
    }

    /**
     * @return string
     */
    public function getCommentUsername() {
        return $this->comment_username;
    }

    /**
     * @param string $comment_username
     */
    public function setCommentUsername($comment_username) {
        $this->comment_username = $comment_username;
    }

    /**
     * @return string
     */
    public function getCommentNotetext() {
        return $this->comment_notetext;
    }

    /**
     * @param string $comment_notetext
     */
    public function setCommentNotetext($comment_notetext) {
        $this->comment_notetext = $comment_notetext;
    }
}
