<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ApplicationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @param string $label
     * @param string $placeholder
     * @param string $options
     * @return array
     */
    protected function getConfiguration($label , string $placeholder, $options = []){
        return array_merge([
            'label' => $label,
            'attr' => [ 'placholder' => $placeholder]
        ], $options);
    }
}
