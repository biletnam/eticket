<div class="row signin">
    <div class="container clearfix">

        <div class="span10 offset1">
            <h1>Mật khẩu mới</h1>
            <div class="row-fluid signin">
                <?php if(!$message['success'] && !$token): ?>
                <div class="span8 signin-form">
                    <h4 style="margin: 0 15px;">Email lấy lại mật khẩu này đã được sử dụng hoặc đã hết hạn. Vui lòng bấm vào <a href="<?php echo Yii::app()->request->baseUrl ?>/user/forgot/">đây</a> để lấy lại mật khẩu một lần nữa</h4>
                </div>
                <?php else:?>
                <div class="span8 signin-form">
                    <?php echo Helper::print_error($message); ?>
                    <?php echo Helper::print_success($message); ?>
                    <form class="form-horizontal clearfix" method="post" action="">                        
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="email">Mật khẩu mới</label>
                                <div class="controls">
                                    <input type="password" class="input-xlarge" name="pwd1" value="">
                                </div>
                            </div>           
                            <div class="control-group">
                                <label class="control-label" for="email">Xác nhận</label>
                                <div class="controls">
                                    <input type="password" class="input-xlarge" name="pwd2" value="">
                                </div>
                            </div>     
                            <input type="submit" class="hide"/>
                            <div class="controls-group">
                                <label class="control-label" >&nbsp;</label>
                                <div class="controls">
                                    <div class="row-fluid">                                    
                                        <a class="btn-style btn-login button-medium btn-submit" href="#">Gửi mật khẩu mới</a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <?php endif;?>
                <div class="span4 signin-contact">
                    Bạn đã có tài khoản chưa? <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/signup">Đăng ký!</a><br/><br/>
                    Nếu bạn vẫn còn thắc mắc về cách sử dụng <b>VeSuKien.vn </b>, đừng ngần ngại gọi đến số <span class="label label-info">0987.999.319</span> để được tư vấn trực tiếp.
                </div>
            </div>
        </div>
    </div>
</div>
