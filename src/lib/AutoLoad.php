<?php

    if( !headers_sent() && !session_id() ) { session_start(); }
    // setting some variable for autoload
    if( !defined('INDX_DIR') ) {
        define('INDX_DIR', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'));
    }
    if( !defined('ROOT_DIR') ) {
        define('ROOT_DIR', realpath(INDX_DIR));
    }
    if( !defined('CMS_DIR') ) {
        define('CMS_DIR', realpath(ROOT_DIR));
    }

    /**
     * @todo Auto loading, namespace/use linking
     * @access public
     */
    class AutoLoad {

        /**
         * @todo CMS OR ROOT directory
         * @var array[file => boolean];
         */
        protected $booCMS = false;

        /**
         * @todo the ROOT_DIR
         * @var string
         */
        protected $strDir;

        /**
         * @todo A CMS_DIR
         * @var string
         */
        protected $strCMSDir;

        /**
         * @todo class should be loaded
         * @var string
         */
        protected $strClassName;

        public function __construct() {
            $this->strDir    = ROOT_DIR;
            $this->strCMSDir = CMS_DIR;
        }

        protected function findFile()
        {
            $arrT = explode (DIRECTORY_SEPARATOR, $this->strClassName);
            $t = array_pop($arrT);
            $this->booCMS[$t] = false;
            $ret = false;
            if($this->strClassName &&
                    is_file($this->strDir . DIRECTORY_SEPARATOR . $this->strClassName . '.php'))
            {
                $ret = $this->strDir . DIRECTORY_SEPARATOR . $this->strClassName;
            }
            elseif( $this->strClassName &&
                    is_file($this->strCMSDir . DIRECTORY_SEPARATOR . $this->strClassName . '.php' ))
            {
                $this->booCMS[$t] = true;
                $ret = $this->strCMSDir . DIRECTORY_SEPARATOR . $this->strClassName;
            }

            return $ret;
        } // protected function findFile() end

        public function includeFile($argClassName)
        {
            $this->strClassName = trim(str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $argClassName),
                            DIRECTORY_SEPARATOR );
            $file = $this->findFile($this->strClassName);
            if($file) {
                require_once($file.'.php');
            }
        } // public function IncludeFile() { vege

        public function cmsWhereFile($argFile, &$argBooCms=false)
        {
            $argBooCms = false;
            $aFile   = trim(
                        str_replace(array(ROOT_DIR, CMS_DIR, INDX_DIR, '/', '\\'), DIRECTORY_SEPARATOR, $argFile),
                        DIRECTORY_SEPARATOR );
            if(is_file(ROOT_DIR . DIRECTORY_SEPARATOR . $aFile))
            {
                return ROOT_DIR . DIRECTORY_SEPARATOR . $aFile;
            }
            else
            {
                $argBooCms = true;
                return CMS_DIR . DIRECTORY_SEPARATOR . $aFile;
            }
        } // function cmsIncludeFile( $argFile ) vege

        public function cmsWhereDir($argDir, &$argBooCms=false)
        {
            $argBooCms = false;
            $aDir    = trim(
                            str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $argDir),
                            DIRECTORY_SEPARATOR );
            if(is_dir(ROOT_DIR . DIRECTORY_SEPARATOR . $aDir))
            {
                return ROOT_DIR . DIRECTORY_SEPARATOR . $aDir;
            }
            else
            {
                $argBooCms = true;
                return CMS_DIR . DIRECTORY_SEPARATOR . $aDir;
            }
        } // function cmsIncludeFile( $argFile ) vege
    } // class classAutoLoad extends opAbstractAdmin { vege

    // set the autoload
    $AutoLoad = new AutoLoad();
    spl_autoload_extensions('.php');
    spl_autoload_register(array($AutoLoad, 'includeFile'));

?>