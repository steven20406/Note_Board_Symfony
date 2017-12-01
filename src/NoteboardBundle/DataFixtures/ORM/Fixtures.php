<?php

namespace NoteboardBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use NoteboardBundle\Entity\Boarddata;
use NoteboardBundle\Entity\Comment;
use NoteboardBundle\Entity\User;

class Fixtures extends Fixture {
    /**
     * Ficture User data and Boarddata
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        for ($i = 0; $i < 10; $i++) {

            $user = new User();
            $user->setUsername('User' . $i);
            $user->setEmail('User' . $i);

            $plainPassword = '04060406';
            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($password);

            $manager->persist($user);
        }

        for ($i = 0; $i < 10; $i++) {

            $boarddata = new Boarddata();
            $boarddata->setUsername('User ' . $i);
            $boarddata->setNote('User note ' . $i);

            for ($j = 0; $j < 10; $j++) {
                $comment = new Comment();
                $comment->setCommentNoteId($boarddata);
                $comment->setCommentUsername('User comment ' . $j);
                $comment->setCommentNotetext('User comment text ' . $j);

                $manager->persist($comment);
            }

            $manager->persist($boarddata);
        }

        $manager->flush();
    }
}