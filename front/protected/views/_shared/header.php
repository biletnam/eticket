<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <title>eTicket | eTicket.com | Meet - Exchange - Creative </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="robots" content="noindex, nofollow"/>
        
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo HelperUrl::baseUrl(); ?>css/reset.css" />
        <link rel="stylesheet" href="<?php echo HelperUrl::baseUrl(); ?>css/text.css" />
        <link rel="stylesheet" href="<?php echo HelperUrl::baseUrl(); ?>css/960.css" />
        <link rel="stylesheet" href="<?php echo HelperUrl::baseUrl(); ?>css/style.css" />
        <link href="<?php echo HelperUrl::baseUrl(); ?>/css/themes/start/jquery.ui.all.css" rel="stylesheet"/>
        <link rel="stylesheet" href="<?php echo HelperUrl::baseUrl(); ?>css/flex_slider.css" type="text/css" media="screen" />

        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <!-- Modernizr -->
        <script src="<?php echo HelperUrl::baseUrl(); ?>js/modernizr.js"></script>
        
        <script type="text/javascript">
            var baseUrl = '<?php echo Yii::app()->request->baseUrl; ?>' ;
            var ticketTax = '<?php echo Yii::app()->getParams()->itemAt('ticket_tax'); ?>';
        </script>
    </head>

    <body>
        
        
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="<?php echo Yii::app()->request->baseUrl; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt=""/></a>
            </div>
        </div>
    </div>

        <div id="wrapper">
            <header class="header">
                <div class="container_12 background-header">
                    <div class="clearfix">
                        <div class="grid_3">
                            <a class="logo" href="<?php echo HelperUrl::baseUrl() ?>">&nbsp;</a>
                        </div>
                        <div class="grid_8">
                            <nav class="menu">
                                <ul class="clearfix">
                                    <li><a href="#">Find Events</a></li>
                                    <li><a href="#">Print Tickets</a></li>
                                    <li><a href="<?php echo HelperUrl::baseUrl() ?>event/create">Create An Event</a></li>
                                    <li><a href="#">How It Works</a></li>
                                    <li class="last"><a href="#">Help</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="grid_1">
                            <a class="header-logo-fb" href="#">
                                <img src="<?php echo HelperUrl::baseUrl() ?>img/fb_header.png"/>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
