<?php

    namespace App\Controller;

    use App\Entity\Customer;
    use App\Entity\Invoice;
    use App\Entity\InvoiceBody;
    use App\Form\InvoiceType;
    use Doctrine\Persistence\ManagerRegistry;
    use Doctrine\Persistence\ObjectManager;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Form\Form;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Validator\Validator\ValidatorInterface;

    class InvoiceController extends AbstractController
    {
        protected $form;

        public function index (Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator): Response
        {
            $options = [
                'customer' => $doctrine->getRepository(Customer::class)->findAll(),
            ];

            $invoiceForm = $this->createForm(InvoiceType::class, null, $options);

            $invoiceForm->handleRequest($request);

            if ($invoiceForm->isSubmitted()) {
                $data = $invoiceForm->getData();

                if ($invoiceForm->isValid())
                {
                    $entityManager = $doctrine->getManager();

                    $invoice= new Invoice();
                    $invoice->setCustomer($data['customer']);
                    $invoice->setDate($data['date']);
                    $invoice->setNumber($this->getNextNumber($entityManager));
                    $entityManager->persist($invoice);
                    $entityManager->flush($invoice);

                    $invoiceBody= new InvoiceBody();
                    $invoiceBody->setInvoiceId($invoice);
                    $invoiceBody->setDescription($data['description']);
                    $invoiceBody->setQuantity($data['quantity']);
                    $invoiceBody->setAmount($data['amount']);
                    $invoiceBody->setVat($data['vat']);
                    $invoiceBody->setTotal();
                    $entityManager->persist($invoiceBody);
                    $entityManager->flush($invoiceBody);

                    return $this->redirectToRoute('invoice');
                }
                else {
                    $errors = $validator->validate($data);

                    if (count($errors) > 0) {
                        $errorsString = (string)$errors;

                        return new Response($errorsString);
                    }
                }
            }

            return $this->renderForm('base.html.twig', [
                'form' => $invoiceForm,
            ]);
        }

        /**
         * @return int
         */
        private function getNextNumber(ObjectManager $entityManager) {
            $query= $entityManager->createQueryBuilder();
            $query->select('MAX(i.number)')->from(Invoice::class, 'i')->where('YEAR(i.date) =\''. date('Y').'\'');
            $number = $query->getQuery()->getSingleScalarResult() ?? 0;

            return ++$number;
        }
    }