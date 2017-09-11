<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Panalink\ContentScheduler\Block\Widget;

/**
 * Cms Static Block Widget
 *
 * @author Magento Core Team <core@magentocommerce.com>
 */
class Block extends \Magento\Cms\Block\Widget\Block
{
	
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $blockId = $this->getData('block_id');
        $blockHash = get_class($this) . $blockId;

        if (isset(self::$_widgetUsageMap[$blockHash])) {
            return $this;
        }
        self::$_widgetUsageMap[$blockHash] = true;

        if ($blockId) {
            $storeId = $this->_storeManager->getStore()->getId();
            /** @var \Magento\Cms\Model\Block $block */
            $block = $this->_blockFactory->create();
            $block->setStoreId($storeId)->load($blockId);
			/**   IN RANGE **/
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$timezone = $objectManager->create('\Magento\Framework\Stdlib\DateTime\TimezoneInterface');
			
			$inRange = $timezone->isScopeDateInInterval(
            null,
            $block->getCustomBlockFrom(),
            $block->getCustomBlockTo()
			);
			echo $inRange;	
			if ($block->isActive()) {
                if($inRange){
					$this->setText(
						$this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($block->getContent())
					);
				}
            }
        }

        unset(self::$_widgetUsageMap[$blockHash]);
        return $this;
    }
}
