<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Trang chủ</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/">Người dùng</a> <span class="divider">/</span> </li>
    <li class="active">Tất cả</li>
</ul>

<table class="table table-bordered table-striped table-center" id="users">
    <thead>
        <tr>                 
            <th class="row-img"></th>
            <th>Email</th>
            <th>Ngày tham gia</th>
            <th style="width:16%"></th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($users) < 1): ?>
        <tr>
            <td colspan="4">Không tìm thấy kết quả nào</td>
        </tr>
        <?php endif;?>
        
        <?php foreach ($users as $v): ?>
            <tr>
                <td><img width="50" class="img-polaroid" src="<?php echo HelperApp::get_thumbnail($v['thumbnail'],'small') ?>" /></td>
                <td>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/edit/id/<?php echo $v['id'] ?>"><?php echo $v['email'] ?></a>
                    <span class="label label-important label-banned <?php if(!$v['banned']) echo 'hide'; ?>">Banned</span>
                    
                    <?php if($v['fullname'] != ""): ?>
                    <br/><?php echo $v['fullname']; ?>
                    <?php endif;?>
                </td>
                <td><?php echo date("d-m-Y H:i", $v['date_added']); ?></td>
                <td>
                    <a class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl ?>/user/edit/id/<?php echo $v['id'] ?>">Sửa</a>
                    <?php if(!$v['banned']): ?>                    
                    <a class="btn btn-small btn-danger ban" href="<?php echo Yii::app()->request->baseUrl ?>/user/ban/id/<?php echo $v['id'] ?>">Ban</a>
                    <a class="btn btn-small btn-warning unban hide" href="<?php echo Yii::app()->request->baseUrl ?>/user/unban/id/<?php echo $v['id'] ?>">Unban</a>
                    <?php else :?>
                    <a class="btn btn-small btn-danger ban hide" href="<?php echo Yii::app()->request->baseUrl ?>/user/ban/id/<?php echo $v['id'] ?>">Ban</a>
                    <a class="btn btn-small btn-warning unban" href="<?php echo Yii::app()->request->baseUrl ?>/user/unban/id/<?php echo $v['id'] ?>">Unban</a>
                    <?php endif;?>
                </td>                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>