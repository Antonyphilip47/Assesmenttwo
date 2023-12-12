<?php

namespace Ceymox\SecondAssesment\Plugin;

class QuotePlugin
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function beforeAddProduct(
        \Magento\Quote\Model\Quote $subject,
        \Magento\Catalog\Model\Product $product,
        $request = null,
        $processMode = \Magento\Catalog\Model\Product\Type\AbstractType::PROCESS_MODE_FULL
    ) {

        if($request){


            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
            $logger = new \Zend_Log();
            $logger->addWriter($writer);
            $logger->info($request->getData('qty'));
            $logger->info(print_r($subject, true));
            


            // $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
            // $this->$logger->addWriter($writer);
            $this->logger->info("BUNDLE PRODUCT QTY REQUEST BEFORE: " . $request->getData('qty'));
            $this->logger->info("BUNDLE OPTION REQUEST BEFORE: " . json_encode($request->getData('bundle_option')));
            $this->logger->info("BUNDLE OPTION QTY REQUEST BEFORE: " . json_encode($request->getData('bundle_option_qty')));
        }
        return [$product, $request, $processMode];
    }

}