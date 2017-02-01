<?php
namespace Port1HybridAuth\Service\Validator;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

use Shopware\Bundle\AccountBundle\Constraint\CustomerEmail;
use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;
use Shopware\Components\Api\Exception\ValidationException;
use Shopware\Models\Customer\Customer;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ContextualValidatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Minimal CustomerValidator to prevent constraint violations when using RegisterService
 *
 * Class CustomerValidator
 * @package Port1HybridAuth\Service\Validator
 */
class CustomerValidator extends \Shopware\Bundle\AccountBundle\Service\Validator\CustomerValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ContextServiceInterface
     */
    private $context;

    /**
     * @var \Shopware_Components_Config
     */
    private $config;

    /**
     * @var ContextualValidatorInterface
     */
    private $validationContext;

    /**
     * CustomerValidator constructor.
     *
     * @param ValidatorInterface $validator
     * @param ContextServiceInterface $context
     * @param \Shopware_Components_Config $config
     */
    public function __construct(
        ValidatorInterface $validator,
        ContextServiceInterface $context,
        \Shopware_Components_Config $config
    ) {
        $this->validator = $validator;
        $this->context = $context;
        $this->config = $config;

        parent::__construct($validator, $context, $config);
    }

    /**
     * @param Customer $customer
     *
     * @throws ValidationException
     */
    public function validate(Customer $customer)
    {
        $this->validationContext = $this->validator->startContext();

        $this->validateField('firstname', $customer->getFirstname(), [new NotBlank()]);
        $this->validateField('lastname', $customer->getLastname(), [new NotBlank()]);
        $this->validateField('email', $customer->getEmail(), [
            new CustomerEmail([
                'shop' => $this->context->getShopContext()->getShop(),
                'customerId' => $customer->getId(),
                'accountMode' => $customer->getAccountMode()
            ])
        ]);

        if ($this->validationContext->getViolations()->count()) {
            throw new ValidationException($this->validationContext->getViolations());
        }
    }

    /**
     * @param string $property
     * @param string $value
     * @param Constraint[] $constraints
     */
    private function validateField($property, $value, $constraints)
    {
        $this->validationContext->atPath($property)->validate($value, $constraints);
    }

    /**
     * @return Constraint[]
     */
    private function getSalutationConstraints()
    {
        $salutations = explode(',', $this->config->get('shopsalutations'));
        return [new NotBlank(), new Choice(['choices' => $salutations])];
    }
}
