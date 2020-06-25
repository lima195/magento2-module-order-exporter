<?php

namespace Lima\OrderExporter\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class InstallData
 * @package Lima\OrderExporter\Setup
 */
class InstallData implements InstallDataInterface
{
    const ORDER_QUEUE_TABLE = 'order_exporter_queue';
    const IBGE_CITY_CODE_TABLE = 'ibge_city_code';

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		/**
		 * Create table 'order_exporter_queue'
		*/

		$salesOrderTable = $setup->getTable('sales_order');

		$table = $setup->getConnection()
			->newTable($setup->getTable(self::ORDER_QUEUE_TABLE))
			->addColumn(
				'export_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				[
					'identity' => true,
					'unsigned' => true,
					'nullable' => false,
					'primary' => true
				],
				'Export ID'
			)
			->addColumn(
				'order_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				[
					'unsigned' => true,
					'nullable' => false
				],
				'Order ID'
			)
            ->addColumn(
                'payload',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                11222222,
                ['nullable' => false],
                'Payload'
            )
            ->addColumn(
                'error_log',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                11222222,
                ['nullable' => true],
                'Error Log'
            )
			->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [
					'nullable' => true,
					'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
				],
                'Created At'
			)
			->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [
					'nullable' => true
				],
                'Updated At'
			)
			->addColumn(
                'pending',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                1,
                [
					'default' => 1
				],
                'Is Pending'
            )
            ->addForeignKey(
                self::ORDER_QUEUE_TABLE . '_order',
                'order_id',
                $salesOrderTable,
                'entity_id',
               \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
			->setComment("Order Exporter Queue");

		$setup->getConnection()->createTable($table);

        /**
         * Create table 'ibge_city_codes'
         */

        $table = $setup->getConnection()
            ->newTable($setup->getTable(self::IBGE_CITY_CODE_TABLE))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Entity ID'
            )
            ->addColumn(
                'uf',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false
                ],
                'UF'
            )
            ->addColumn(
                'uf_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                250,
                ['nullable' => false],
                'UF Name'
            )
            ->addColumn(
                'city_code',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                6,
                ['nullable' => false],
                'City Code'
            )
            ->addColumn(
                'city_code_complete',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                10,
                ['nullable' => false],
                'City Code Complete'
            )
            ->addColumn(
                'city_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                250,
                ['nullable' => false],
                'City Name'
            )
            ->setComment("IBGE City Code");

        $setup->getConnection()->createTable($table);

		$setup->endSetup();
	}
}
