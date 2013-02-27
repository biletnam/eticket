<div class="row signin">
    <div class="container clearfix">
        
        <div class="span10 offset1">
            <h1>Đăng nhập</h1>
            <div class="row-fluid signin">
                <div class="span8 signin-form">
                    <?php echo Helper::print_error($message); ?>
                    <div class="forgot_password clearfix" >
                        <a class="pull-right" href="<?php echo Yii::app()->request->baseUrl ?>/user/forgot/">Quên mật khẩu ?</a>
                    </div>
                    <form class="form-horizontal clearfix" method="post" action="">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="email">Email</label>
                                <div class="controls"><input type="text" class="input-xlarge" name="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="password">Mật khẩu</label>
                                <div class="controls"><input type="password" class="input-xlarge" name="password" id="password" value=""></div>
                            </div>
                            <input type="submit" class="hide"/>
                            <div class="controls-group">
                                <label class="control-label" >&nbsp;</label>
                                <div class="controls">
                                    <div class="row-fluid">
                                    <label class="checkbox inline">
                                        <input type="checkbox" value="remember" id="remember" name="remember">
                                        Ghi nhớ đăng nhập
                                    </label>
                                    <a class="btn-style btn-login button-medium btn-submit" href="#">Đăng nhập</a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="span4 signin-contact">
                    Bạn đã có tài khoản chưa? <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/signup">Đăng ký!</a><br/><br/>
                    Nếu bạn vẫn còn thắc mắc về cách sử dụng <b>VeSuKien.vn </b>, đừng ngần ngại gọi đến số <span class="label label-info">0987.999.319</span> để được tư vấn trực tiếp.
                </div>
            </div>
        </div>
    </div>
</div>
