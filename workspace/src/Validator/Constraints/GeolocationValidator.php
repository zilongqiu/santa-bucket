<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class GeolocationValidator.
 */
class GeolocationValidator extends ConstraintValidator
{
    /**
     * Function validate.
     *
     * @param mixed
     * @param \Symfony\Component\Validator\Constraint
     * @param mixed $value
     */
    public function validate($value, Constraint $constraint)
    {
        if (!\is_string($value) || !preg_match($constraint->validationRegex, $value)) {
            $this->callViolation($constraint);
        }
    }

    public function callViolation(Constraint $constraint): void
    {
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
