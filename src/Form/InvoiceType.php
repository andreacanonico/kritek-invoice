<?php

    namespace App\Form;

    use App\Controller\CustomerController;
    use App\Entity\Customer;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\DateType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\IntegerType;
    use Symfony\Component\Form\Extension\Core\Type\NumberType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class InvoiceType extends AbstractType
    {
        public function configureOptions (OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'customer' => [],
            ]);

            $resolver->setAllowedTypes('customer', 'array');
        }

        public function buildForm (FormBuilderInterface $builder, array $options): void
        {
            $builder->add('customer', EntityType::class, [
                'required'     => true,
                'choices'      => $options['customer'],
                'class'        => Customer::class,
                'choice_label' => function ($customer) {
                    return $customer->getCompleteName();
                },
                'row_attr'     => [
                    'class' => 'form-group',
                ],
                'attr'         => [
                    'class' => 'form-control',
                ],
            ])->add('date', DateType::class, [
                'required' => true,
                'widget'   => 'single_text',
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'attr'     => [
                    'class' => 'form-control',
                ],
            ])->add('description', TextareaType::class, [
                'required' => true,
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'attr'     => [
                    'class' => 'form-control',
                    'row'   => 3,
                ],
            ])->add('quantity', IntegerType::class, [
                'required' => true,
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'attr'     => [
                    'class' => 'form-control',
                ],
            ])->add('amount', NumberType::class, [
                'required' => true,
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'attr'     => [
                    'class' => 'form-control',
                ],
            ])->add('vat', NumberType::class, [
                'required'   => true,
                'row_attr'   => [
                    'class' => 'form-group',
                ],
                'attr'       => [
                    'class' => 'form-control',
                ],
                'label'      => 'VAT %',
            ])->add('save', SubmitType::class, [
                'row_attr' => [
                    'class' => 'form-group text-center',
                ],
                'attr'     => [
                    'class' => 'btn btn-success submit mt-3',
                ],
            ]);
        }
    }