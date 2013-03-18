<section class="manage-event">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>

                <th width="220px">EVENT</th>
                <th>AMOUNT</th>
                <th>DATE ADDED</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $t) : ?>
                <tr>
                    <td class="text-bold"><a href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $t['event_slug'] ?>"><?php echo $t['event_title'] ?></a></td>

                    <td>$<?php echo $t['total'] ?></td>
                    <td><?php echo date('Y-m-d', $t['date_added']); ?></td>
                    <td>
                        <div>
                            <a class="btn-style btn-primary" href="<?php echo HelperUrl::baseUrl() ?>user/order/id/<?php echo $t['id'] ?>">Detail</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</section>