
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Trang chủ</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/">Người dùng</a> <span class="divider">/</span> </li>
    <li class="active">Sửa <span class="divider">/</span> </li>
    <li class="active"><?php echo $user['email'] ?></li>
</ul>
<legend>Sửa người dùng: <?php echo $user['email'] ?></legend>

<?php echo Helper::print_error($message); ?>
<?php echo Helper::print_success($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <img class="img-polaroid" width="80" src="<?php echo HelperApp::get_thumbnail($user['thumbnail']); ?>" />
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Email</label>
        <div class="controls">
            <input type="text" name="title" disabled class="disabled input-xlarge" value="<?php echo $user['email']; ?>">
            <p class="help-block">Ngày tham gia: <?php echo date('d-m-Y H:i:s',$user['date_added']); ?></p>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Họ tên</label>
        <div class="controls">
            <input type="text" name="fullname" class=" input-xlarge" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : $user['fullname']; ?>">
        </div>
    </div>
    
    
    
    <div class="control-group">
        <label class="control-label">Ngày sinh</label>
        <div class="controls">
            <select class="input-small" name="day">
                <option value="0" >Ngày</option>
                <?php for($i = 1;$i <= 31;$i++):?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor;?>
            </select>
            <select class="input-small" name="month">
                <option value="0" >Tháng</option>
                <?php for($i = 1;$i <= 12;$i++):?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor;?>
            </select>
            <select class="input-small" name="year">
                <option value="0" >Năm</option>
                <?php for($i = date('Y');$i >= 1950;$i--):?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor;?>
            </select>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Giới tính</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="gender" value="Nam" <?php if(isset($_POST['gender']) && $_POST['gender'] == "Nam") echo 'checked';else if($user['gender'] == "Nam") echo 'checked'; ?>>
                Nam
            </label>
            <label class="radio">
                <input type="radio" name="gender" value="Nữ" <?php if(isset($_POST['gender']) && $_POST['gender'] == "Nữ") echo 'checked';else if($user['gender'] == "Nữ") echo 'checked'; ?>>
                Nữ
            </label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Điện thoại nhà</label>
        <div class="controls">
            <input type="text" name="home_phone" class=" input-xlarge" value="<?php echo isset($_POST['home_phone']) ? htmlspecialchars($_POST['home_phone']) : $user['home_phone']; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Điện thoại di động</label>
        <div class="controls">
            <input type="text" name="cell_phone" class=" input-xlarge" value="<?php echo isset($_POST['cell_phone']) ? htmlspecialchars($_POST['cell_phone']) : $user['cell_phone']; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tài khoản Paypal</label>
        <div class="controls">
            <input type="text" name="paypal_account" class=" input-xlarge" value="<?php echo isset($_POST['paypal_account']) ? htmlspecialchars($_POST['paypal_account']) : $user['paypal_account']; ?>">
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Ban</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="banned" value="0" <?php if(isset($_POST['banned']) && !$_POST['banned']) echo 'checked';else if(!$user['banned']) echo 'checked'; ?>>
                Không
            </label>
            <label class="radio">
                <input type="radio" name="banned" value="1" <?php if(isset($_POST['banned']) && $_POST['banned']) echo 'checked';else if($user['banned']) echo 'checked'; ?>>
                Có
            </label>
        </div>
    </div>

    <div class="form-actions">        
        <button type="submit" class="btn btn-primary">Sửa</button>
    </div>
</form>

