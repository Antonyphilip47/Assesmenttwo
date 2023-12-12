<?php
namespace Ceymox\SecondAssesment\Observer;
 
use Magento\Framework\Event\ObserverInterface;

 
class RestrictAddToCart implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;
    protected $_customerSession;
    protected $url;
    protected $http;
    protected $_checkoutSession;


 
    /**
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\Response\Http $http,
        \Magento\Checkout\Model\Session $_checkoutSession
    )
    {
        $this->_customerSession = $session;
        $this->_messageManager = $messageManager;
        $this->url = $url;
        $this->http = $http;
        $this->_checkoutSession = $_checkoutSession;
    }
 
    /**
     * add to cart event handler.
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_customerSession->isLoggedIn()) {

            $cartData = $this->_checkoutSession->getQuote()->getAllVisibleItems();
            $cartDataCount = count( $cartData );
            // return [$productInfo, $requestInfo];
            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
            $logger = new \Zend_Log();
            $logger->addWriter($writer);
            $logger->info('test1');
            $logger->info(print_r($cartData, true));
            $observer->getRequest()->setParam('product', true);
            return $this;

        } else {
            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
            $logger = new \Zend_Log();
            $logger->addWriter($writer);
            $logger->info('test2');
            $this->_messageManager->addError(__('your custom message'));
            //set false if you not want to add product to cart
            $observer->getRequest()->setParam('product', false);
            // Customer is not logged in
            return $this;

        }

        return $this;

 
    }
}