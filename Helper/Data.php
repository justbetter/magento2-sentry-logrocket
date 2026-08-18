<?php

namespace JustBetter\SentryLogrocket\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    public const XML_PATH_SRS = 'sentry/general/';
    public const XML_PATH_SRS_ENVIRONMENT = 'sentry/environment/';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Data constructor.
     *
     * @param Context          $context
     * @param DeploymentConfig $deploymentConfig
     */
    public function __construct(
        Context $context,
        protected DeploymentConfig $deploymentConfig
    ) {
        $this->scopeConfig = $context->getScopeConfig();

        parent::__construct($context);
    }

    /**
     * Get logrocket key.
     *
     * @return ?string
     */
    public function getLogrocketKey(): ?string
    {
        $value = $this->scopeConfig->getValue(static::XML_PATH_SRS_ENVIRONMENT.'logrocket_key', ScopeInterface::SCOPE_STORE)
            ?? $this->deploymentConfig->get('sentry/logrocket_key');

        return $value !== null ? (string) $value : null;
    }

    /**
     * Whether to use logrocket.
     *
     * @return bool
     */
    public function useLogrocket(): bool
    {
        return $this->scopeConfig->isSetFlag(static::XML_PATH_SRS.'use_logrocket', ScopeInterface::SCOPE_STORE) &&
            $this->getLogrocketKey() !== null;
    }

    /**
     * Should logrocket identify.
     *
     * @return bool
     */
    public function useLogrocketIdentify(): bool
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_SRS.'logrocket_identify',
            ScopeInterface::SCOPE_STORE
        );
    }
}
