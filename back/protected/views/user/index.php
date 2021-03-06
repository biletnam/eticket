<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/">User</a> <span class="divider">/</span> </li>
    <li class="active"><?php echo $role?></li>
</ul>
<br/>
<?php /*
<p>
    <span>Type:</span>
    <select class="span2 user-type" style="margin: 0">
        <option value="all">All</option>
       
        <option  value="customer" <?php echo ($role == 'customer')?  'selected' : '' ?>>Customer</option>
        <option  value="client" <?php echo ($role == 'client')?  'selected' : '' ?>>Client</option>
        
    </select>
</p> */?>
<table class="table table-bordered table-striped table-center" id="users">
    <thead>
        <tr>                 
            <th class="row-img"></th>
            <th>Email</th>
            <th>Date Added</th>
            <th style="width:25%"></th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($users) < 1): ?>
        <tr>
            <td colspan="4">Result not found.</td>
        </tr>
        <?php endif;?>
        
        <?php foreach ($users as $v): ?>
            <tr>
                <td><img width="50" class="img-polaroid" src="<?php echo HelperApp::get_thumbnail($v['thumbnail'],'small') ?>" /></td>
                <td>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/edit/id/<?php echo $v['id'] ?>"><?php echo $v['email'] ?></a>
                    <span class="label label-important label-banned <?php if(!$v['banned']) echo 'hide'; ?>">Banned</span>
                    
                    <?php if($v['firstname'] != ""): ?>
                    <br/><?php echo $v['firstname'].' '.$v['lastname']; ?>
                    <?php endif;?>
                </td>
                <td><?php echo date("d-m-Y H:i", $v['date_added']); ?></td>
                <td>
                    <a class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl ?>/user/edit/id/<?php echo $v['id'] ?>">Edit</a>
                    <?php if(!$v['banned']): ?>                    
                    <a class="btn btn-small btn-danger ban" href="<?php echo Yii::app()->request->baseUrl ?>/user/ban/id/<?php echo $v['id'] ?>">Lock</a>
                    <a class="btn btn-small btn-warning unban hide" href="<?php echo Yii::app()->request->baseUrl ?>/user/unban/id/<?php echo $v['id'] ?>">Unlock</a>
                    <?php else :?>
                    <a class="btn btn-small btn-danger ban hide" href="<?php echo Yii::app()->request->baseUrl ?>/user/ban/id/<?php echo $v['id'] ?>">Lock</a>
                    <a class="btn btn-small btn-warning unban" href="<?php echo Yii::app()->request->baseUrl ?>/user/unban/id/<?php echo $v['id'] ?>">Unlock</a>
                    <?php endif;?>
                     <a class="delete-row btn btn-small btn-danger" href="<?php echo HelperUrl::baseUrl() . "user/delete/id/" . $v['id']; ?>">Delete</a>
                </td>                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>