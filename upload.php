<?php
    namespace Shopify;
    // error off
    ini_set('display_errors', 0);
    error_reporting(0);

    // set timezone
    date_default_timezone_set('Europe/London');

    // autoload for namespace
    require_once('src'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'AutoLoad.php');

    // use libraries
    use Shopify\src\UploadHandler;

    $upload_handler = new UploadHandler();
?>