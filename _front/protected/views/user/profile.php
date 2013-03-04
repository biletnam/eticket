<div class="row">

    <div class="block-header">
        <div class="container">
            <div class="row-fluid">
                <div class="span4">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-large dropdown-toggle">My profile: Unnamed Organizer <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Create a new organizer</a></li>
                        </ul>
                    </div>
                </div>
                <div class="btn-apply clearfix">
                    <button class="pull-right btn btn-large">View profile</button>
                    <a class="btn-style button-medium btn-large" href="#">Save</a>
                </div>
            </div>
        </div>
    </div>

    <article class="container page-profile">
        <form class="form-horizontal">
            <fieldset>

                <section class="module_wrapper">
                    <div class="module_header clearfix">
                        <div class="icon">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/people-icon.png">
                        </div>
                        <div class="title">Manage Organizer Profile</div>
                        <div class="subtitle">Create a single destination for all of your events.</div> 
                    </div>
                    <div id="my_profile" class="module_content">
                        <div class="row-fluid org_section">
                            <div class="name_logo span6">
                                <div class="name">
                                    <h2>Organizer name</h2>
                                    <input type="text" id="input01" class="input-xlarge span11">
                                </div>
                                <div class="logo clearfix">
                                    <h2>Organizer logo</h2>
                                    <div class="logo_inner">
                                        <div class="logo_inner_inner">
                                            <div class="crop">
                                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/default-organizer-logo.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div>Your image must be JPG, GIF, or PNG format and not exceed 1MB. It will be resized to make its width 225px.</div>
                                    <input type="file" id="fileInput" class="input-file">
                                    <button href="#" class="btn btn-upload">Upload</button>
                                </div>
                            </div>
                            <div class="description span6">
                                <h2>About the organizer</h2>
                                <textarea id="mce-description" class="mce-profile-description"></textarea>
                                <label class="checkbox">
                                    <input type="checkbox" value="option1" id="optionsCheckbox">
                                    Also use this description for event pages
                                </label>
                            </div>
                        </div>
                        <div class=" org_section_wrap">
                            <div class="row-fluid org_section">
                                <h2>Optional Organizer settings</h2>
                                <p>Select the information you want to display on this organizer's profile page.</p>
                                <div class="stripe">
                                    <div class="divet"></div>
                                </div>
                                <div class="organizer_info">
                                    <h3>Organizer info:</h3>
                                    <ul class="list-info">
                                        <li>
                                            <label class="checkbox inline">
                                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Show my website
                                            </label>
                                            <div class="block-hide hide">
                                                <div class="input-prepend">
                                                    <span class="add-on">http://</span><input type="text" size="16" id="prependedInput" class="span8">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <label class="checkbox inline">
                                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Show number of events held
                                            </label>
                                        </li>
                                        <li>
                                            <label class="checkbox inline">
                                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Show top event categories
                                            </label>
                                            <div class="block-hide hide">

                                                <select id="select01" class="inline">
                                                    <option>something</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                                <select id="select02" class="inline">
                                                    <option>something</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>

                                            </div>
                                        </li>
                                        <li>
                                            <label class="checkbox inline">
                                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Show top event locations
                                            </label>
                                            <div class="block-hide hide">
                                                <input type="text" placeholder="type to select a city" class="input-medium inline">
                                                <input type="text" placeholder="type to select a city" class="input-medium inline">
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="event_info">

                                    <h3>Event info:</h3>
                                    <ul>
                                        <li>
                                            <label class="radio">
                                                <input type="radio" checked  value="option1" id="optionsRadios1" name="test">
                                                Display only events by this organizer
                                            </label>
                                        </li>
                                        <li>
                                            <label class="radio">
                                                <input type="radio" value="option2" id="optionsRadios2" name="test">
                                                Display all of my events
                                            </label>
                                        </li>
                                    </ul>

                                    <h3>Organizer Page URL:</h3>
                                    <div id="shortname">
                                        <div class="preview show">
                                            <a target="_blank" href="http://www.eventbrite.com/org/2583462528" class="url">http://www.eventbrite.com/org/2583462528</a>
                                            [<a href="javascript:void(0);" class="url_edit">change</a>]
                                            <span></span>
                                        </div>
                                        <div class="edit hide">

                                            <div class="input-prepend input-append" style="width: 445px">
                                                <span class="add-on">http://</span><input type="text"  id="appendedPrependedInput" class="txt-edit-url span6"><span class="add-on">.eventbrite.com</span> [<a href="javascript:void(0);" class="url_cancel">cancel</a>]
                                            </div>
                                            <div class="error"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="org_section_wrap">
                            <div class="row-fluid org_section">
                                <h2>Promote your profile page on your website</h2>
                                <p>Quickly install a button that links to your Eventbrite profile page.</p>
                                <div class="stripe">
                                    <div class="divet"></div>
                                </div>
                                <div id="org_button" class="span5">
                                    <h3>Choose a button</h3>
                                    <ul id="org_button_select" class="clearfix">
                                        <li>
                                            <label for="org_button_small">
                                                <input  checked="checked" type="radio" value="small" name="org_button_size" id="org_button_small">
                                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/eb-icon_small.png">
                                            </label>
                                        </li>
                                        <li>
                                            <label for="org_button_medium">
                                                <input type="radio" value="medium" name="org_button_size" id="org_button_medium">
                                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/eb-icon_medium.png">
                                            </label>
                                        </li>
                                        <li>
                                            <label for="org_button_large">
                                                <input type="radio" value="large" name="org_button_size" id="org_button_large">
                                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/eb-icon_large.png">
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <div id="org_button_copy_code" class="span7">
                                    <p>Copy and paste this code for use on your website</p>
                                    <textarea class="org_button_code"></textarea>
                                    <div id="org_button_copy_wrapper" class="clearfix">
                                        <a href="javascript: void(0);" class="btn-style btn-copy button-medium" id="org_button_copy">Copy to Clipboard</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="module_wrapper">
                    <div class="module_header clearfix">
                        <div class="icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social.png"></div>
                        <div class="title">Add social networks to your profile</div>
                    </div>
                    <div id="communicate" class="module_content">
                        <div class="org_section_wrap">
                            <div class="social clearfix">
                                <h2>Integrate social networking feeds onto my profile page:</h2>

                                <div class="facebook socials">
                                    <label class="checkbox">
                                        <input type="checkbox" value="option1" id="optionsCheckbox">
                                        Add my Facebook page activity feed
                                    </label>
                                    <div class="fb-link hide link">
                                        <div class="input-prepend">
                                            <span class="add-on">http://www.facebook.com/</span><input type="text" size="16" id="prependedInput" class="span2">
                                        </div>
                                    </div>
                                </div>
                                <div class="twitter socials">
                                    <label class="checkbox">
                                        <input type="checkbox" value="option1" id="optionsCheckbox">
                                        Add my Twitter username or search feed
                                    </label>
                                    <div class="twitter-link hide link">
                                        <ul>
                                            <li>
                                                <label class="radio">
                                                    <input checked="checked" type="radio" value="option5" id="optionsRadios5" name="optionsRadios">
                                                    Username
                                                </label>
                                                <div class="block-username show">
                                                    <input type="text" id="input01" class="input-xlarge" placeholder="@">
                                                    <p class="help-block">Please enter a valid Twitter handle.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="radio">
                                                    <input type="radio" value="option6" id="optionsRadios6" name="optionsRadios">
                                                    Search query [<a href="#">Help me</a>]
                                                </label>
                                                <div class="block-username show">
                                                    <input type="text" id="input01" class="input-xlarge" >
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="theme_picker_wrapper" class="module_wrapper">
                    <div class="module_header clearfix">
                        <div class="icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/flower-icon.png"></div>
                        <div class="title">Customize your profile colors</div>
                    </div>
                    <div id="theme_picker" class="module_content">
                        <div class="tabbable">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab1">Choose an Eventbrite template</a></li>
                                <li class=""><a data-toggle="tab" href="#tab2">Choose custom colors / background</a></li>
                                <li class=""><a data-toggle="tab" href="#tab3">Advanced</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <ul class="themes clearfix">
                                    <li class="active">
                                        <p>Classic</p>
                                        <div class="thumb">
                                            <img src="http://placehold.it/97x86"/>
                                        </div>
                                    </li>
                                    <li>
                                        <p>Classic</p>
                                        <div class="thumb">
                                            <img src="http://placehold.it/97x86"/>
                                        </div>
                                    </li>
                                    <li>
                                        <p>Classic</p>
                                        <div class="thumb">
                                            <img src="http://placehold.it/97x86"/>
                                        </div>
                                    </li>
                                    <li>
                                        <p>Classic</p>
                                        <div class="thumb">
                                            <img src="http://placehold.it/97x86"/>
                                        </div>
                                    </li>
                                    <li>
                                        <p>Classic</p>
                                        <div class="thumb">
                                            <img src="http://placehold.it/97x86"/>
                                        </div>
                                    </li>
                                    <li>
                                        <p>Classic</p>
                                        <div class="thumb">
                                            <img src="http://placehold.it/97x86"/>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div id="tab2" class="tab-pane clearfix colors">

                                <ul class="custom_colors clearfix">
                                    <?php $arr_title = array('Background', 'Text', 'Header Text', 'Borders', 'Box Background', 'Header Background', 'Links'); ?>
                                    <?php for ($i = 0; $i < 7; $i++): ?>
                                        <li>
                                            <div class="bg-title"><?php echo $arr_title[$i]; ?></div>
                                            <div class="swatch">                                           
                                                <a class="color color-id-<?php echo $i; ?>" data-toggle="modal" href="#myModal-<?php echo $i ?>" ></a>
                                            </div>

                                            <div class="modal hide fade" id="myModal-<?php echo $i ?>">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                    <h3>Choose Color</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="Inline"></div>
                                                </div>
                                            </div>

                                        </li>
                                    <?php endfor; ?>
                                    <!--
                                    <li>
                                        <div class="bg-title">Background</div>
                                        <div class="swatch swatch_background_color">
                                            <div class="color" style="background: none repeat scroll 0% 0% rgb(255, 255, 255);"></div>
                                             <a class="color" data-toggle="modal" href="#myModal-0" ></a>
                                        </div>
                                       
                                        <div class="modal hide fade" id="myModal-0">
                                            <div class="modal-body">
                                                <div class="Inline"></div>
                                            </div>
                                        </div>

                                    </li>
                                    <li>
                                        <div class="bg-title">Text</div>
                                        <div class="swatch swatch_box_text_color">
                                            <div class="color" style="background: none repeat scroll 0% 0% rgb(0, 0, 0);"></div>
                                            <a class="color" data-toggle="modal" href="#myModal-1" ></a>
                                        </div>
                                        <div class="modal hide fade" id="myModal-1">
                                            <div class="modal-body">
                                                <div class="Inline"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="bg-title">Header Text</div>
                                        <div class="swatch swatch_box_header_text_color"><div class="color" style="background: none repeat scroll 0% 0% rgb(63, 68, 211);"></div></div>
                                    </li>
                                    <li>
                                        <div class="bg-title">Borders</div>
                                        <div class="swatch swatch_box_border_color"><div class="color" style="background: none repeat scroll 0% 0% rgb(213, 213, 211);"></div></div>
                                    </li>
                                    <li>
                                        <div class="bg-title">Box Background</div>
                                        <div class="swatch swatch_box_background_color"><div class="color" style="background: none repeat scroll 0% 0% rgb(255, 255, 255);"></div></div>
                                    </li>
                                    <li>
                                        <div class="bg-title">Header Background</div>
                                        <div class="swatch swatch_box_header_background_color"><div class="color" style="background: none repeat scroll 0% 0% rgb(239, 239, 239);"></div></div>
                                    </li>
                                    <li>
                                        <div class="bg-title">Links</div>
                                        <div class="swatch swatch_link_color"><div class="color" style="background: none repeat scroll 0% 0% rgb(238, 102, 0);"></div></div>
                                    </li>
                                    -->
                                </ul>


                                <div class="preview">
                                    <h3>Preview Window</h3>
                                    <div class="preview_inner preview-background-id-0">
                                        <div class="box background-id-4 border-color-3">
                                            
                                                <h2 class="preview-color-id-2 header-background-id-5">Header Text</h2>
                                                <p class="preview-color-id-1">This is a preview of your profile page colors.<br><br>Selecting a color swatch to the left enables the colors to be changed.<br><br>
                                                    <a class="preview-color-id-6" href="javascript:void(0);">Links »</a>
                                                </p>
                                            
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div id="tab3" class="tab-pane">
                                <div class="advanced">
                                    <h3>Color display options:</h3>
                                    <label class="radio">
                                        <input type="radio" checked="" value="option10" id="optionsRadios10" name="optionsRadios1">
                                        Always apply the selected profile page colors
                                    </label>
                                    <label class="radio">
                                        <input type="radio" value="option11" id="optionsRadios11" name="optionsRadios1">
                                        Apply my event page colors when visiting from an event page
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </fieldset>
        </form>

        <div class="btn-apply clearfix">
            <button class="pull-right btn btn-large">View profile</button>
            <a href="#" class="btn-style button-medium btn-large">Save</a>
        </div>

    </article>
</div>