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

    <ul class="qrcodes">
        <?php for($i = 0;$i < 5;$i++): ?>
        <?php foreach ($tickets as $v): ?>
            <li>
                <a href="<?php echo HelperUrl::upload_url(); ?>qrcode/<?php echo $v['qrcode']; ?>" title="<?php echo "#" . $v['id']; ?>" class="fancybox" rel="group-ticket"><img src="<?php echo HelperUrl::upload_url(); ?>qrcode/<?php echo $v['qrcode']; ?>" class="img-polaroidg"/></a>
            </li>
        <?php endforeach; ?>
            <?php endfor; ?>
    </ul>
</section>