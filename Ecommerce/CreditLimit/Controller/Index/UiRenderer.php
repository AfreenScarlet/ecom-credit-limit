<?php

namespace Ecommerce\CreditLimit\Controller\Index;

use Magento\Framework\View\Element\UiComponentInterface;
use Magento\Framework\Controller\ResultFactory;

class UiRenderer extends \Magento\Framework\App\Action\Action
{
    protected $customerSession;

    protected $pageFactory;

    protected $uiComponentfactory;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentfactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Action\Context $context
    ) {
        $this->pageFactory = $pageFactory;
        $this->uiComponentfactory = $uiComponentfactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        if (!$this->customerSession->isLoggedIn()) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('customer/account/login');
            return $resultRedirect;
        }

        $isAjax = $this->getRequest()->isAjax();
        if (!$isAjax) {
            $resultPage = $this->pageFactory->create();
            return $resultPage;
        }
        $component = $this->uiComponentfactory
            ->create($this->_request->getParam('namespace'));
        $this->prepareComponent($component);
        $this->_response->appendBody((string) $component->render());
    }

    protected function prepareComponent(UiComponentInterface $component)
    {
        foreach ($component->getChildComponents() as $child) {
            $this->prepareComponent($child);
        }
        $component->prepare();
    }
}