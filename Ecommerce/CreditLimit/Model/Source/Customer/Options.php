<?php


namespace Ecommerce\CreditLimit\Model\Source\Customer;


class Options implements \Magento\Framework\Data\OptionSourceInterface
{

    /**
     * @var array
     */
    protected $options;

    protected $collectionFactory;

    public function __construct(
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        if (null == $this->options) {
            $collection = $this->collectionFactory->create();
            foreach ($collection as $item) {
                $this->options[] = [
                    'value' => $item->getId(),
                    'label' => $item->getName() . '('. $item->getEmail() .')'
                ];
            }
        }

        return $this->options;
    }
}
