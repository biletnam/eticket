<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/">User</a> <span class="divider">/</span> </li>
    <li class="active">All</li>
</ul>

<table class="table table-bordered table-striped table-center" id="users">
    <thead>
        <tr>                 
            <th class="row-img"></th>
            <th>Email</th>
            <th>Date Added</th>
            <th style="width:16%"></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($users) < 1): ?>
            <tr>
                <td colspan="4">Result not found.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($users as $v): ?>
            <tr>
                <td><img width="50" class="img-polaroid" src="<?php echo HelperApp::get_thumbnail($v['thumbnail'], 'small') ?>" /></td>
                <td>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/edit/id/<?php echo $v['id'] ?>"><?php echo $v['email'] ?></a>
                    <span class="label label-important label-banned <?php if (!$v['banned']) echo 'hide'; ?>">Banned</span>

                    <?php if ($v['fullname'] != ""): ?>
                        <br/><?php echo $v['fullname']; ?>
                    <?php endif; ?>
                </td>
                <td><?php echo date("d-m-Y H:i", $v['date_added']); ?></td>


                <td class="align-left">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Actions
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="approved" href="<?php echo HelperUrl::baseUrl() . "user/approved/id/" . $v['id'] . '/user/' . $v['email'] . '/approve/client'; ?>">Approved</a></li>
                            <li><a class="approved" href="<?php echo HelperUrl::baseUrl() . "user/approved/id/" . $v['id'] . '/user/' . $v['email'] . '/approve/customer'; ?>">Not Approved</a></li>
                        </ul>
                    </div>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>