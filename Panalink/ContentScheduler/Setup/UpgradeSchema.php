<?php
/**
 * Panalink_ContentSchedular extension
 *
 *
 * @category  Panalink
 * @package   Panalink_ContentSchedular
 * @copyright 2016 Claudiu Creanga
 * @author    Pankaj
 */

namespace Panalink\ContentScheduler\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.Generic.CodeAnalysis.UnusedFunctionParameter)
     */

    // @codingStandardsIgnoreStart
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if ($installer->tableExists('cms_block')) {
            $table = $installer->getTable('cms_block');
            $connection = $installer->getConnection();
            if (version_compare($context->getVersion(), '1.0.2') < 0) {
                $connection->addColumn(
                    $table,
                    'custom_block_from',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        'nullable' => false,
                        'comment' => 'date'
                    ]
                );
                $connection->addColumn(
                    $table,
                    'custom_block_to',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        'nullable' => false,
                        'comment' => 'date'
                    ]
                );				
            }
            $installer->endSetup();
        }
    }
}
