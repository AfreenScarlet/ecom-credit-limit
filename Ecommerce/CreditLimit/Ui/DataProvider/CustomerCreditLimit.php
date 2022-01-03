<?php

namespace Ecommerce\CreditLimit\Ui\DataProvider;

use Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit\CollectionFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\App\RequestInterface;

class CustomerCreditLimit extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
// \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;


    protected $addFieldStrategies;

    protected $addFilterStrategies;

    protected $customerSession;
    

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
    }

    protected function prepareUpdateUrl()
    {
       $this->data['config']['filter_url_params']['customer_id'] = $this->customerSession->getCustomer()->getId();
       parent::prepareUpdateUrl();
    }

    public function getData()
    {
        $itemsRec = parent::getData();

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
            'totalRecords' => $itemsRec['totalRecords'],
            'items'        => $itemsRec['items'],
        ];
    }
}
