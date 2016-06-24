<?php
    namespace Shopify\src;

    use Shopify\src\exception\ShopifyException;

    class ConnectShopify
    {
        /**
         * @todo It is the url bone to Shopify private APP(s).
         *  Build: https://{API_key}:{API_passw}@{Vendor}.myshopify.com/admin/{Shopify_function}.json{any_other_parameter}
         *  (hide and protect) In the future maybe it is setable from configfile or dBase.
         * @var string
         */
        const strShopifyPrivateURL = 'https://%1$s:%2$s@%3$s.myshopify.com/admin/%4$s.json';

        /**
         * @todo It is the active gate to Shopify private APP(s).
         *  Build: from strShopifyPrivateURL
         *  (hide and protect)
         * @see self::strShopifyPrivateURL
         * @var string
         */
        private $strActiveURL;

        /**
         * @todo The key for Shopify APP to the URL (protected - setable)
         * @var string
         */
        protected $strAPIkey = '';

        /**
         * @todo The password for Shopify APP to the URL (protected - setable)
         * @var string
         */
        protected $strAPIPassw = '';

        /**
         * @todo The vendor (protected - setable)
         * @var string
         */
        protected $strVendor = '';

        /**
         * @todo The function(resource) (protected - setable)
         * @var string
         */
        protected $strShopifyFunctionJSON = '';

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
         * @todo Some varriable is setable and it can verified (more check/validity)
         *      setable var(s):
         *          strAPIkey
         *          strAPIPassw
         *          strVendor
         *          strShopifyFunctionJSON
         *      otherwise PHP standard error
         * @param string $argVarName class varriable name
         * @param mixed $argVarValue varriable value
         */
        public function __set($argVarName,$argVarValue)
        {
            switch("$argVarName")
            {
                // some extra validity is availabe in this place if it is necessary
                case 'strAPIkey':
                case 'strAPIPassw':
                case 'strVendor':
                    // e.g.: extra check: the vendor may be banned from my sites/system/etc...
                case 'strShopifyFunctionJSON':
                    // e.g.: extra check: the cilent must not reach some functionality.
                    $this->{$argVarName} = $argVarValue;
                    $this->setURL();
                    break;
                    // case 'strAPIPassw':
                    // case 'strAPIkey': end
            } // switch("$argVarName") { end
        } // public function __set() { end

        /**
         * @todo The class/object get some information for connect key, passw, vendor, function
         * @param string $argStrAPIKey
         * @param string $argStrAPIPassw
         * @param string $argStrVendor
         * @param string $argStrShopifyFunction optional base: products
         */
        public function __construct($argStrAPIKey, $argStrAPIPassw, $argStrVendor, $argStrShopifyFunction='products')
        {
            $this->strAPIPassw            = $argStrAPIPassw;
            $this->strAPIkey              = $argStrAPIKey;
            $this->strVendor              = $argStrVendor;
            $this->strShopifyFunctionJSON = $argStrShopifyFunction;
            $this->setURL();
        } // public function __construct() end

        /**
         * @todo Set the active url it will be opened.
         *  Before use it has to set the url params
         * @see self::$strAPIkey, self::$strAPIPassw, self::$strVendor, self::$strShopifyFunctionJSON
         */
        protected function setURL()
        {
            $this->strActiveURL = sprintf(self::strShopifyPrivateURL, $this->strAPIkey, $this->strAPIPassw, $this->strVendor, $this->strShopifyFunctionJSON);
        }

        /**
         * @todo Connect to the Shopify with curl and return plane response from the server.
         *  Parameter examples: (....json?)fields=id,images,title
         * @param string $argGETParams optional
         * @return string
         * @throws ShopifyException
         */
        public function curlPlaneQuery($argGETParams='')
        {
            $rC = curl_init();
            curl_setopt($rC, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
            curl_setopt($rC, CURLOPT_URL, $this->strActiveURL.($argGETParams?'?'.ltrim($argGETParams,'?'):''));
            curl_setopt($rC, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($rC);

            if( $res )
            {
                curl_close($rC);
                return $res;
            }
            else
            {
                throw new ShopifyException('Shopify connection faild!');
            }
        } // public function curlPlaneQuery() end

        /**
         * @todo POST data send to the Shopify, return plane response from server.
         *  Parameter: post data
         * @param string $argArrPost
         * @return string
         * @throws ShopifyException
         */
        public function curlPost($argArrPost)
        {
            $rC = curl_init();

            // curl setup
            curl_setopt($rC, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
            curl_setopt($rC, CURLOPT_URL, $this->strActiveURL);
            curl_setopt($rC, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
            curl_setopt($rC, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($rC, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($rC, CURLOPT_POST, 1);
            curl_setopt($rC, CURLOPT_POSTFIELDS,json_encode($argArrPost));

            // request/response
            $res = curl_exec($rC);

            if( $res )
            {
                curl_close($rC);
                return $res;
            }
            else
            {
                throw new ShopifyException('Shopify connection faild!');
            }
        } // public function curlPost() end

        /**
         * @todo Simple plane query which is returned via JSON and it might contain some parameter(s)
         * @param string $argGETParams
         * @return JSON
         */
        public function getJSONObj($argGETParams='')
        {
            return json_decode($this->curlPlaneQuery($argGETParams), true);
        } // public function getJSONObj($argGETParams='') end

    } // class connectShopify end

?>