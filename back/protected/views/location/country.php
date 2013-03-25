
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/location/city">City</a> <span class="divider">/</span> </li>
    <li class="active">All</li>
</ul>
<p><a href="<?php echo Yii::app()->request->baseUrl; ?>/location/add_city/" class="btn btn-primary">Add City</a></p> 
<?php $this->renderFile(Yii::app()->basePath."/views/_shared/paging.php",array('total'=>$total,'paging'=>$paging)); ?>
<table class="table table-bordered table-striped table-center">
    <thead>
        <tr>          
            
            <th>Title</th>
         
            
            <th class="row-action"></th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($cities) < 1): ?>
        <tr>
            <td colspan="6" class="align-center">Result not found</td>
        </tr>
        <?php endif;?>
        <?php foreach ($cities as $v): ?>
            <tr>
               
                <td style="text-align: left"><a href="<?php echo Yii::app()->request->baseUrl."/location/edit_city/id/".$v['id']; ?>"><?php echo $v['title'] ?></a></td>    
              
           
      
                
               
                
                <td>
                    <a class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl."/location/edit_city/id/".$v['id']; ?>">Edit</a>
                    <a class="btn btn-small btn-danger delete-row" href="<?php echo Yii::app()->request->baseUrl."/location/delete_city/id/".$v['id']; ?>">Delete</a>
                </td>
                
         
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->renderFile(Yii::app()->basePath."/views/_shared/paging.php",array('total'=>$total,'paging'=>$paging)); ?>