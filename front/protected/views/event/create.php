<form id="event_form" enctype="multipart/form-data" method="post" class="form-horizontal form-create-magu">
    <input type="hidden" value="" name="location_id">
    <div class="row-fluid content">
        <div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button><h4>Lỗi!</h4>Tên sự kiện không được để trống.<br>Vui lòng chọn thể loại chính.<br>Địa điểm không được để trống.<br>Địa chỉ không được để trống.<br></div>                                <div class="span10 form-magu">

            <fieldset>
                <div class="step"> <div class="number">1</div>
                    <h3>Thông tin Sự kiện</h3>
                </div>

                <div class="control-group">
                    <label for="title" class="control-label">Tên Sự kiện<div class="required">*</div></label>
                    <div class="controls"><input type="text" value="" name="title" class="input-xlarge span11"></div>
                </div>
                <div class="control-group">
                    <label for="location" class="control-label">Địa điểm<div class="required">*</div></label>
                    <div class="controls">
                        <input type="text" value="" name="location" class="input-xlarge span11" id="add_location">
                        <img src="/vsk_old/front/img/ajax-big-roller.gif" class="loading-location hide">
                    </div>
                </div>
                <div class="control-group">
                    <label for="address" class="control-label">Địa chỉ</label>
                    <div class="controls"><input type="text" value="" name="address" class="input-xlarge span11"></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Thành phố</label>
                    <div class="controls">
                        <select name="city">
                            <option value="Hồ Chí Minh" selected="">Hồ Chí Minh</option>
                            <option value="Hà Nội">Hà Nội</option>
                            <option value="Đà Nẵng">Đà Nẵng</option>
                            <option value="Huế">Huế</option>
                            <option value="Nha Trang">Nha Trang</option>
                            <option value="Đà Lạt">Đà Lạt</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Thời gian<div class="required">*</div></label>
                    <div class="controls">

                        <div class="row-fluid">
                            <p class="start-date-title">Ngày bắt đầu</p>
                            <div data-date-format="mm/dd/yyyy" class="input-append date dp3">
                                <input type="text" value="09-03-2013" name="start_date" class="input-medium ico ico-calendar datetimepicker hasDatepicker" id="dp1362813755129">

                                <select class="input-mini" name="start_hour">
                                    <option value="0" selected="">00</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                </select>
                                <select class="input-mini" name="start_minute">
                                    <option value="0" selected="">00</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>
                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                    <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                    <option value="59">59</option>
                                </select>                                                        
                                <label class="checkbox inline">
                                    <input type="checkbox" value="1" name="display_start_time">
                                    Hiện thời gian
                                </label>
                            </div>

                        </div>

                        <div class="row-fluid">
                            <p class="end-date-title">Ngày kết thúc</p>

                            <div data-date-format="mm/dd/yyyy" class="input-append date dp3">
                                <input type="text" value="09-03-2013" name="end_date" class="input-medium ico ico-calendar datetimepicker hasDatepicker" id="dp1362813755130">

                                <select id="time_hour" class="input-mini" name="end_hour">
                                    <option value="0" selected="">00</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                </select>
                                <select id="time_min" class="input-mini" name="end_minute">
                                    <option value="0" selected="">00</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>
                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                    <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                    <option value="59">59</option>
                                </select>                                                     
                                <label class="checkbox inline">
                                    <input type="checkbox" value="1" name="display_end_time">
                                    Hiện thời gian
                                </label>
                                <label class="checkbox inline">
                                    <input type="checkbox" name="is_repeat" value="1">
                                    Lập lại sự kiện
                                </label>
                            </div>

                        </div>
                    </div>


                </div>

                <div class="control-group upload">
                    <label for="title" class="control-label">Upload hình đại diện</label>
                    <div class="controls">
                        <img src="/vsk_old/front/img/default_upload_logo.gif" class="image-default">
                        <p class="help-block">Hình ảnh định dạng JPG, PNG, GIF phải lơn hơn kích thước 300x300px và dung lượng nhỏ hơn 2MB</p>
                        <input type="file" name="file" class="fileupload customfile-input">
                    </div>
                    <!--
                    <div class="controls"><button class="btn btn-primary" type="button">Upload</button></div> -->
                </div>
                <div class="control-group">
                    <label class="control-label">Nội dung Sự kiện  <!--<label class="control-label add-faq"> <a href="">+Add FAQs</a></label>--></label>
                    <div class="control-group text">
                        <div class="controls">
                            <textarea class="tinymce" name="description" rows="15" cols="150" id="description" style="display: none;" aria-hidden="true">&lt;!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"&gt;
