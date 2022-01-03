<?php

namespace Ecommerce\CreditLimit\Model\Source;

class CreditType implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var null|array
     */
    protected $options;


    /**
     * @return array|null
     */
    public function toOptionArray()
    {
        $options = [];
        $options[] = ['value' => 'credit', 'label' => __('Credit')];
        $options[] = ['value' => 'debit', 'label' => __('Debit')];
        return $options;
    }
}
