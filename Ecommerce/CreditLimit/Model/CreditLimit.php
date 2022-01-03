<?php

namespace Ecommerce\CreditLimit\Model;


use Magento\Framework\Model\AbstractModel;

/**
 * Class CreditLimit
 * @package Ecommerce\CreditLimit\Model
 */
class CreditLimit extends AbstractModel
{

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'afreen_creditlimit';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit');
    }
}
