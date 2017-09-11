<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Panalink\ContentScheduler\Block;

/**
 * Cms Static Block Widget
 *
 * @author Magento Core Team <core@magentocommerce.com>
 */
class Block extends \Magento\Cms\Block\Block
{
	
    protected function _toHtml()
    {	
			
        $blockId = $this->getBlockId();
        $html = '';
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
            if ($block->isActive()) {
				if($inRange){
                $html = $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($block->getContent());
				}
            }
        }
        return $html;
    }
}
