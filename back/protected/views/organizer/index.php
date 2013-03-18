
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/organizer/">Organizers</a> <span class="divider">/</span> </li>
    <li class="active">All</li>
</ul>

<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/paging.php", array('total' => $total, 'paging' => $paging)); ?>
<table class="table table-bordered table-striped table-center">
    <thead>
        <tr>          
            <th class="row-img"></th>
            <th>Title</th>


            <th class="row-action"></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($organizers) < 1): ?>
            <tr>
                <td colspan="6" class="align-center">Result not found</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($organizers as $v): ?>
            <tr>
                <td><img width="50" class="img-polaroid" src="<?php echo HelperApp::get_thumbnail($v['thumbnail'], 'small') ?>" /></td>
                <td style="text-align: left"><a href="<?php echo Yii::app()->request->baseUrl . "/organizer/edit/id/" . $v['id']; ?>"><?php echo $v['title'] ?></a></td>    
                <td>
                    <a class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl . "/organizer/edit/id/" . $v['id']; ?>">Edit</a>
                    <a class="btn btn-small btn-danger delete-row" href="<?php echo Yii::app()->request->baseUrl . "/organizer/delete/id/" . $v['id']; ?>">Delete</a>
                </td>


            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/paging.php", array('total' => $total, 'paging' => $paging)); ?>