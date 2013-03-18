
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/">User</a> <span class="divider">/</span> </li>
    <li class="active">Edit <span class="divider">/</span> </li>
    <li class="active"><?php echo $user['email'] ?></li>
</ul>
<legend>Edit a user: <?php echo $user['email'] ?></legend>

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
            <p class="help-block">Date added: <?php echo date('d-m-Y H:i:s',$user['date_added']); ?></p>
        </div>
    </div>
    
    <div class="control-group">
            <label class="control-label">Upload the avatar</label>
            <div class="controls">
                <input type="file" name="file"/>
                <p class="help-block">Must be JPG, GIF, or PNG smaller than 2MB and larger than 300 x 300 px.</p>
            </div>
        </div>
    
    <div class="control-group">
        <label class="control-label">First Name</label>
        <div class="controls">
            <input type="text" name="firstname" class=" input-xlarge" value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : $user['firstname']; ?>">
        </div>
    </div>
    
     <div class="control-group">
        <label class="control-label">Last Name</label>
        <div class="controls">
            <input type="text" name="lastname" class=" input-xlarge" value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : $user['lastname']; ?>">
        </div>
    </div>
    
    
    
 <?php /*   <div class="control-group">
        <label class="control-label">Birth Date</label>
        <div class="controls">
            <select class="input-small" name="day">
                <option value="0" >Day</option>
                <?php for($i = 1;$i <= 31;$i++):?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor;?>
            </select>
            <select class="input-small" name="month">
                <option value="0" >Month</option>
                <?php for($i = 1;$i <= 12;$i++):?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor;?>
            </select>
            <select class="input-small" name="year">
                <option value="0" >Year</option>
                <?php for($i = date('Y');$i >= 1950;$i--):?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor;?>
            </select>
        </div>
    </div>*/?>
    
    <div class="control-group">
        <label class="control-label">Gender</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="gender" value="Male" <?php if(isset($_POST['gender']) && $_POST['gender'] == "Male") echo 'checked';else if($user['gender'] == "Male") echo 'checked'; ?>>
                Male
            </label>
            <label class="radio">
                <input type="radio" name="gender" value="Female" <?php if(isset($_POST['gender']) && $_POST['gender'] == "Female") echo 'checked';else if($user['gender'] == "Female") echo 'checked'; ?>>
                Female
            </label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Home phone</label>
        <div class="controls">
            <input type="text" name="home_phone" class=" input-xlarge" value="<?php echo isset($_POST['home_phone']) ? htmlspecialchars($_POST['home_phone']) : $user['home_phone']; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Cell phone</label>
        <div class="controls">
            <input type="text" name="cell_phone" class=" input-xlarge" value="<?php echo isset($_POST['cell_phone']) ? htmlspecialchars($_POST['cell_phone']) : $user['cell_phone']; ?>">
        </div>
    </div>
  
    
    <div class="control-group">
        <label class="control-label">Lock</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="banned" value="0" <?php if(isset($_POST['banned']) && !$_POST['banned']) echo 'checked';else if(!$user['banned']) echo 'checked'; ?>>
                No
            </label>
            <label class="radio">
                <input type="radio" name="banned" value="1" <?php if(isset($_POST['banned']) && $_POST['banned']) echo 'checked';else if($user['banned']) echo 'checked'; ?>>
                Yes
            </label>
        </div>
    </div>

    <div class="form-actions">        
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

