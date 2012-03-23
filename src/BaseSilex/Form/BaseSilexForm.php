<?php
/*
 * This file is part of the BaseSilex Application
 *
 * (c) Pascal Filipovicz <pascal.filipovicz@frozenk.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace BaseSilex\Form;
use BaseSilex\Entity\BaseSilex;

use Symfony\Component\Validator\Constraints as Assert;

class BaseSilexForm extends BaseSilex
{
    static public function getForm($factory)
    {
        $constraints = new Assert\Collection(array(
            'id'  => new Assert\NotBlank(),
        ));

        $builder = $factory->createBuilder('form', null, array('validation_constraint' => $constraints));

        return $builder
            ->add('id', 'text', array('label' => 'Id'))
            ->getForm()
            ;
    }
}


