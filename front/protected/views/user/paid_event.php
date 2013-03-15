<section class="manage-event">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="220px">TICKET</th>
                <th width="220px">EVENT</th>
                <th>QUANTITY</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ticket_paids as $t) :?>
            <tr>
                <td><a href="#"><?php echo $t['ticket_type_name']?></a></td>
                <td class="text-bold"><a href="#"><?php echo $t['event_name']?></a></td>
                <td><?php echo $t['total_ticket']?></td>
                <td>
                    <div>
                        <a class="btn-style btn-primary" href="#">Detail</a>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
            
        </tbody>
    </table>
</section>