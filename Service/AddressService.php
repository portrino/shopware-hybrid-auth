<?php
namespace Port1HybridAuth\Service;

use Shopware\Bundle\AccountBundle\Service\Validator\AddressValidatorInterface;
use Shopware\Components\Model\ModelManager;

/**
 * Class AddressService
 *
 * @package Port1HybridAuth\Service
 */
class AddressService extends \Shopware\Bundle\AccountBundle\Service\AddressService
{
    /**
     * @var ModelManager
     */
    private $modelManager;

    /**
     * @var AddressValidatorInterface
     */
    private $validator;

    /**
     * AddressService constructor.
     *
     * @param ModelManager $modelManager
     * @param AddressValidatorInterface $validator
     */
    public function __construct(ModelManager $modelManager, AddressValidatorInterface $validator)
    {
        $this->modelManager = $modelManager;
        $this->validator = $validator;

        parent::__construct($modelManager, $validator);
    }
}
