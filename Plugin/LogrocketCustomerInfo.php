<?php

namespace JustBetter\SentryLogrocket\Plugin;

use Magento\Customer\CustomerData\Customer;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\Session;

class LogrocketCustomerInfo
{
    /**
     * @param CurrentCustomer $currentCustomer
     * @param Session         $customerSession
     */
    public function __construct(
        protected CurrentCustomer $currentCustomer,
        protected Session $customerSession
    ) {
    }

    /**
     * Add customer email and full name to the section data.
     *
     * @param Customer            $subject
     * @param array<string,mixed> $result
     *
     * @return array<string,mixed>
     */
    public function afterGetSectionData(Customer $subject, array $result): array
    {
        if (!$this->customerSession->isLoggedIn()) {
            return $result;
        }

        $customer = $this->currentCustomer->getCustomer();

        $result['email'] = $customer->getEmail();
        $result['fullname'] = $customer->getFirstname().' '.$customer->getLastname();

        return $result;
    }
}
