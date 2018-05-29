<?php
namespace Born\OrderController\Controller\Guestorderhistory;

class Index extends \Magento\Framework\App\Action\Action
{
	/**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
	
	/**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $orderCollectionFactory;
	
	/**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
	
    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
	 * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
	 * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
		\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
		$this->orderCollectionFactory = $orderCollectionFactory;
		$this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        //return $this->resultPageFactory->create();
		$result = $this->resultJsonFactory->create();
		$jsonData = $this->getJsonArrayOfGuestOrders();
		return $result->setData($jsonData);
    }
	
	/**
     * get guest order collection
     *
     * @return \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
	public function getGuestOrderCollection()
	{
		$orderCollecion = $this->orderCollectionFactory
								->create()
								->addFieldToSelect('*');
								
		$orderCollecion->addFieldToFilter(
							'customer_id',
							array(
								'null' => true
							)
						);
		
		$totalGuestOrder = $this->getRequest()->getParam('total_guest_order');
		if ('all' !== $totalGuestOrder){
			$orderCollecion->getSelect()->limit((int)$totalGuestOrder);
		}
		
		return $orderCollecion;
	}
	
	/**
     * format guest order collection into array for json object
     */
	public function getJsonArrayOfGuestOrders()
	{
		$jsonArray = [];
		$guestOrderCollection = $this->getGuestOrderCollection();
		foreach($guestOrderCollection as $_collection){
			$guestOrderHistory['status'] = $_collection->getStatus();
			$guestOrderHistory['sub_total'] = $_collection->getSubTotal();
			$allVisibleItems = $_collection->getAllVisibleItems();
			$itemArray = [];
			$qtyInvoiced = 0;
			foreach($allVisibleItems as $_item){
				$qtyInvoiced = $qtyInvoiced + $_item->getQtyInvoiced();
				$_itemArray['sku'] = $_item->getSku();
				$_itemArray['item_id'] = $_item->getItemId();
				$_itemArray['price'] = $_item->getRowTotal();
				$itemArray[] = $_itemArray;
			}
			$guestOrderHistory['item'] = $itemArray;
			$guestOrderHistory['grand_total'] = $_collection->getGrandTotal();;
			$jsonArray[] = $guestOrderHistory;
		}
		return $jsonArray;
	}
}
