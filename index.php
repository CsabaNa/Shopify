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
        <!-- Bootstrap styles -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
        <!-- Generic page styles -->
        <link rel="stylesheet" href="css/style.css" />
        <!-- blueimp Gallery styles -->
        <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css" />
        <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
        <link rel="stylesheet" href="css/jquery.fileupload.css" />
        <link rel="stylesheet" href="css/jquery.fileupload-ui.css" />
        <!-- CSS adjustments for browsers with JavaScript disabled -->
        <noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css" /></noscript>
        <noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css" /></noscript>
        <style>
            label {
                width: 400px;
                text-align: right;
            }
            label textarea,
            label input {
                width: 250px;
                text-align: left;
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
            .bar {
                height: 18px;
                background: green;
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
                    <span class="img">
                        <img src="'.$response['product']['images'][0]['src'].'" title="'.str_replace('"', '&#34;', $response['product']['title']).'" alt="'.str_replace('"', '&#34;', $response['product']['title']).'" />
                    </span>
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
            <form id="fileupload" action="<?=$wwwBaseDir; ?>/index.php" method="post" enctype="multipart/form-data">
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

                <div class="row fileupload-buttonbar">
                    <div class="col-lg-7">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Add files...</span>
                            <input type="file" name="files[]" multiple="multiple" />
                        </span>
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>

                <div>
                    <label for="send_id">
                        <input type="submit" name="send" id="send_id" value="Send" />
                    </label>
                </div>
            </form> <!-- post form // -->
        </div> <!-- end container // -->

        <script id="template-upload" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
                <tr class="template-upload fade">
                    <td>
                        <span class="preview"></span>
                    </td>
                    <td>
                        <p class="name">{%=file.name%}</p>
                        <strong class="error text-danger"></strong>
                    </td>
                    <td>
                        <p class="size">Processing...</p>
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                    </td>
                    <td>
                        {% if (!i && !o.options.autoUpload) { %}
                            <button class="btn btn-primary start" disabled>
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Start</span>
                            </button>
                        {% } %}
                    </td>
                </tr>
            {% } %}
        </script>
        <!-- The template to display files available for download -->
        <script id="template-download" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
                <tr class="template-download fade">
                    <td>
                        <span class="preview">
                            {% if (file.thumbnailUrl) { %}
                                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                            {% } %}
                        </span>
                    </td>
                    <td>
                        <p class="name">
                            {% if (file.url) { %}
                                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                            {% } else { %}
                                <span>{%=file.name%}</span>
                            {% } %}
                        <input type="hidden" name="images[]" value="{%=file.url%}"/>
                        </p>
                        {% if (file.error) { %}
                            <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                        {% } %}
                    </td>
                    <td>
                        <span class="size">{%=o.formatFileSize(file.size)%}</span>
                    </td>
                    <td>
                        {% if (file.deleteUrl) { %}
                            <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                <i class="glyphicon glyphicon-trash"></i>
                                <span>Delete</span>
                            </button>
                            <input type="checkbox" name="delete" value="1" class="toggle">
                        {% } else { %}
                            <button class="btn btn-warning cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span>Cancel</span>
                            </button>
                        {% } %}
                    </td>
                </tr>
            {% } %}
        </script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
        <script src="js/vendor/jquery.ui.widget.js"></script>
        <!-- The Templates plugin is included to render the upload/download listings -->
        <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
        <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
        <!-- The Canvas to Blob plugin is included for image resizing functionality -->
        <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
        <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- blueimp Gallery script -->
        <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
        <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        <script src="js/jquery.iframe-transport.js"></script>
        <!-- The basic File Upload plugin -->
        <script src="js/jquery.fileupload.js"></script>
        <!-- The File Upload processing plugin -->
        <script src="js/jquery.fileupload-process.js"></script>
        <!-- The File Upload image preview & resize plugin -->
        <script src="js/jquery.fileupload-image.js"></script>
        <!-- The File Upload audio preview plugin -->
        <script src="js/jquery.fileupload-audio.js"></script>
        <!-- The File Upload video preview plugin -->
        <script src="js/jquery.fileupload-video.js"></script>
        <!-- The File Upload validation plugin -->
        <script src="js/jquery.fileupload-validate.js"></script>
        <!-- The File Upload user interface plugin -->
        <script src="js/jquery.fileupload-ui.js"></script>
        <!-- The main application script -->
        <script src="js/main.js"></script>
        <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
        <!--[if (gte IE 8)&(lt IE 10)]>
        <script src="js/cors/jquery.xdr-transport.js"></script>
        <![endif]-->
    </body>
</html>