<?php

namespace Ecommerce\CreditLimit\Ui\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Sales\Model\Order;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

/**
 * Class Customers
 */
class Customers implements OptionSourceInterface
{
	/**
     * @var array
     */
    protected $options;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        $customers = $this->collectionFactory->create();
        foreach ($customers as $value) {
            $result[] = [
                'value' => $value->getId(),
                'label' => $value->getName() .' ('. $value->getEmail() .')'
            ];
        }
        return $result;
    }
}