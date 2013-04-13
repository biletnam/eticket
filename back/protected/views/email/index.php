
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/email/">Emails</a> <span class="divider">/</span> </li>
    <li class="active">All</li>
</ul>

<legend>All email templates</legend>

<table class="table table-bordered table-striped table-center">
    <thead>
        <tr>         
            
            <th>Title</th>
            <th class="row-action"></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($emails) < 1): ?>
            <tr>
                <td colspan="2" class="align-center">No results found</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($emails as $v): ?>
            <tr>                
                <td style="text-align: left"><a href="<?php echo Yii::app()->request->baseUrl . "/email/edit/id/" . $v['id']; ?>"><?php echo $v['title'] ?></a></td>    
                <td>
                    <a class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl . "/email/edit/id/" . $v['id']; ?>">Edit</a>                    
                </td>


            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
