<?php

namespace App\Form;

use App\Entity\Pedido;
use App\Entity\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PedidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Fecha', DateType::class, [
                'widget' => 'single_text', // Formato de fecha
            ])
            ->add('Estado')
            ->add('id_Cliente', EntityType::class, [
                'class' => Cliente::class,  // Le indicamos que el campo es de tipo Cliente
                'choice_label' => 'nombre', // Cambiamos 'id' por 'nombre' para que se muestre el nombre del cliente
                'multiple' => false,         // Solo se puede seleccionar un cliente
                'expanded' => false,         // Usamos un combo box (desplegable)
                'choices' => $options['clientes'],  // Pasamos los clientes que recibimos del controlador
                'label' => 'Cliente'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pedido::class,  // Asociamos el formulario a la entidad Pedido
            'clientes' => [],  // Definimos la opción 'clientes', que contendrá la lista de clientes
        ]);
    }
}
