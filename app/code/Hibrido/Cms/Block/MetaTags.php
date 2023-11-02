<?php
/**
 * @author Mateus Melo
 */

declare(strict_types=1);

namespace Hibrido\Cms\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Cms\Model\Page as CmsPage;
use Magento\Store\Api\Data\StoreInterface;

/**
 * Class to provide data for CMS pages
 */
class MetaTags extends Template
{

    /** Default value for Admin Store Code */
    public const ADMIN_STORE_CODE_DEFAULT = 'admin';

    /**
     * Page class constructor
     *
     * @param Template\Context $context
     * @param StoreManagerInterface $storeManager
     * @param CmsPage $page
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        private StoreManagerInterface $storeManager,
        private CmsPage $page,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Retrieves stores data for the current CMS page
     *
     * @return array
     */
    public function getPageStoresData(): array
    {
        $storesData = [];
        
        if ($this->isMultiStores()) {
            foreach ($this->getCmsStores() as $store) {
                $storesData[] = [
                    'code' => $store->getCode(),
                    'baseUrl' => $this->getUrl('', ['_scope' => $store->getId()]),
                    'identifier' => $this->page->getIdentifier()
                ];
            }
        }

        return $storesData;
    }

    /**
     * Checks if the CMS page is running in a multi-store environment
     *
     * @return bool
     */
    public function isMultiStores()
    {
        $allStores = $this->getCmsStores();
        
        foreach ($allStores as $store) {
            if ($store->getCode() === static::ADMIN_STORE_CODE_DEFAULT) {
                return true;
            }
        }

        return count($allStores) > 1;
    }

    /**
     * Get stores associated with the current CMS page
     *
     * @return StoreInterface[]
     */
    protected function getCmsStores()
    {
        $storesIds = $this->page->getStores();
        return $this->storeManager->getStores($storesIds);
    }
}
