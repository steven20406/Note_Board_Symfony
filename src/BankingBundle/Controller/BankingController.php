<?php

namespace BankingBundle\Controller;

use BankingBundle\Entity\Transaction;
use BankingBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BankingController extends Controller {
    /**
     * Index page
     *
     * @Route("/",
     *     name = "banking_homepage")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request) {
        $user = new User();
        $form = $this->createForm('BankingBundle\Form\UserType', $user);

        /**
         * @var $em EntityManager
         */
        $em = $this->getDoctrine()->getManager('banking');

        $userData = $em->getRepository('BankingBundle:User')->findAll();

        if ($request->getMethod() == 'POST') {
            if ($request->request->has('user')) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $em->beginTransaction();
                    try {
                        $em->persist($user);
                        $em->flush();
                        $em->commit();
                        //throw new Exception('add');
                    } catch (\Exception $e) {
                        $em->rollback();
                    }

                    return $this->redirect($request->getUri());
                }
            }
        }

        return $this->render('@Banking/Page/index.html.twig', [
            'form' => $form->createView(),
            'user' => $userData,
            'test' => $request->getUri()
        ]);
    }

    /**
     * Save page
     *
     * @Route("/save/{page}",
     *     name = "banking_save",
     *     requirements = {"page" = "\d+"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function saveAction(Request $request, $page) {
        /**
         * @var  $em EntityManager
         */
        $em = $this->getDoctrine()->getManager('banking');

        $user = $em->getRepository('BankingBundle:User')->find($page);

        $transactions = $em->getRepository('BankingBundle:Transaction')->getTransaction($page);

        $transaction = new Transaction();
        $form = $this->createForm('BankingBundle\Form\TransactionType', $transaction);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $amount = abs($form->get('amount')->getData());
                $translator = $this->get('translator');

                if ($amount == 0) {
                    $exception = new Exception($translator->trans('No money transaction'));
                    throw $exception;
                }

                if ($request->request->has('save')) {
                    $transaction->setAmount($amount);
                } elseif ($request->request->has('withdraw')) {
                    if ($amount > $user->getBalance()) {
                        $exception = new Exception($translator->trans('Not enough money'));
                        throw $exception;
                    }

                    $amount = (-1) * $amount;
                    $transaction->setAmount($amount);
                }

                $executeTransaction = $em->getRepository('BankingBundle:User');
                $executeTransaction->transactionEvent($page, $amount);

                $transaction->setAt(new \DateTime());
                $transaction->setUserId($user);
                $transaction->setBalance($user->getBalance() + $amount);

                $em->beginTransaction();
                try {
                    $em->persist($transaction);
                    $em->flush();
                    $em->commit();
                    //throw new Exception('aaa');
                } catch (\Exception $e) {
                    $em->rollback();
                    throw $e;
                }

                $newTrans = $em->getRepository('BankingBundle:Transaction')->getTransaction($page);
                $respArray = [
                    'user' => $user,
                    'datas' => $newTrans,
                ];
                $jsonresp = new JsonResponse();
                $jsonresp->headers->set('content-Type', 'application/json');
                $jsonresp->headers->set('Access-Control-Allow-Origin', '*');
                $jsonresp->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                $jsonresp->setData($respArray);
                $jsonresp->prepare($request);
                return $jsonresp;

                //return $this->redirect($request->getUri());
            }
        }


        return $this->render('@Banking/Page/save.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
                'datas' => $transactions
        ]);
    }
}