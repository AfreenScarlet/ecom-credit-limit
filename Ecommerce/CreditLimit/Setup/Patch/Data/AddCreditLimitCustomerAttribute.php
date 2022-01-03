<?php

namespace Ecommerce\CreditLimit\Setup\Patch\Data;


use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

/**
 * Class AddCreditLimitCustomerAttribute
 * @package CreditLimit\Setup\Patch\Data
 */
class AddCreditLimitCustomerAttribute implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var \Magento\Customer\Setup\CustomerSetup
     */
    private $customerSetup;
    /**
     * @var
     */
    private $attributeSetId;
    /**
     * @var
     */
    private $attributeGroupId;

    /**
     * @var SetFactory
     */
    private $attributeSetFactory;

    /**
     * AddCustomerUpdatedAtAttribute constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        SetFactory $attributeSetFactory,
        CustomerSetupFactory $customerSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
    }

    /**
     * {@inheritdoc}
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    public function apply()
    {
        $customerEntity = $this->customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $this->attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $this->attributeGroupId = $attributeSet->getDefaultGroupId($this->attributeSetId);

        $this->addCreditLimitBalanceAttribute();
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    private function addCreditLimitBalanceAttribute()
    {
        $code = 'credit_limit_balance';
        if (!$this->customerSetup->getAttribute(Customer::ENTITY, $code)) {
            $this->customerSetup->addAttribute(
                Customer::ENTITY,
                $code,
                [
                    'type' => 'int',
                    'label' => 'Credit Limit Balance',
                    'input' => 'hidden',
                    'required' => false,
                    'visible' => false,
                    'user_defined' => false,
                    'position' => 1000,
                    'system' => 0,
                ]
            );
        }
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * Example of implementation:
     *
     * [
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch1::class,
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch2::class
     * ]
     *
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Rollback all changes, done by this patch
     *
     * @return void
     */
    public function revert()
    {
        // TODO: Implement revert() method.
    }
}
