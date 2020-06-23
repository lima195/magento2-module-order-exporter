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
			->setComment("Order Exporter Queue");

		$setup->getConnection()->createTable($table);

		$setup->endSetup();
	}
}
