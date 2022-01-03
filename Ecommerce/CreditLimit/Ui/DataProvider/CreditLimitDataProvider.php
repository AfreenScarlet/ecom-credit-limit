<?php

namespace Ecommerce\CreditLimit\Ui\DataProvider;

use Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit\CollectionFactory;

class CreditLimitDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;


    protected $addFieldStrategies;

    protected $addFilterStrategies;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $addFieldStrategies
     * @param array $addFilterStrategies
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
    }

    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $itemsRec = $this->getCollection()->toArray();

        foreach($itemsRec['items'] as &$item) {
            $item['credit_amt'] = $item['debit_amt'] = 0;
            if (isset($item['credit_type']) && isset($item['amount'])) {
                if ($item['credit_type'] == 'credit') {
                    $item['credit_amt'] = $item['amount'];
                }
                if ($item['credit_type'] == 'debit') {
                    $item['debit_amt'] = $item['amount'];
                }
            }
        }
        return [
            'totalRecords' => $this->getCollection()->getSize(),
            'items'        => $itemsRec['items'],
        ];
    }
}
