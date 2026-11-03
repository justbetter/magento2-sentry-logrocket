<?php

namespace JustBetter\SentryLogrocket\Block;

use JustBetter\Sentry\Helper\Data as SentryDataHelper;
use JustBetter\SentryLogrocket\Helper\Data as DataHelper;
use Magento\Framework\View\Element\Template;

class LogrocketScript extends Template
{
    /**
     * LogrocketScript constructor.
     *
     * @param SentryDataHelper $sentryDataHelper
     * @param DataHelper       $dataHelper
     * @param Template\Context $context
     * @param array            $data
     */
    public function __construct(// @phpstan-ignore missingType.iterableValue
        private SentryDataHelper $sentryDataHelper,
        private DataHelper $dataHelper,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Whether the LogRocket script tag can be rendered in this block.
     *
     * @return bool
     */
    public function canUseScriptTag(): bool
    {
        if (!$this->sentryDataHelper->isActive() || !$this->sentryDataHelper->useScriptTag()) {
            return false;
        }

        $placement = (string) $this->getData('placement');

        return $this->sentryDataHelper->showScriptTagInThisBlock('sentry.'.$placement) && $this->useLogRocket();
    }

    /**
     * If LogRocket should be used.
     *
     * @return bool
     */
    public function useLogRocket(): bool
    {
        return $this->dataHelper->useLogrocket();
    }

    /**
     * If LogRocket identify should be used.
     *
     * @return bool
     */
    public function useLogRocketIdentify(): bool
    {
        return $this->dataHelper->useLogrocketIdentify();
    }

    /**
     * Gets the LogRocket key.
     *
     * @return string
     */
    public function getLogrocketKey(): string
    {
        return (string) $this->dataHelper->getLogrocketKey();
    }
}
