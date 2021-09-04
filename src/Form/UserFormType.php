<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password', RepeatedType::class,
            [
                'type' => PasswordType::class,
                'invalid_message' => 'Ambas contraseñas deben ser iguales.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Contraseña'],
                'second_options' => ['label' => 'Repite la contraseña'],
            ]
            )
            ->add('name')
            ->add('surname')
            ->add('province', ChoiceType::class, [
                'placeholder' => 'Tu provincia',
                'choices'  => [
                    'A Coruña' => 'A Coruña',
                    'Álava' => 'Álava',
                    'Albacete' => 'Albacete',
                    'Alicante' => 'Alicante',
                    'Almería' => 'Almería',
                    'Asturias' => 'Asturias',
                    'Ávila' => 'Ávila',
                    'Badajoz' => 'Badajoz',
                    'Baleares' => 'Baleares',
                    'Barcelona' => 'Barcelona',
                    'Burgos' => 'Burgos',
                    'Cáceres' => 'Cáceres',
                    'Cádiz' => 'Cádiz',
                    'Cantabria' => 'Cantabria',
                    'Castellón' => 'Castellón',
                    'Ceuta' => 'Ceuta',
                    'Ciudad Real' => 'Ciudad Real',
                    'Córdoba' => 'Córdoba',
                    'Cuenca' => 'Cuenca',
                    'Girona' => 'Girona',
                    'Granada' => 'Granada',
                    'Guadalajara' => 'Guadalajara',
                    'Guipúzcoa' => 'Guipúzcoa',
                    'Huelva' => 'Huelva',
                    'Huesca' => 'Huesca',
                    'Jaén' => 'Jaén',
                    'La Rioja' => 'La Rioja',
                    'Las Palmas' => 'Las Palmas',
                    'León' => 'León',
                    'Lleida' => 'Lleida',
                    'Lugo' => 'Lugo',
                    'Madrid' => 'Madrid',
                    'Málaga' => 'Málaga',
                    'Melilla' => 'Melilla',
                    'Murcia' => 'Murcia',
                    'Navarra' => 'Navarra',
                    'Ourense' => 'Ourense',
                    'Palencia' => 'Palencia',
                    'Pontevedra' => 'Pontevedra',
                    'Salamanca' => 'Salamanca',
                    'Segovia' => 'Segovia',
                    'Sevilla' => 'Sevilla',
                    'Soria' => 'Soria',
                    'Tarragona' => 'Tarragona',
                    'Tenerife' => 'Tenerife',
                    'Teruel' => 'Teruel',
                    'Toledo' => 'Toledo',
                    'Valencia' => 'Valencia',
                    'Valladolid' => 'Valladolid',
                    'Vizcaya' => 'Vizcaya',
                    'Zamora' => 'Zamora',
                    'Zaragoza' => 'Zaragoza'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
