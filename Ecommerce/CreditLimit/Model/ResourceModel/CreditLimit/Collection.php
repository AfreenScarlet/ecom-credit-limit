<?php

namespace Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


/**
 * Class Collection
 * @package Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit
 */
class Collection extends  AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init('Ecommerce\CreditLimit\Model\CreditLimit',
            'Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit');
    }

    /**
     * @param $customerId
     * @return $this
     */
    public function getAllRecordsByCustomerId($customerId)
    {
        $customerIds = is_array($customerId) ? $customerId : [$customerId];

        $this->addFieldToFilter('customer_id', ['in' => $customerIds]);

        return $this;
    }

}
