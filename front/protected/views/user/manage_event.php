
<section class="manage-event">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="180px">EVENT NAME</th>
                <th>DATE</th>
                <th>STATUS</th>
                <th>Paid</th>
                <th>QUICK LINKS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($events) < 1): ?>
                <tr>
                    <td colspan="5">No events found.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($events as $e): ?>
                <tr>
                    <td class="text-bold">
                        <a href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $e['slug'] ?>"><?php echo $e['title'] ?> </a>
                    </td>
                    <td><?php echo date('M j, Y', strtotime($e['start_time'])) ?></td>
                    <td><?php echo (date('M j, Y', strtotime($e['end_time']))>date('M j, Y') ) ? 'Live' : 'Expired' ;?></td>
                    <td><?php echo ($e['is_paid']) ? 'Paid' : 'Pending' ?></td>
                    <td>
                        <div>
                            <?php if($e['is_paid']): ?>
                            <a class="btn-style btn-primary btn-disabled" href="javascript:void(0);"> Edit </a>
                            <?php else: ?>
                            <a class="btn-style btn-primary" href="<?php echo HelperUrl::baseUrl() ?>event/edit/id/<?php echo $e['id'] ?>"> Edit </a>
                            <?php endif; ?>
                            <a class="btn-style" href="<?php echo HelperUrl::baseUrl() ?>event/info/s/<?php echo $e['slug'] ?>">View</a>
                            <a class="btn-style btn-invite"  href="#invite_<?php echo $e['id'] ?>">Invite</a>
                        </div>
                        <div id="invite_<?php echo $e['id'] ?>" style="display: none">
                            <form class="form-style" method="post">
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Email</label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="email"/>
                                    </div>
                                </div>

                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Subject</label>
                                    <div class="controls pull-left">
                                        <input type="text" class="input-medium" name="subject"/>
                                    </div>
                                </div>

                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">Message</label>
                                    <div class="controls pull-left">
                                        <textarea class="input-medium" name="message"></textarea>
                                    </div>
                                </div>
                                <div class="controls-group clearfix">
                                    <label class="control-label pull-left">&nbsp;</label>
                                    <div class="controls pull-left">
                                        <input type="submit" class="btn" value="Send"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>

        <?php endforeach; ?>


        </tbody>
    </table>
</section>
