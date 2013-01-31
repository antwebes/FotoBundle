<?php

namespace ant\FotoBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;

class FormFactory //implements FactoryInterface
{
    private $formFactory;
    private $name;
    private $type;
    private $validationGroups;

    public function __construct(FormFactoryInterface $formFactory, $type, $name)
    {
        $this->formFactory = $formFactory;        
        $this->type = $type;
        $this->name = $name;
    }

    public function createForm()
    {
        return $this->formFactory->createNamed($this->name, $this->type, null);
    }
}
