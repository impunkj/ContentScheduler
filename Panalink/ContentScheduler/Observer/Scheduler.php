<?php 
namespace Panalink\ContentScheduler\Observer;

class Scheduler implements \Magento\Framework\Event\ObserverInterface
	{		
		/* 
			Protected BlockFactory
		*/
		private $blockFactory;
		/*
			Protected BlockRepository
		*/
		protected $blockCollectionFactory;
		/* 
			Construct Initialize
		*/		
		public function __construct(
			\Psr\Log\LoggerInterface $logger,
			\Magento\Cms\Model\ResourceModel\Block\CollectionFactory $blockCollectionFactory	 
		)
		{
			$this->logger = $logger; 
			$this->blockCollectionFactory = $blockCollectionFactory;		
		}		
		public function execute(\Magento\Framework\Event\Observer $observer) {							
			$block = $observer->getEvent()->getDataObject();
			$block_id = $block->getId();
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			$tableName = $resource->getTableName('cms_block'); //gives table name with prefix
			$custom_block_from =  date("Y-m-d", strtotime($block->getCustomBlockFrom()));
			$custom_block_to =  date("Y-m-d", strtotime($block->getCustomBlockTo()));  // $block->getCustomBlockTo();
			$sql = "Update ". $tableName .  " Set `custom_block_from` = '" .  $custom_block_from  . "', `custom_block_to` = '"  .  $custom_block_to . "' where block_id = "  . $block_id ."";
			//$this->logger->debug($sql);		
			$connection->query($sql);		
		}			
}
