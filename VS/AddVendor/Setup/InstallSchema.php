<?php

namespace VS\AddVendor\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    const TABLE_NAME_PRODUCT = 'catalog_product_entity';
    const TABLE_NAME_VENDOR = 'vs_add_vendor_table';
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $installer = $setup;
        $installer->startSetup();
        $tableName = $installer->getTable(self::TABLE_NAME_VENDOR);
        $tableNameProduct = $installer->getTable(self::TABLE_NAME_PRODUCT);
        if ($installer->getConnection()->isTableExists($tableName) != true && $installer->getConnection()->isTableExists($tableNameProduct)) {
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn('vendor_id', Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ], 'ID')
                ->addColumn('icon', Table::TYPE_TEXT, null, [
                    'length' => 255,
                    'nullable' => true
                ], 'Image vendor')
                ->addColumn('name', Table::TYPE_TEXT, null, [
                    'length' => 255,
                    'nullable' => false
                ], 'Name vendor')
                ->addColumn('description', Table::TYPE_TEXT, null, [
                    'length' => 255,
                    'nullable' => true
                ], 'Description vendor')
                ->addColumn('status', Table::TYPE_BOOLEAN, null, [], 'Status')
                ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT
                ], 'Created')
                ->setComment('Vendor Table');
                $installer->getConnection()->createTable($table);

//            $installer->getConnection()->addColumn(
//                $tableNameProduct,
//                'vendor_id',
//                [
//                    "type" => Table::TYPE_INTEGER,
//                    "nullable" => true,
//                    'unsigned' => true,
//                    "comment" => "vendor_id"
//                ]
//            );
//            $installer->getConnection()->addForeignKey(
//                $installer->getFkName($installer->getTable(self::TABLE_NAME_VENDOR), 'vendor_id', self::TABLE_NAME_PRODUCT, 'vendor_id'),
//                $installer->getTable(self::TABLE_NAME_VENDOR),
//                'vendor_id',
//                $installer->getTable(self::TABLE_NAME_PRODUCT),
//                'vendor_id',
//                AdapterInterface::FK_ACTION_SET_NULL
//            );
        }
        $installer->endSetup();
    }
}