<?php
/**
 * @package Ceymox_SecondAssesment
 */
declare(strict_types=1);

namespace Ceymox\SecondAssesment\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\Session;

class Restrictions implements ObserverInterface
{
    /**
     * @var ManagerInterface
     */
    protected $messageManager;
    /**
     * @var RedirectInterface
     */
    protected $redirect;
    /**
     * @var UrlInterface
     */
    protected $url;
    /**
     * @var UrlInterface
     */
    protected $_customerSession;
    
    /**
     * Restrictions constructor.
     *
     * @param ManagerInterface $messageManager
     * @param RedirectInterface $redirect
     * @param UrlInterface $url
     * @param Session $session
     */
    public function __construct(
        ManagerInterface $messageManager,
        RedirectInterface $redirect,
        UrlInterface $url,
        Session $session
    ) {
        $this->messageManager = $messageManager;
        $this->redirect = $redirect;
        $this->url = $url;
        $this->_customerSession = $session;
    }
    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $product = $observer->getProduct();
        if ($product->getPrice() > 100 && !$this->_customerSession->isLoggedIn()) {
            throw new LocalizedException(__('You need to login for adding any product worth 100 or more'));
        }
    }
}
