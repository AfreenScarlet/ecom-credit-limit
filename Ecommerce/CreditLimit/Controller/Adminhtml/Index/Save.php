<?php

namespace Ecommerce\CreditLimit\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use InvalidArgumentException;


class Save extends \Magento\Backend\App\Action
{

    /**
     * @var \Ecommerce\CreditLimit\Model\CreditLimitFactory
     */
    private $creditLimitFactory;
    /**
     * @var \Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit
     */
    private $creditLimitResourceModel;
    /**
     * @var \Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit\CollectionFactory
     */
    private $creditLimitCollectionFactory;

    public function __construct(
        \Ecommerce\CreditLimit\Model\CreditLimitFactory $creditLimitFactory,
        \Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit\CollectionFactory $creditLimitCollectionFactory,
        \Ecommerce\CreditLimit\Model\ResourceModel\CreditLimit $creditLimitResourceModel,
        Action\Context $context
    ) {
        parent::__construct($context);
        $this->creditLimitFactory = $creditLimitFactory;
        $this->creditLimitResourceModel = $creditLimitResourceModel;
        $this->creditLimitCollectionFactory = $creditLimitCollectionFactory;
    }

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Ecommerce_CreditLimit::save';

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $creditLimit = $this->creditLimitFactory->create();

            try {
                //get customer last rec
                $rec = $this->creditLimitCollectionFactory->create()
                    ->getAllRecordsByCustomerId($data['customer_id'])
                    ->getLastItem();
                $balance = !empty($rec->getData('balance')) ? $rec->getData('balance') : 0;
                $data['balance'] = ($data['credit_type'] == "debit") ? $balance - $data['amount'] : $balance + $data['amount'];
                
                $creditLimit->addData($data);
                $this->creditLimitResourceModel->save($creditLimit);
                $this->getMessageManager()->addSuccessMessage(__('You saved the data successfully.'));
            } catch (\InvalidArgumentException $exception) {
                $this->getMessageManager()->addErrorMessage($exception->getMessage());
                $this->_getSession()->setFormData($data);
            } catch(\Exception $e){
                $this->getMessageManager()->addErrorMessage($e->getMessage());
                $this->_getSession()->setFormData($data);
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}



