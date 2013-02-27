<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Trang chủ</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/">Ban quản trị</a> <span class="divider">/</span> </li>
    <li class="active">Tất cả</li>
</ul>

<table class="table table-bordered table-striped table-center">
    <thead>
        <tr>
            <th class="row-id">#</th>            
            <th>Tài khoản</th>
            <th>Ngày tham gia</th>
            <th>Nhóm quyền</th>
            <th class="row-action"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($admins as $v): ?>
            <tr>
                <td><?php echo $v['id'] ?></td>
                <td><a href="#"><?php echo $v['title'] ?></a></td>
                <td><?php echo date("d-m-Y", $v['date_added']); ?></td>
                <td><?php echo $v['role'] ?></td>
                <td>
                    <a class="btn btn-small btn-info" href="#">Sửa</a>
                    <a class="btn btn-small btn-danger delete-row" href="#">Xóa</a>
                </td>                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>