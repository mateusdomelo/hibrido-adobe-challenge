<?php
/**
 * @author Mateus Melo
 */

declare(strict_types=1);

namespace Hibrido\Cms\Setup\Patch\Data;

use Magento\Cms\Api\Data\PageInterfaceFactory;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Datapatch to create a About Us page
 */
class CreateAboutUsPage implements DataPatchInterface
{
    /**
     * CreateAboutUsPage class constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageRepositoryInterface $pageRepository
     * @param PageInterfaceFactory $pageFactory
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly PageRepositoryInterface $pageRepository,
        private readonly PageInterfaceFactory $pageFactory
    ) {
    }

    /**
     * Create About Us page for all store views
     *
     * @throws LocalizedException
     * @return void
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();
      
        $page = $this->pageFactory->create();
        $page->setTitle('About Us')
            ->setContent('This is the content from About Us page')
            ->setStores([0])
            ->setIsActive(1);

        $this->pageRepository->save($page);

        $this->moduleDataSetup->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }
}