<section class="manage-event">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>

                <th width="220px">TICKET TYPE</th>
                <th>QUANTITY</th>
                <th>FEE</th>
                <th>AMOUNT</th>                
            </tr>
        </thead>
        <tbody>
       
            <?php foreach ($order_details as $t) : ?>
                <tr>
                    <td><?php echo $t['title'] ?></td>
                    <td><?php echo $t['quantity']; ?></td>
                    <td>$<?php echo $t['fee'] ?></td>
                    <td>$<?php echo $t['total']; ?></td>

                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</section>