<?php

namespace BankingBundle\Controller;

use BankingBundle\Entity\Transaction;
use BankingBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BankingController extends Controller
{
    /**
     * Index page
     * Test
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('BankingBundle\Form\UserType', $user);

        $em = $this->getDoctrine()->getManager('banking');
        $userData = $em->getRepository('BankingBundle:User')->findAll();

        if ($request->getMethod() == 'POST') {
            if ($request->request->has('user')) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $em->persist($user);
                    $em->flush();

                    return $this->redirect($request->getUri());
                }
            }
        }

        return $this->render('@Banking/Page/index.html.twig', [
            'form' => $form->createView(),
            'user' => $userData
        ]);
    }

    /**
     * Save page
     *
     * @param Request $request
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager('banking');

        $user = $em->getRepository('BankingBundle:User')->find($page);

        $transactions = $em->getRepository('BankingBundle:Transaction')->getTransaction($page);

        $transaction = new Transaction();
        $form = $this->createForm('BankingBundle\Form\TransactionType', $transaction);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $amount = abs($form->get('amount')->getData());

                if ($request->request->has('save')) {
                    $transaction->setAmount($amount);
                } elseif ($request->request->has('withdraw')) {
                    $amount = (-1) * $amount;
                    $transaction->setAmount($amount);
                }

                $executeTransaction = $em->getRepository('BankingBundle:User');
                $executeTransaction->transactionEvent($page, $amount);

                $transaction->setAt(new \DateTime());
                $transaction->setUserId($user);
                $transaction->setBalance($user->getBalance() + $amount);
                $em->persist($transaction);
                $em->flush();

                return $this->redirect($request->getUri());
            }
        }

        return $this->render('@Banking/Page/save.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'datas' => $transactions
        ]);
    }
}
