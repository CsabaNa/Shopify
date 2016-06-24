<?php
    namespace Shopify\src\exception;

    class ShopifyException  extends \Exception
    {
        /**
         * @todo Error/Exception msg
         * @var string
         */
        protected $strMsg;

        function __construct($argStrNotice,$argStrSevereity=0,  $argPrevious = NULL)
        {
            parent::__construct($argStrNotice, $argStrSevereity, $argPrevious);
            $this->strMsg       = $argStrNotice;
        }

        public function __toString ()
        {
            return $this->strMsg;
        }

        public function GetMsg ()
        {
            return $this->strMsg;
        }
    } // class ShopifyException  extends \Exception end

?>