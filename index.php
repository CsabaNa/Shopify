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
    use Shopify\src\ConnectShopify;
    use Shopify\src\Shopify;
    use Shopify\src\exception\ShopifyException;

    // Shopify APP
    $api_key     = '67c80782833ba312c729343ab83683c1';
    $api_passw   = 'f5091d1cb9db16c437b4ccf97202dead';
    $vendor      = 'csabana';
    $wwwBaseDir  = 'http'.
        ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443
            ? 's'
            : ''
        ).'://'.$_SERVER['HTTP_HOST'].'/wf/urg/Shopify';

    $connect = new ConnectShopify($api_key, $api_passw, $vendor);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Shopify</title>
        <meta name="googlesite-verification" content="" />
	<meta charset="utf-8" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="generator" content="" />
        <meta name="author" content="" />
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="robots" content="no follow" />
        <meta name="revisit-after" content="never" />
        <meta name="rating" content="general" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

        <base href="<?=$wwwBaseDir; ?>/" />

        <!--[if lt IE 9]>
            <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <style>
            form {
                width: 400px;
                margin: 20px auto;
            }
            form * {
                display: inline-block;
            }
            form div {
                width: 100%;
                margin: 5px 0px;
            }
            form div label {
                width: 100%;
                text-align: left;
            }
            form div textarea,
            form div input {
                width: 70%;
                float: left;
                margin-right: 10px;
            }
            form div input[type="checkbox"] {
                width: 25px;
                float: none;
                margin-left: 10px;
            }
            form div select {
                width: 72%;
            }
            form div select option {
                display: block;
            }
            form div input[type="submit"] {
                width: 50%;
                margin: 5px auto;
                float: none;
                display: block;
            }
            form div.block input[type="submit"] {
                width: 100%;
                float: left;
                display: block;
            }
            form div.block div {
                width: 30%;
            }
            div.error span,
            span.error {
                display: block;
                color: red;
                width: 250px;
                margin: 20px auto;
            }
            div.error span {
                display: block;
                color: red;
                width: 250px;
                margin: 5px auto 10px;
            }
            form div.error textarea,
            form div.error input {
                border-color: red;
            }
            div#prodBox {
                width: 412px;
                display: block;
                margin: 20px auto;
            }
            div#prodBox span {
                width: 100%;
                display: block;
                margin: 10px 0px;
                color: green;
                text-align: center;
            }
            div#prod {
                width: 100%;
                display: block;
                float: left;
                border: 1px solid silver;
                padding: 10px;
                -webkit-border-radius: 15px 0px;
                   -moz-border-radius: 15px 0px;
                    -ms-border-radius: 15px 0px;
                     -o-border-radius: 15px 0px;
                        border-radius: 15px 0px;
                -webkit-box-shadow: 2px 2px 7px -3px #232f3e;
                   -moz-box-shadow: 2px 2px 7px -3px #232f3e;
                    -ms-box-shadow: 2px 2px 7px -3px #232f3e;
                     -o-box-shadow: 2px 2px 7px -3px #232f3e;
                        box-shadow: 2px 2px 7px -3px #232f3e;
            }
            div#prod span.img {
                width: 150px;
                display: inline-block;
                float: left;
            }
            div#prod span.img img {
                width: 100%;
                height: auto;
                display: inline-block;
                float: left;
                -webkit-border-radius: 15px;
                   -moz-border-radius: 15px;
                    -ms-border-radius: 15px;
                     -o-border-radius: 15px;
                        border-radius: 15px;
                -webkit-box-shadow: 2px 2px 7px -3px #767676;
                   -moz-box-shadow: 2px 2px 7px -3px #767676;
                    -ms-box-shadow: 2px 2px 7px -3px #767676;
                     -o-box-shadow: 2px 2px 7px -3px #767676;
                        box-shadow: 2px 2px 7px -3px #767676;
            }
            div#prod #desc {
                width: 240px;
                display: inline-block;
                float: right;
            }
            div#prod #desc span {
                width: 100%;
                display: block;
                margin: 10px 0px;
            }
            div#prod #desc span.price:before {
                content: "Price: ";
                color: blue;
            }
            div#prod #desc span.title {
                font-weight: bold;
                font-size: 16px;
                color: #141414;
                -webkit-text-shadow: 3px 3px 3px #424242;
                   -moz-text-shadow: 3px 3px 3px #424242;
                    -ms-text-shadow: 3px 3px 3px #424242;
                     -o-text-shadow: 3px 3px 3px #424242;
                        text-shadow: 3px 3px 3px #424242;
            }
        </style>
    </head>
    <body id="homeBody">
        <div class="container">
