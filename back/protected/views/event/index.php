
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/">Event</a> <span class="divider">/</span> </li>
    <li class="active">All</li>
</ul>
<!--<p><a href="<?php// echo Yii::app()->request->baseUrl; ?>/event/add/" class="btn btn-primary">Add an new event</a></p> -->
<?php $this->renderFile(Yii::app()->basePath."/views/_shared/paging.php",array('total'=>$total,'paging'=>$paging)); ?>
<table class="table table-bordered table-striped table-center">
    <thead>
        <tr>          
            <th class="row-img"></th>
            <th>Event Title</th>
            <th>Category</th>            
            <th>Location</th>
            <th>Time</th>
   
            <th class="row-action"></th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($events) < 1): ?>
        <tr>
            <td colspan="6" class="align-center">Result not found</td>
        </tr>
        <?php endif;?>
        <?php foreach ($events as $v): ?>
            <tr>
                <td><img width="50" class="img-polaroid" src="<?php echo HelperApp::get_thumbnail($v['thumbnail'],'small') ?>" /></td>
                <td style="text-align: left"><a href="<?php echo Yii::app()->request->baseUrl."/event/edit/id/".$v['id']; ?>"><?php echo $v['title'] ?></a></td>    
                <td>
                    <?php foreach($v['categories'] as $c): ?>
                    <p><a href="<?php echo Yii::app()->request->baseUrl; ?>/category/edit/id/<?php echo $c['id'] ?>"><?php echo $c['title'] ?></a></p>
                    <?php endforeach;?>
                </td>
                <td>
                    <a href="<?php echo Yii::app()->request->baseUrl ?>/location/id/<?php echo $v['location_id'] ?>"><?php echo $v['location'] ?></a><br/>
                    <span class="label label-success"><?php echo $v['city'] ?></span>
                </td>
                <td>
                    <p>Start: <span class="label"><?php echo date('d-m-Y H:i',strtotime($v['start_time'])); ?></span></p>
                    <p>End: <span class="label"><?php echo date('d-m-Y H:i',strtotime($v['end_time'])); ?></span></p>
                </td>
                
               
                
                <td>
                    <a class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl."/event/edit/id/".$v['id']; ?>">Edit</a>
                    <a class="btn btn-small btn-danger delete-row" href="<?php echo Yii::app()->request->baseUrl."/event/delete/id/".$v['id']; ?>">Delete</a>
                </td>
                
                <?php /*
                <td>
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Thao tác
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->request->baseUrl."/category/edit/id/".$v['id']; ?>">Sửa</a></li>
                            <li><a class="delete-row" href="<?php echo Yii::app()->request->baseUrl."/category/delete/id/".$v['id']; ?>">Xóa</a></li>
                        </ul>
                    </div>
                </td> */?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->renderFile(Yii::app()->basePath."/views/_shared/paging.php",array('total'=>$total,'paging'=>$paging)); ?>