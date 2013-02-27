<?php $category_types = Helper::category_types(); ?>
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/category/">Category</a> <span class="divider">/</span> </li>
    <li class="active">All</li>
</ul>
<p><a href="<?php echo Yii::app()->request->baseUrl; ?>/category/add/" class="btn btn-primary">Add a new category</a></p>
<br/>
<p>
    <span>Type:</span>
    <select class="span2 category-type" style="margin: 0">
        <option value="all">All</option>
        <?php foreach(Helper::category_types() as $k=>$v): ?>
        <option <?php if($k == $type) echo 'selected'; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
        <?php endforeach;?>
    </select>
</p>

<?php $this->renderFile(Yii::app()->basePath."/views/_shared/paging.php",array('total'=>$total,'paging'=>$paging)); ?>
<table class="table table-bordered table-striped table-center category">
    <thead>
        <tr>          
            <th class="row-img"></th>
            <th>Category Title</th>
            <th>Type</th>
            <th class="row-action"></th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($categories) < 1): ?>
        <tr>
            <td colspan="4" class="align-center">Result not found</td>
        </tr>
        <?php endif;?>
        <?php foreach ($categories as $v): ?>
            <tr>
                <td><img width="50" class="img-polaroid" src="<?php echo HelperApp::get_thumbnail($v['thumbnail'],'small') ?>" /></td>
                <td>
                    <a href="<?php echo Yii::app()->request->baseUrl."/category/edit/id/".$v['id']; ?>"><?php echo $v['title'] ?></a>
                    <?php if($v['featured']): ?>
                    <span class="label label-important">Feature</span>
                    <?php endif;?>
                </td>    
                <td><?php echo $category_types[$v['type']]; ?></td>
                <td>
                    <a class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl."/category/edit/id/".$v['id']; ?>">Edit</a>
                    <a class="btn btn-small btn-danger delete-row" href="<?php echo Yii::app()->request->baseUrl."/category/delete/id/".$v['id']; ?>">Delete</a>
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