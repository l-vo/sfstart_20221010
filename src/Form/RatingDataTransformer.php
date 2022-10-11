<?php

namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;

final class RatingDataTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
       if ($value === null) {
           return null;
       }

        return $value / 10;
    }

    public function reverseTransform($value)
    {
        if ($value === null) {
            return null;
        }

        return $value * 10;
    }
}