&lt;html&gt;
&lt;head&gt;
&lt;/head&gt;
&lt;body&gt;

&lt;/body&gt;
&lt;/html&gt;</textarea><span role="application" aria-labelledby="description_voice" id="description_parent" class="mceEditor defaultSkin"><span class="mceVoiceLabel" style="display:none;" id="description_voice">Rich Text Area</span><table cellspacing="0" cellpadding="0" role="presentation" id="description_tbl" class="mceLayout" style="width: 710px; height: 297px;"><tbody><tr role="presentation" class="mceFirst"><td class="mceToolbar mceLeft mceFirst mceLast" role="presentation"><div aria-labelledby="description_toolbargroup_voice" role="group" id="description_toolbargroup" tabindex="-1"><span role="application"><span style="display:none;" class="mceVoiceLabel" id="description_toolbargroup_voice">Toolbar</span><table cellspacing="0" cellpadding="0" align="" tabindex="-1" role="presentation" class="mceToolbar mceToolbarRow1 Enabled" id="description_toolbar1" aria-disabled="false" aria-pressed="false"><tbody><tr><td class="mceToolbarStart mceToolbarStartButton mceFirst"><span><!-- IE --></span></td><td style="position: relative"><a title="Bold (Ctrl+B)" aria-labelledby="description_bold_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_bold" href="javascript:;" id="description_bold" role="button" tabindex="-1"><span class="mceIcon mce_bold"></span><span id="description_bold_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Bold (Ctrl+B)</span></a></td><td style="position: relative"><a title="Italic (Ctrl+I)" aria-labelledby="description_italic_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_italic" href="javascript:;" id="description_italic" role="button" tabindex="-1"><span class="mceIcon mce_italic"></span><span id="description_italic_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Italic (Ctrl+I)</span></a></td><td style="position: relative"><a title="Underline (Ctrl+U)" aria-labelledby="description_underline_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_underline" href="javascript:;" id="description_underline" role="button" tabindex="-1"><span class="mceIcon mce_underline"></span><span id="description_underline_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Underline (Ctrl+U)</span></a></td><td style="position: relative"><a title="Strikethrough" aria-labelledby="description_strikethrough_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_strikethrough" href="javascript:;" id="description_strikethrough" role="button" tabindex="-1"><span class="mceIcon mce_strikethrough"></span><span id="description_strikethrough_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Strikethrough</span></a></td><td style="position: relative"><span tabindex="-1" aria-orientation="vertical" role="separator" class="mceSeparator"></span></td><td style="position: relative"><a title="Align Left" aria-labelledby="description_justifyleft_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_justifyleft" href="javascript:;" id="description_justifyleft" role="button" tabindex="-1"><span class="mceIcon mce_justifyleft"></span><span id="description_justifyleft_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Align Left</span></a></td><td style="position: relative"><a title="Align Center" aria-labelledby="description_justifycenter_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_justifycenter" href="javascript:;" id="description_justifycenter" role="button" tabindex="-1"><span class="mceIcon mce_justifycenter"></span><span id="description_justifycenter_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Align Center</span></a></td><td style="position: relative"><a title="Align Right" aria-labelledby="description_justifyright_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_justifyright" href="javascript:;" id="description_justifyright" role="button" tabindex="-1"><span class="mceIcon mce_justifyright"></span><span id="description_justifyright_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Align Right</span></a></td><td style="position: relative"><a title="Align Full" aria-labelledby="description_justifyfull_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_justifyfull" href="javascript:;" id="description_justifyfull" role="button" tabindex="-1"><span class="mceIcon mce_justifyfull"></span><span id="description_justifyfull_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Align Full</span></a></td><td style="position: relative"><span tabindex="-1" aria-orientation="vertical" role="separator" class="mceSeparator"></span></td><td style="position: relative"><span aria-describedby="description_styleselect_voiceDesc" aria-labelledby="description_styleselect_voiceDesc" aria-haspopup="true" role="listbox"><table cellspacing="0" cellpadding="0" class="mceListBox mceListBoxEnabled mce_styleselect" id="description_styleselect" tabindex="-1" role="presentation" aria-valuenow="Styles"><tbody><tr><td class="mceFirst"><span style="display:none;" class="voiceLabel" id="description_styleselect_voiceDesc">Styles</span><a onmousedown="return false;" onclick="return false;" class="mceText mceTitle" href="javascript:;" tabindex="-1" id="description_styleselect_text">Styles</a></td><td class="mceLast"><a onmousedown="return false;" onclick="return false;" class="mceOpen" href="javascript:;" tabindex="-1" id="description_styleselect_open"><span><span aria-hidden="true" class="mceIconOnly" style="display:none;">▼</span></span></a></td></tr></tbody></table></span></td><td style="position: relative"><span aria-describedby="description_formatselect_voiceDesc" aria-labelledby="description_formatselect_voiceDesc" aria-haspopup="true" role="listbox"><table cellspacing="0" cellpadding="0" class="mceListBox mceListBoxEnabled mce_formatselect" id="description_formatselect" tabindex="-1" role="presentation" aria-valuenow="Paragraph"><tbody><tr><td class="mceFirst"><span style="display:none;" class="voiceLabel" id="description_formatselect_voiceDesc">Format - Paragraph</span><a onmousedown="return false;" onclick="return false;" class="mceText" href="javascript:;" tabindex="-1" id="description_formatselect_text">Paragraph</a></td><td class="mceLast"><a onmousedown="return false;" onclick="return false;" class="mceOpen" href="javascript:;" tabindex="-1" id="description_formatselect_open"><span><span aria-hidden="true" class="mceIconOnly" style="display:none;">▼</span></span></a></td></tr></tbody></table></span></td><td class="mceToolbarEnd mceToolbarEndListBox mceLast"><span><!-- IE --></span></td></tr></tbody></table><table cellspacing="0" cellpadding="0" align="" tabindex="-1" role="presentation" class="mceToolbar mceToolbarRow2 Enabled" id="description_toolbar2" aria-disabled="false" aria-pressed="false"><tbody><tr><td class="mceToolbarStart mceToolbarStartButton mceFirst"><span><!-- IE --></span></td><td style="position: relative"><a title="Insert/Remove Bulleted List" aria-labelledby="description_bullist_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_bullist" href="javascript:;" id="description_bullist" role="button" tabindex="-1" aria-pressed="false"><span class="mceIcon mce_bullist"></span><span id="description_bullist_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Insert/Remove Bulleted List</span></a></td><td style="position: relative"><a title="Insert/Remove Numbered List" aria-labelledby="description_numlist_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_numlist" href="javascript:;" id="description_numlist" role="button" tabindex="-1" aria-pressed="false"><span class="mceIcon mce_numlist"></span><span id="description_numlist_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Insert/Remove Numbered List</span></a></td><td style="position: relative"><span tabindex="-1" aria-orientation="vertical" role="separator" class="mceSeparator"></span></td><td style="position: relative"><a title="Decrease Indent" aria-labelledby="description_outdent_voice" onclick="return false;" onmousedown="return false;" class="mceButton mce_outdent mceButtonDisabled" href="javascript:;" id="description_outdent" role="button" tabindex="-1" aria-disabled="true"><span class="mceIcon mce_outdent"></span><span id="description_outdent_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Decrease Indent</span></a></td><td style="position: relative"><a title="Increase Indent" aria-labelledby="description_indent_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_indent" href="javascript:;" id="description_indent" role="button" tabindex="-1"><span class="mceIcon mce_indent"></span><span id="description_indent_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Increase Indent</span></a></td><td style="position: relative"><span tabindex="-1" aria-orientation="vertical" role="separator" class="mceSeparator"></span></td><td style="position: relative"><a title="Undo (Ctrl+Z)" aria-labelledby="description_undo_voice" onclick="return false;" onmousedown="return false;" class="mceButton mce_undo mceButtonDisabled" href="javascript:;" id="description_undo" role="button" tabindex="-1" aria-disabled="true"><span class="mceIcon mce_undo"></span><span id="description_undo_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Undo (Ctrl+Z)</span></a></td><td style="position: relative"><a title="Redo (Ctrl+Y)" aria-labelledby="description_redo_voice" onclick="return false;" onmousedown="return false;" class="mceButton mce_redo mceButtonDisabled" href="javascript:;" id="description_redo" role="button" tabindex="-1" aria-disabled="true"><span class="mceIcon mce_redo"></span><span id="description_redo_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Redo (Ctrl+Y)</span></a></td><td style="position: relative"><span tabindex="-1" aria-orientation="vertical" role="separator" class="mceSeparator"></span></td><td style="position: relative"><a title="Insert/Edit Link" aria-labelledby="description_link_voice" onclick="return false;" onmousedown="return false;" class="mceButton mce_link mceButtonDisabled" href="javascript:;" id="description_link" role="button" tabindex="-1" aria-disabled="true"><span class="mceIcon mce_link"></span><span id="description_link_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Insert/Edit Link</span></a></td><td style="position: relative"><a title="Unlink" aria-labelledby="description_unlink_voice" onclick="return false;" onmousedown="return false;" class="mceButton mce_unlink mceButtonDisabled" href="javascript:;" id="description_unlink" role="button" tabindex="-1" aria-disabled="true"><span class="mceIcon mce_unlink"></span><span id="description_unlink_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Unlink</span></a></td><td style="position: relative"><a title="Insert/Edit Anchor" aria-labelledby="description_anchor_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_anchor" href="javascript:;" id="description_anchor" role="button" tabindex="-1"><span class="mceIcon mce_anchor"></span><span id="description_anchor_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Insert/Edit Anchor</span></a></td><td style="position: relative"><a title="Insert/Edit Image" aria-labelledby="description_image_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_image" href="javascript:;" id="description_image" role="button" tabindex="-1"><span class="mceIcon mce_image"></span><span id="description_image_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Insert/Edit Image</span></a></td><td style="position: relative"><a title="Cleanup Messy Code" aria-labelledby="description_cleanup_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_cleanup" href="javascript:;" id="description_cleanup" role="button" tabindex="-1"><span class="mceIcon mce_cleanup"></span><span id="description_cleanup_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Cleanup Messy Code</span></a></td><td style="position: relative"><a title="Help" aria-labelledby="description_help_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_help" href="javascript:;" id="description_help" role="button" tabindex="-1"><span class="mceIcon mce_help"></span><span id="description_help_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Help</span></a></td><td style="position: relative"><a title="Edit HTML Source" aria-labelledby="description_code_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_code" href="javascript:;" id="description_code" role="button" tabindex="-1"><span class="mceIcon mce_code"></span><span id="description_code_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Edit HTML Source</span></a></td><td class="mceToolbarEnd mceToolbarEndButton mceLast"><span><!-- IE --></span></td></tr></tbody></table><table cellspacing="0" cellpadding="0" align="" tabindex="-1" role="presentation" class="mceToolbar mceToolbarRow3 Enabled" id="description_toolbar3" aria-disabled="false" aria-pressed="false"><tbody><tr><td class="mceToolbarStart mceToolbarStartButton mceFirst"><span><!-- IE --></span></td><td style="position: relative"><a title="Insert Horizontal Line" aria-labelledby="description_hr_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_hr" href="javascript:;" id="description_hr" role="button" tabindex="-1"><span class="mceIcon mce_hr"></span><span id="description_hr_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Insert Horizontal Line</span></a></td><td style="position: relative"><a title="Remove Formatting" aria-labelledby="description_removeformat_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_removeformat" href="javascript:;" id="description_removeformat" role="button" tabindex="-1"><span class="mceIcon mce_removeformat"></span><span id="description_removeformat_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Remove Formatting</span></a></td><td style="position: relative"><a title="show/Hide Guidelines/Invisible Elements" aria-labelledby="description_visualaid_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_visualaid" href="javascript:;" id="description_visualaid" role="button" tabindex="-1" aria-pressed="false"><span class="mceIcon mce_visualaid"></span><span id="description_visualaid_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">show/Hide Guidelines/Invisible Elements</span></a></td><td style="position: relative"><span tabindex="-1" aria-orientation="vertical" role="separator" class="mceSeparator"></span></td><td style="position: relative"><a title="Subscript" aria-labelledby="description_sub_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_sub" href="javascript:;" id="description_sub" role="button" tabindex="-1"><span class="mceIcon mce_sub"></span><span id="description_sub_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Subscript</span></a></td><td style="position: relative"><a title="Superscript" aria-labelledby="description_sup_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_sup" href="javascript:;" id="description_sup" role="button" tabindex="-1"><span class="mceIcon mce_sup"></span><span id="description_sup_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Superscript</span></a></td><td style="position: relative"><span tabindex="-1" aria-orientation="vertical" role="separator" class="mceSeparator"></span></td><td style="position: relative"><a title="Insert Special Character" aria-labelledby="description_charmap_voice" onclick="return false;" onmousedown="return false;" class="mceButton mceButtonEnabled mce_charmap" href="javascript:;" id="description_charmap" role="button" tabindex="-1"><span class="mceIcon mce_charmap"></span><span id="description_charmap_voice" style="display: none;" class="mceVoiceLabel mceIconOnly">Insert Special Character</span></a></td><td class="mceToolbarEnd mceToolbarEndButton mceLast"><span><!-- IE --></span></td></tr></tbody></table></span></div><a onfocus="tinyMCE.getInstanceById('description').focus();" title="Jump to tool buttons - Alt+Q, Jump to editor - Alt-Z, Jump to element path - Alt-X" accesskey="z" href="#"><!-- IE --></a></td></tr><tr><td class="mceIframeContainer mceFirst mceLast"><iframe frameborder="0" id="description_ifr" src="javascript:&quot;&quot;" allowtransparency="true" title="Rich Text AreaPress ALT-F10 for toolbar. Press ALT-0 for help" style="width: 100%; height: 207px; display: block;"></iframe></td></tr><tr class="mceLast"><td class="mceStatusbar mceFirst mceLast"><div id="description_path_row" role="group" aria-labelledby="description_path_voice" tabindex="-1"><span id="description_path_voice">Path</span><span>: </span><span id="description_path"><a href="javascript:;" role="button" onmousedown="return false;" class="mcePath_0" id="_mce_item_4" tabindex="-1">p</a></span></div></td></tr></tbody></table></span>
                        </div>          
                    </div>
                </div>                                        

                <div class="ticket-ridges"></div>

                <div class="step"> 
                    <div class="number">2</div>
                    <h3>Thiết lập</h3>
                </div>

                <div class="control-group">
                    <label class="control-label" for="select01">Cho phép mọi ngườ đăng ký</label>
                    <div class="controls">
                        <select name="published">
                            <option value="1" selected="">Có</option>
                            <option value="0">Không</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Thể loại</label>
                    <div class="controls">
                        <select name="primary_cate">

                            <option value="0">Thể loại chính</option>                                                    

                            <option value="3">Âm nhạc</option>

                            <option value="6">Học Tập</option>

                            <option value="1">Kinh Doanh</option>

                            <option value="4">Mạng máy tính</option>

                            <option value="7">Marketting</option>

                            <option value="5">Phim Ảnh</option>

                            <option value="2">Vui chơi</option>
                        </select>
                        <select name="second_cate">

                            <option value="0">Thể loại phụ</option>                                                    

                            <option value="3">Âm nhạc</option>

                            <option value="6">Học Tập</option>

                            <option value="1">Kinh Doanh</option>

                            <option value="4">Mạng máy tính</option>

                            <option value="7">Marketting</option>

                            <option value="5">Phim Ảnh</option>

                            <option value="2">Vui chơi</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="optionsCheckbox">Số lượng vé còn lại</label>
                    <div class="controls">
                        <label class="checkbox">
                            <input type="checkbox" name="show_tickets" value="1">
                            Hiển thị số lượng vé còn lại trên trang đăng ký vé
                        </label>
                    </div>
                </div>


            </fieldset>

        </div>
    </div>
</form>