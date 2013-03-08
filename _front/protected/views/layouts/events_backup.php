<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>eTicket | eTicket.com | Meet - Exchange - Creative </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
		<meta name="robots" content="noindex, nofollow"/>

        <!-- Le styles -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" rel="stylesheet">
        <?php /* <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" rel="stylesheet"> */ ?>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/event.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/themes/start/jquery.ui.all.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jPicker-1.1.6.min.css" rel="stylesheet">
        
        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo144.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo114.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo72.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo57.png">
        <script type="text/javascript">
            var site_url = '<?php echo Yii::app()->request->baseUrl; ?>' ;
        </script>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-19815313-8']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>

    <body>
        <header>
            <div class="container">
                <div class="row-fluid">
                    <div class="span1">
                        <a class="logo sprite" href="#">logo</a>
                    </div>
                    <div class="host span5">                  
                        Eventbrite Contact the <a href="#">Host</a> for event and ticket information
                    </div>
<!--                    <div class="social pull-right">
                        Social network
                    </div>-->
                </div>
            </div>
        </header>
        <section class="content">
        <?php echo $content; ?>
        </section>
        <footer>
            <section class="container">
                <div class="left">
                    Contact the <a href="#">Host</a> for event and ticket information.
                </div>
                <div class="center">
                    <div>Use Eventbrite for <a href="#">event ticketing</a> and <a href="#">online event registration</a>.</div>
                    <div>&copy; 2012 <a href="#" title="Registration powered by Eventbrite">Eventbrite</a>. All Rights Reserved. <a href="#">Terms of Service</a>. <a href="#">Privacy Policy</a>.
                    </div>
                </div>
                <div class="right">
                    <a class="foot-logo sprite" href="#">footer logo</a>
                </div>
            </section>
        </footer>
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-transition.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-alert.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-modal.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-dropdown.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-scrollspy.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-tab.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-popover.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-button.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-collapse.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-carousel.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-typeahead.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.datepicker.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.8.22.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tiny_mce/tiny_mce.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jpicker-1.1.6.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/scripts.js"></script>
    </body>
</html>