<?php

namespace BankingBundle\Controller;

use BankingBundle\Entity\Transaction;
use BankingBundle\Entity\User;
use Doctrine\DBAL\LockMode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BankingController extends Controller
{
    /**
     * Index page
     *
     * @Route("/",
     *     name = "banking_homepage")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function indexAction(Request $request) {
        $user = new User();
        $form = $this->createForm('BankingBundle\Form\UserType', $user);

        $em = $this->getDoctrine()->getManager('banking');

        $userData = $em->getRepository('BankingBundle:User')->findAll();

        if ($request->getMethod() == 'POST') {
            if ($request->request->has('user')) {
                $form->handleRequest($request);

                $em->beginTransaction();
                try {
                    $em->persist($user);
                    $em->flush();
                    $em->commit();
                } catch (\Exception $e) {
                    $em->rollback();
                    throw $e;
                }

                return $this->redirect($request->getUri());
            }
        }

        $dataTransfer = [
            'form' => $form->createView(),
            'user' => $userData
        ];

        return $this->render('@Banking/Page/index.html.twig', $dataTransfer);
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
        $em = $this->getDoctrine()->getManager('banking');

        $v = $request->request->get('user_version');
        $user = $em->find('BankingBundle:User', $page, LockMode::OPTIMISTIC, $v);

        $transactions = $em->getRepository('BankingBundle:Transaction')->getTransaction($page);

        $transaction = new Transaction();
        $form = $this->createForm('BankingBundle\Form\TransactionType', $transaction);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $amount = $form->get('amount')->getData();
                if(is_numeric($amount)) {
                    $amount = abs($amount);
                }
                $translator = $this->get('translator');

                if ($amount == 0 && is_numeric($amount)) {
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

                $transaction->setAt(new \DateTime());
                $transaction->setUserId($user);
                $transaction->setBalance($user->getBalance() + $amount);
                $user->setBalance($user->getBalance() + $amount);

                $em->beginTransaction();
                $em->getConnection()->setAutoCommit(false);
                try {
                    $em->persist($transaction);
                    $em->flush();
                    $em->commit();
                } catch (\Exception $e) {
                    $em->rollback();
                    throw $e;
                }

                $newTrans = $em->getRepository('BankingBundle:Transaction')->getTransaction($page);
                $respArray = [
                    'user' => $user,
                    'datas' => $newTrans,
                    'post' => $_POST
                ];
                $jsonResp = new JsonResponse();
                $jsonResp->setEncodingOptions(JSON_PRETTY_PRINT);
                $jsonResp->setData($respArray);

                return $jsonResp;
            }
        }

        $transferData = [
            'user' => $user,
            'form' => $form->createView(),
            'datas' => $transactions
        ];

        return $this->render('@Banking/Page/save.html.twig', $transferData);
    }
}