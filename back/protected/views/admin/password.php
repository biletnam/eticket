
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Trang chủ</a> <span class="divider">/</span> </li>    
    <li class="active">Đổi mật khẩu</li>
</ul>
<legend>Đổi mật khẩu</legend>

<?php echo Helper::print_error($message); ?>
<?php echo Helper::print_success($message); ?>

<form class="form-horizontal" method="post">
    <div class="control-group">
        <label class="control-label">Mật khẩu cũ</label>
        <div class="controls">
            <input type="password" name="oldpwd" value="" />
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Mật khẩu mới</label>
        <div class="controls">
            <input type="password" name="newpwd1" value="" />
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Xác nhận</label>
        <div class="controls">
            <input type="password" name="newpwd2" value="" />
        </div>
    </div>

    <div class="form-actions">        
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </div>
</form>

