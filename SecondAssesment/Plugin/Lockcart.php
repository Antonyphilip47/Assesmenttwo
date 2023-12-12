<?php
namespace Ceymox\SecondAssesment\Plugin;
use Magento\Framework\Message\ManagerInterface ;
use Magento\Checkout\Model\Session;
use Magento\Checkout\Model\Cart;
 
class Lockcart
{
 
    protected $_messageManager;
    protected $quote;
    protected $_customerSession;
    protected $url;
    protected $http;
 
    public function __construct(
        Session $checkoutSession,
        ManagerInterface $messageManager,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\Response\Http $http,
    ) {
        $this->quote = $checkoutSession->getQuote();
        $this->_messageManager = $messageManager;
        $this->_customerSession = $session;
        $this->url = $url;
        $this->http = $http;
    }
 
 
    public function beforeAddProduct(
        Cart $subject,
        $productInfo,
        $requestInfo = null
    ) {
        $this->allowedMethod($subject);

        if ($this->_customerSession->isLoggedIn()) {
            // return [$productInfo, $requestInfo];
            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
            $logger = new \Zend_Log();
            $logger->addWriter($writer);
            $logger->info('test1');
            throw new \Magento\Framework\Exception\LocalizedException(__("ha ha"));
        } else {
            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
            $logger = new \Zend_Log();
            $logger->addWriter($writer);
            $logger->info('test2');
            throw new \Magento\Framework\Exception\LocalizedException(__("ha ha"));
            // Customer is not logged in
        }

 // you can put custom condition and message here to restrict cart
    }
 
  
    public function beforeUpdateItems(Cart $subject, $data)
    {
        $this->allowedMethod($subject);
 // you can put custom condition and message here to restrict cart
        return [$data];
    }
 
   
    public function beforeUpdateItem(
        Cart $subject,
        $requestInfo = null,
        $updatingParams = null
    ) {
        $this->allowedMethod($subject);
 // you can put custom condition and message here to restrict cart
        return [$requestInfo, $updatingParams];
    }
 
   
    public function beforeRemoveItem(Cart $subject, $itemId)
    {
        $this->allowedMethod($subject);
 // you can put custom condition and message here to restrict cart
        return [$itemId];
    }
 
}