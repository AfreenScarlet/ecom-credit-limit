<?php


namespace Ecommerce\CreditLimit\Ui\DataProvider;


use Magento\Ui\DataProvider\AbstractDataProvider;
use Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit\CollectionFactory;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class FormDataProvider extends AbstractDataProvider
{

    /**
     * @var array
     */
    protected $_loadedData = [];

    protected $storeManager;

    /**
     * @var \Magento\Ui\DataProvider\Modifier\PoolInterface
     */
    private $pool;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        \Magento\Ui\DataProvider\Modifier\PoolInterface $pool,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->pool = $pool;
    }
}
