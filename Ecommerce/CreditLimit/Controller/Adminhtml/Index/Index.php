<?php

namespace Ecommerce\CreditLimit\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;

class Index extends \Magento\Backend\App\Action
{

    /**
     * @var Magento\Framework\View\Result\PageFactory
     */

    protected $resultPageFactory; 
    
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Context $context
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ecommerce_CreditLimit::creditlimit_menus');
        $resultPage->getConfig()->getTitle()->prepend(__('Credit Limit List'));
        return $resultPage;
    }
}
