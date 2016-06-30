<?php
    namespace Shopify\src;

    use Shopify\src\ConnectShopify;
    use Shopify\src\exception\ShopifyException;

    class Shopify
    {
        /**
         * @todo The vendor (protected - setable)
         * @var string
         */
        protected $strVendor;

        /**
         * @todo Connection object store
         * @see Shopify\src\ConnectShopify
         * @var ConnectShopify
         */
        protected $objConnectShopify;

        /**
         * @todo array of the item parameters and form types. Later it can come from dBase
         * @var array
         */
        protected $arrItem = array(
                'published'    => 'checkbox',
                'title'        => 'text',
                'body_html'    => 'textarea',
                'vendor'       => 'text',
                'product_type' => 'text',
                'tags'         => 'text',
                'variants'     => array(
                                        'option1' => 'text',
                                        'price'   => 'text',
                                        'sku'     => 'text',
                                    ),
            );

        /**
         * @todo some protected and private variable is availebled (just read, if it is necessary).
         *  If it is not exists it is droped standard error
         * @param mixed $argName
         * @return mixed
         */
        public function __get($argName)
        {
            if( isset($this->{$argName}) ) { return $this->{$argName}; }
        } // public function __get($argName){ end

        /**
         * @rodo Shopify products upload class. It has to set the vendor and connection
         * @param string $argVendor
         * @param ConnectShopify &$argConnectShopifyObj
         */
        public function __construct($argVendor, &$argConnectShopifyObj)
        {
            $this->strVendor = $argVendor;
            $this->objConnectShopify = $argConnectShopifyObj;
        } // public function __construct($argVendor) end

        /**
         * @todo add items to shopify without check. The validaty is on the shopify site.
         *  first parameter is the error which comes from the site.
         *  return: json from shopify.
         * @param array &$argArrError
         * @return json
         * @throws ShopifyException
         */
        public function addItem(&$argArrError)
        {
            // set the new product link
            $this->objConnectShopify->strShopifyFunctionJSON = 'products';

            // JSON building
            $json = array();
            if( !isset($_POST['published']) ) {
                $json['product']['published'] = false;
            }
            // data from $_POST into JSON array
            foreach($this->arrItem as $key => $tag)
            {
                if( !is_array($tag) && isset($_POST[$key]) )
                {
                    $json['product'][$key] = ($tag=='checkbox'?true:$_POST[$key]);
                } // if( isset($_POST[$key]) ) end
                elseif( is_array($tag) )
                {
                    $arrTmp = array();
                    foreach($tag as $subKey => $subTag)
                    {
                        $arrTmp[$subKey] =
                        $json['product'][$subKey] = $_POST[$subKey];
                    }
                    $json['product'][$key][] = $arrTmp;
                } // elseif( is_array($key) ) end
            } // foreach( $this->arrItem as $key => $tag ) end
            // Images searching
            if( isset($_POST['images']) ) {
                $arrImages = is_array($_POST['images'])?$_POST['images']:array($_POST['images']);
                foreach($arrImages as $imgTag)
                {
                    $json['product']['images'][]['src'] = $imgTag;
                }
            }

            // send to the site
            try
            {
                $response = json_decode($this->objConnectShopify->curlPost($json), true);
            } // try end
            catch (ShopifyException $ex)
            {
                throw new ShopifyException($ex->__toString());
            } // catch (ShopifyException $ex) end

            // we may be get some errors
            if( isset($response['errors']) )
            {
                $argArrError = $response['errors'];
                throw new ShopifyException('Wrong parameters!');
            } // if( isset($response['error']) )end
            elseif(isset($response['error']))
            {
                $argArrError = array( 'errors' => array($response['error']));
                throw new ShopifyException($response['error']);
            }

            // return the new product
            return $response;
        } // public function addItem(&$argArrError) end
    } // class Shopify end

?>