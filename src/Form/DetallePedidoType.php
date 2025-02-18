<?php

namespace App\Form;

use App\Entity\DetallePedido;
use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DetallePedidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_producto', EntityType::class, [
                'class' => Producto::class,
                'choice_label' => 'nombre', // Muestra el nombre del producto en lugar del ID
                'label' => 'Producto',
            ])
            ->add('Subtotal');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetallePedido::class,
        ]);
    }
}
