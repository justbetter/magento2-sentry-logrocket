<?php

namespace JustBetter\SentryLogrocket\Model\Collector;

use JustBetter\Sentry\Helper\Data as SentryDataHelper;
use JustBetter\SentryLogrocket\Helper\Data as DataHelper;
use Magento\Csp\Api\PolicyCollectorInterface;
use Magento\Csp\Model\Policy\FetchPolicy;

class LogrocketCspCollector implements PolicyCollectorInterface
{
    /**
     * @param SentryDataHelper $sentryDataHelper
     * @param DataHelper       $dataHelper
     */
    public function __construct(
        private SentryDataHelper $sentryDataHelper,
        private DataHelper $dataHelper
    ) {
    }

    /**
     * @inheritDoc
     */
    public function collect(array $defaultPolicies = []): array
    {
        $policies = $defaultPolicies;
        if (!$this->sentryDataHelper->isActive()) {
            return $policies;
        }

        if ($this->dataHelper->useLogrocket()) {
            $policies[] = new FetchPolicy(
                'script-src',
                false,
                ['https://cdn.lr-ingest.io']
            );
        }

        return $policies;
    }
}
