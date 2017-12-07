<?php

    namespace Techievolve\SuperiorService\Cron;
    class SuperiorService {
     
        protected $_logger;
        protected $_customers;
        protected $_configWriter;
        protected $_reviewsCollection;
        protected $_helper;
     
        public function __construct(
            
            \Psr\Log\LoggerInterface $logger,
            \Magento\Customer\Model\Customer $customers,
            \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewsCollection,
            \Techievolve\SuperiorService\Helper\Data $_helper,
            \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
            
        ) {
            $this->_logger = $logger;
            $this->_customers = $customers;
            $this->_configWriter = $configWriter;
            $this->_reviewsCollection = $reviewsCollection;
            $this->_helper = $_helper;
        }
        
        
        /*
         * Get all customer count
        */
        
        private function __getCustomersCount(){
            return count($this->_customers->getCollection());
        }
        
        
        /*
         * Get all product reviews count
        */
        
        private function __getReviewsCount(){
            return count($this->_reviewsCollection->create());
        }
        
        
        protected function __saveConfigValue($identifier,$value){
            return $this->_configWriter->save($identifier, $value);
        }
        
     
        public function execute() {
            
            //$this->_logger->info("SuperiorService Cron Run: ");            
            
            if(!$this->_helper->isEnabled()){                
                //$this->_logger->info("Module is disabled.");
                return $this;
            }
            
            //$this->_logger->info("Customer Count: ".$this->__getCustomersCount());
            //$this->_logger->info("Reviews Count: ".$this->__getReviewsCount());
            
            $this->__saveConfigValue('superiorservice/settings/customers',$this->__getCustomersCount());
            $this->__saveConfigValue('superiorservice/settings/product_reviews',$this->__getReviewsCount());
            //$this->__saveConfigValue('superiorservice/settings/customers',$this->__getCustomersCount());
            //$this->__saveConfigValue('superiorservice/settings/customers',$this->__getCustomersCount());
            
            
            return $this;
        }
    }

