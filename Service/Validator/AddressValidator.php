<?php
namespace Port1HybridAuth\Service\Validator;

use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;
use Shopware\Components\Api\Exception\ValidationException;
use Shopware\Models\Customer\Address;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ContextualValidatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Minimal AddressValidator to prevent constraint violations when using RegisterService
 *
 * Class AddressValidator
 * @package Port1HybridAuth\Service\Validator
 */
class AddressValidator extends \Shopware\Bundle\AccountBundle\Service\Validator\AddressValidator
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
     * AddressValidator constructor.
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
     * @param Address $address
     *
     * @throws ValidationException
     */
    public function validate(Address $address)
    {
        $this->validationContext = $this->validator->startContext();

        $this->validateField('firstname', $address->getFirstname(), [new NotBlank()]);
        $this->validateField('lastname', $address->getLastname(), [new NotBlank()]);

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
}
