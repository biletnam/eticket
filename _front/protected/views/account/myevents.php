<div class="row my-events">
    <div class="block-header">
        <div class="container">
            <div class="row-fluid">
                <h2>My Events</h2>
                <div class="sort-event">
                    Filter events by organizer : 
                    <select id="select01">
                        <option>All Events</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <article class="container">
        <section class="row-fluid">
            <section class="span8 main">
                <a href="#" class="btn btn-success btn-create" >Create a New Event</a>
                <div class="events-tab radius-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab1">Section 1</a></li>
                            <li class=""><a data-toggle="tab" href="#tab2">Section 2</a></li>
                            <li class=""><a data-toggle="tab" href="#tab3">Section 3</a></li>
                        </ul>
                        <div style="padding-bottom: 9px; border-bottom: 1px solid #ddd;" class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <p>I'm in Section 1.</p>
                            </div>
                            <div id="tab2" class="tab-pane">
                                <p>Howdy, I'm in Section 2.</p>
                            </div>
                            <div id="tab3" class="tab-pane">
                                <p>What up girl, this is Section 3.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="events-rss radius-body">
                    <div class="rss">
                        Your RSS feed listing all live public events:
                    </div>
                    <a href="#">
                        http://www.eventbrite.com/rss/user_list_events/38183939570
                    </a>
                </div>
            </section>
            <section class="span4 events-sidebar">
                <div class="box radius-body feature">
                    <h4> New Features </h4>
                    <ul>
                        <li><a href="#">Registration terminology</a></li>
                        <li><a href="#">Customize your order form</a></li>
                        <li><a href="#">Group registration</a></li>
                        <li><a href="#">Conditional logic for questions</a></li>
                        <li><a href="#">Sell additional items online</a></li>
                    </ul>
                    <h5>Learn about all the new features we've <a href="#"> recently launched! </a></h5>
                </div>

                <div class="radius-body tab-score">
                    <p>Would you recommend Eventbrite to a friend or a colleague? </p>
                    <div class="score">
                        <form class="frm-score">
                            <div class="choose-rad clearfix">
                                <?php for ($i = 0; $i <= 10; $i++): ?>
                                    <div class="rad">
                                        <div><input type="radio" <?php if ($i == 0) echo 'checked' ?> value="<?php echo $i ?>" name="rad"/></div>
                                        <div><span class="color<?php echo $i ?>"><?php echo $i ?></span></div>
                                    </div> 
                                <?php endfor; ?>
                                <div class="text-color">
                                    <div class="row-fluid">
                                        <div class="span4 left">
                                            No way
                                        </div>
                                        <div class="span4 center">
                                            Neutral
                                        </div>
                                        <div class="span4 right">
                                            Absolutely
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="feedback">
                                <span>What can we do to improve your experience ?</span>
                                <div class="clearfix">
                                    <textarea></textarea>
                                    <a class="btn btn-success btn-save pull-right" href="#">Save</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="box radius-body feature">
                    <h4> We Love Apps!  </h4>
                    <p>We've gathered these apps, resources, and partnerships to make your life easier. </p>
                    <p><a href="#">Check out the Eventbrite App Store »</a></p>
                    <a class="thumb-app" href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/atd-thumb.png"/></a>
                    <p>
                        Capture on-site sales with your iPad. <br/>
                        Introducing <a href="#">Eventbrite At The Door</a>
                    </p>
                    <h5>Eventbrite mobile apps:</h5>
                    <ul>
                        <li><a href="#">Entry Manager for event organizers</a></li>
                        <li><a href="#">Go paperless with the Eventbrite app</a></li>
                    </ul>
                </div>
            </section>
        </section>
    </article>
</div>