<?php
    $errors  = array();
    try
    {
        $shopify = new Shopify($vendor, $connect);
        if( isset($_POST['title']) )
        {
            $response = $shopify->addItem($errors);
            echo '
            <div id="prodBox">
                <span class="success"><b>Item was updated.</b></span>
                <div id="prod" class="product">
                    <div id="desc" class="description">
                        <span id="tit" class="title">'.$response['product']['title'].'</span>
                        <span id="pr" class="price">'.$response['product']['variants'][0]['price'].'</span>
                    </div>
                </div>
            </div>';
            $_POST = array();
        }
    } // try end
    catch (ShopifyException $ex)
    {
        echo '<span class="error"><b>error: </b>'.$ex->__toString().'</span>';
    } // catch (ShopifyException $ex) end
?>
            <form action="<?=$wwwBaseDir; ?>/index.php" method="post">
                <?php
                foreach($shopify->arrItem as $key => $tag)
                {
                    switch($tag)
                    {
                        case 'text':
                            ?>
                <div<?=(isset($errors[$key])?' class="error"':'');?>>
                    <label for="item_<?=$key;?>"><?=$key;?>
                        <input type="text" id="item_<?=$key;?>" name="<?=$key;?>" value="<?php
                            if( isset($_POST[$key]) )
                            {
                                echo str_replace('"', '\"', $_POST[$key]);
                            }
                        ?>" />
                    </label>
                    <?=(isset($errors[$key])?'<span>'.implode('<br/>',$errors[$key]).'</span>':'');?>
                </div>
                            <?php
                            break;
                            // case 'text': end
                        case 'textarea':
                            ?>
                <div<?=(isset($errors[$key])?' class="error"':'');?>>
                    <label for="item_<?=$key;?>"><?=$key;?>
                        <textarea id="item_<?=$key;?>" name="<?=$key;?>"><?php
                            if( isset($_POST[$key]) )
                            {
                                echo $_POST[$key];
                            }
                        ?></textarea>
                    </label>
                    <?=(isset($errors[$key])?'<span>'.implode('<br/>',$errors[$key]).'</span>':'');?>
                </div>
                            <?php
                            break;
                            // case 'textarea': end
                        case 'checkbox':
                            ?>
                <div<?=(isset($errors[$key])?' class="error"':'');?>>
                    <label for="item_<?=$key;?>"><?=$key;?>
                        <input type="checkbox" id="item_<?=$key;?>" name="<?=$key;?>" value="1" <?php
                            if( isset($_POST[$key]) )
                            {
                                echo 'checked="checked"';
                            }
                        ?> />
                    </label>
                    <?=(isset($errors[$key])?'<span>'.implode('<br/>',$errors[$key]).'</span>':'');?>
                </div>
                            <?php
                            break;
                            // case 'checkbox': end
                        default :
                            if( is_array($tag) )
                            {
                                    ?>
                <div class="block">
                                    <?php
                                foreach($tag as $subKey => $subTag)
                                {
                                    ?>
                    <div<?=(isset($errors[$subKey])?' class="error"':'');?>>
                        <label for="item_<?=$subKey;?>"><?=$subKey;?>
                            <input type="text" id="item_<?=$subKey;?>" name="<?=$subKey;?>" value="<?php
                            if( isset($_POST[$subKey]) )
                            {
                                echo str_replace('"', '\"', $_POST[$subKey]);
                            }
                        ?>" />
                        </label>
                        <?=(isset($errors[$subKey])?'<span>'.implode('<br/>',$errors[$subKey]).'</span>':'');?>
                    </div>
                                    <?php
                                } // foreach($tag as $subKey => $subTag) end
                                    ?>
                </div>
                                    <?php
                            } // if( is_array($tag) ) end
                            break;
                            // default : end
                    } // switch("$tag") end
                } // foreach($shopify->arrItem as $key => $tag) end
                ?>
                <div>
                    <label for="send_id">
                        <input type="submit" name="send" id="send_id" value="Send" />
                    </label>
                </div>
            </form> <!-- post form // -->
        </div> <!-- end container // -->
    </body>
</html>