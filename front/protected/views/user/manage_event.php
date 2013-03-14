
<section class="manage-event">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="180px">EVENT NAME</th>
                <th>DATE</th>
                <th>STATUS</th>
                <th>SOLD</th>
                <th>QUICK LINKS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $e): ?>
            <tr>
                <td class="text-bold"> <a href="#"><?php echo $e['title']?> </a></td>
                <td><?php echo date('M j, Y',strtotime($e['start_time']))?></td>
                <td>Live</td>
                <td>2/20</td>
                <td>
                    <div>
                        <a class="btn-style btn-primary" href="<?php echo HelperUrl::baseUrl()?>event/edit/id/<?php echo $e['id']?>"> Edit </a>
                        <a class="btn-style" href="#">View</a>
                        <a class="btn-style" href="#">Invite</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td class="text-bold"><a href="#">Holiday summer event</a></td>
                <td>Apr 18, 2013</td>
                <td>Live</td>
                <td>2/20</td>
                <td>
                    <div>
                        <a class="btn-style btn-primary" href="#">Edit</a>
                        <a class="btn-style" href="#">View</a>
                        <a class="btn-style" href="#">Invite</a>
                    </div>
                </td>
            </tr>
           
        </tbody>
    </table>
</section>
