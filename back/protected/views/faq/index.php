<?php $category_types = Helper::category_types(); ?>
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/faq/">FAQ</a> <span class="divider">/</span> </li>
    <li class="active">All</li>
</ul>
<p><a href="<?php echo Yii::app()->request->baseUrl; ?>/faq/add/" class="btn btn-primary">Add a new FAQ</a></p>
<?php $this->renderFile(Yii::app()->basePath."/views/_shared/paging.php",array('total'=>$total,'paging'=>$paging)); ?>
<table class="table table-bordered table-striped table-center category">
    <thead>
        <tr>          
            <th>FAQ Title</th>
            <th>Type</th>
            <th class="row-action"></th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($faqs) < 1): ?>
        <tr>
            <td colspan="3" class="align-center">Result not found</td>
        </tr>
        <?php endif;?>
        <?php foreach ($faqs as $v): ?>
            <tr>                
                <td><a href="<?php echo Yii::app()->request->baseUrl."/faq/edit/id/".$v['id']; ?>"><?php echo $v['title'] ?></a></td>    
                <td><a href="<?php echo Yii::app()->request->baseUrl."/category/edit/id/".$v['category_id'] ?>"><?php echo $v['category_name'] ?></a></td>
                <td>
                    <a class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl."/faq/edit/id/".$v['id']; ?>">Edit</a>
                    <a class="btn btn-small btn-danger delete-row" href="<?php echo Yii::app()->request->baseUrl."/faq/delete/id/".$v['id']; ?>">Delete</a>
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