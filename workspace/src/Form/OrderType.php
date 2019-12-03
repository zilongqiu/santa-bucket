<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OrderType.
 */
class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('origin', GeolocationType::class, [
                'property_path' => 'originGeolocation',
                'required' => true,
            ])
            ->add('destination', GeolocationType::class, [
                'property_path' => 'destinationGeolocation',
                'required' => true,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    Order::STATUS_UNASSIGNED_LABEL,
                    Order::STATUS_TAKEN_LABEL,
                ],
                'empty_data' => Order::STATUS_UNASSIGNED_LABEL,
                'required' => false,
            ]);

        $builder->get('status')
            ->addModelTransformer(new CallbackTransformer(
                function ($statusAsId) {
                    if (!$statusAsId) {
                        return;
                    }

                    return Order::getStatuses()[$statusAsId];
                },
                function ($statusAsString) {
                    return array_search($statusAsString, Order::getStatuses(), true);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'csrf_protection' => false,
        ]);
    }
}
