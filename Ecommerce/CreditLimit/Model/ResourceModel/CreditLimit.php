<?php

namespace Ecommerce\CreditLimit\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;


/**
 * Class CreditLimit
 * @package Ecommerce\CreditLimit\Model\ResourceModel
 */
class CreditLimit extends AbstractDb
{
    /**
     *
     */
    const CREDIT_LIMIT_TB = 'afreen_creditlimit';
    /**
     *
     */
    const CREDIT_LIMIT_TB_ENTITY_ID = 'id';

    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(self::CREDIT_LIMIT_TB, self::CREDIT_LIMIT_TB_ENTITY_ID);
    }
}
