<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Vé Sự Kiện | VeSuKien.vn | Gặp gỡ - Giao lưu - Sáng tạo</title>
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
        
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/libs.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/themes/start/jquery.ui.all.css" rel="stylesheet">
                <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/event.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css?v=1" rel="stylesheet">
        
        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo144.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo114.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo72.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo57.png">
        <script type="text/javascript">
            var baseUrl = '<?php echo Yii::app()->request->baseUrl; ?>' ;
            var ticketTax = '<?php echo Yii::app()->getParams()->itemAt('ticket_tax'); ?>';
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
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="<?php echo Yii::app()->request->baseUrl; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt=""/></a>
                <div class="nav-collapse pull-right">
                    <ul class="nav">
                        <li class="hotline"><i class="icon-circle-arrow-right icon-white"></i> Gọi 0987.999.319 để được tư vấn trực tiếp</li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>

    <div class="subnav subnav-fixed">
        <div class="container">
            <ul class="nav nav-pills pull-left">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tỉnh / Thành phố <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>/city/ha-noi">Hà Nội</a></li>
                        <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>/city/ho-chi-minh">Hồ Chí Minh</a></li>
                        <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>/city/hai-phong">Hải Phòng</a></li>
                        <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>/city/nha-trang">Nha Trang</a></li>
                        <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>/city/vung-tau">Vũng Tàu</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/search">Tìm Sự Kiện</a></li>
                <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/ticket/print">In Vé</a></li>
                <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/create">Tạo Sự Kiện</a></li>
                <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/info/view/page/help" class="bold">Hướng dẫn sử dụng</a></li>
                <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/faq/">Câu hỏi thường găp</a></li>
            </ul>
            <ul class="nav nav-pills pull-right">
                <?php if(!UserControl::LoggedIn()): ?>
                <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/signup">Đăng ký</a></li>
                <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/signin">Đăng nhập</a></li>
                <?php else:?>
                <li class="dropdown nav-account">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo UserControl::getFullname(); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/profile">Trang cá nhân</a></li>
                        <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/settings">Cài đặt tài khoản</a></li>
                        <li class="divider"></li>
                        <li class=""><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/signout">Thoát</a></li>
                    </ul>
                </li>
                <?php endif;?>
            </ul>
        </div>
    </div>