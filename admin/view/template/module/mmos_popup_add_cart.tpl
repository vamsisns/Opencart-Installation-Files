<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-popup-add-cart" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><img src="//mmosolution.com/image/mmosolution.com_34.png"> <?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div><br/>
            <div class="panel-body">



                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-popup-add-cart" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-setting" data-toggle="tab"><?php echo $tab_setting; ?></a></li>
                        <li><a href="#supporttabs" data-toggle="tab"><?php echo $tab_support; ?></a></li>
                        <li id="mmos-offer"></li>
                        <li class="pull-right"><a  class="link" href="http://www.opencart.com/index.php?route=extension/extension&filter_username=mmosolution" target="_blank" class="text-success"><img src="//mmosolution.com/image/opencart.gif"> More Extension...</a></li>
                        <li class="pull-right"><a  class="text-link"  href="http://mmosolution.com" target="_blank" class="text-success"><img src="//mmosolution.com/image/mmosolution_20x20.gif">More Extension...</a></li>
                    </ul>
                    <div class="tab-content">

                        <?php if ($stores) { ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-choose-store"><?php echo $text_choose_store; ?></label>
                            <div class="col-sm-10">
                                <select name="select_store_id" onchange="window.location = 'index.php?route=module/mmos_popup_add_cart&token=<?php echo $token; ?>&store_id=' + $(this).val();" id="input-choose-store" class="form-control">
                                    <?php foreach ($stores as $store) { ?>
                                    <option value="<?php echo $store['store_id']; ?>" <?php echo ($store['store_id'] == $current_store_id) ? 'selected' : ''; ?>><?php echo $store['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><br/>
                        <?php } ?>


                        <div class="tab-pane active in" id="tab-setting">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="popup_add_cart[status]" id="input-status" class="form-control">
                                        <?php if (isset($popup_add_cart['status']) && ($popup_add_cart['status'] == 1)) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $entry_product_image_size; ?></label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" name="popup_add_cart[image_width]" value="<?php echo $popup_add_cart['image_width']; ?>" placeholder="<?php echo $text_width; ?>" class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="popup_add_cart[image_height]" value="<?php echo $popup_add_cart['image_height']; ?>" placeholder="<?php echo $text_height; ?>" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $entry_popup_size; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="popup_add_cart[popup_width]" value="<?php echo $popup_add_cart['popup_width']; ?>" placeholder="<?php echo $text_width; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $entry_popup_background_color; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="popup_add_cart[popup_background_color]" value="<?php echo $popup_add_cart['popup_background_color'];?>" placeholder="<?php echo $entry_popup_background_color; ?>" class="form-control colorpicker" />
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="define-button" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $entry_btn_define; ?>
                                                <p class="help"><?php echo $entry_btn_define_help; ?> <img src="view/image/button_defaul_bootstrap_style.png"></p>
                                                <p class="help"><?php echo $how_to_setup_icon; ?></p>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $button_define_row = 0; ?>
                                        <?php foreach($popup_add_cart['button'] as $button){ ?>
                                        <tr id="button-define-row<?php echo $button_define_row; ?>">
                                            <td class="text-left">										
                                                <?php foreach ($languages as $language) { ?>
                                                <div class="input-group" style="margin-bottom: 5px"><span class="input-group-addon" style="border-right: 1px solid #cccccc;">
												 <?php if (version_compare(VERSION, '2.1') > 0)  { ?>
												<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
												  <?php } else {  ?>
													<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
												  <?php }   ?>
												</span>
                                                    <div class="row">
                                                        <div class="col-sm-3"><label class="col-sm-2 control-label"><?php echo $text_name;?></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="popup_add_cart[button][<?php echo $button_define_row; ?>][name][<?php echo $language['language_id']; ?>]" value="<?php echo $button['name'][$language['language_id']]; ?>" placeholder="<?php echo $text_link_placeholder; ?>" class="form-control" />
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <label class="col-sm-6 control-label"><?php echo $text_color;?></label>
                                                            <div class="col-sm-6">
                                                                <select class="form-control"  name="popup_add_cart[button][<?php echo $button_define_row; ?>][color][<?php echo $language['language_id']; ?>]" >
                                                                    <option value="default" <?php echo $button['color'][$language['language_id']] == 'default' ? 'selected' : ''; ?>>default</option>
                                                                    <option value="primary" <?php echo $button['color'][$language['language_id']] == 'primary' ? 'selected' : ''; ?> >primary</option>
                                                                    <option value="success" <?php echo $button['color'][$language['language_id']] == 'success' ? 'selected' : ''; ?>>success</option>
                                                                    <option value="info" <?php echo $button['color'][$language['language_id']] == 'info' ? 'selected' : ''; ?>>info</option>
                                                                    <option value="warning" <?php echo $button['color'][$language['language_id']] == 'warning' ? 'selected' : ''; ?>>warning</option>
                                                                    <option value="danger" <?php echo $button['color'][$language['language_id']] == 'danger' ? 'selected' : ''; ?>>danger</option>
                                                                    <option value="link" <?php echo $button['color'][$language['language_id']] == 'link' ? 'selected' : ''; ?>>link</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6"><label class="col-sm-2 control-label"><?php echo $text_link;?></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="popup_add_cart[button][<?php echo $button_define_row; ?>][link][<?php echo $language['language_id']; ?>]" value="<?php echo $button['link'][$language['language_id']]; ?>" placeholder="<?php echo $text_link_placeholder; ?>" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </td>
                                            <td class="text-left"><button type="button" onclick="$('#button-define-row<?php echo $button_define_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $button_define_row++; ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td class="text-right"><button type="button" onclick="addButton();" data-toggle="tooltip" title="<?php echo $entry_btn_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <ul class="nav nav-tabs" id="language">
                                <?php foreach ($languages as $language) { ?>
                                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $language) { ?>
                                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                                    <label class="col-sm-2 control-label"><?php echo $entry_custom_field; ?></label>
                                    <div class="col-sm-10">
                                        <textarea name="popup_add_cart[customer_field][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_custom_field; ?>" id="customer-field<?php echo $language['language_id']; ?>"  class="form-control summernote"><?php echo ($popup_add_cart['customer_field']) ? $popup_add_cart['customer_field'][$language['language_id']] :'<h2><span style="color: rgb(255, 0, 0);">Discount 20% with order greater $50</span></h2>';?></textarea>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="supporttabs">
                            <div class="panel">
                                <div class=" clearfix">
                                    <div class="panel-body">
                                        <h4>About <?php echo $heading_title; ?></h4>
                                        <h5>Installed Version: V.<?php echo $MMOS_version; ?> </h5>
                                        <h5>Latest version: <span id="mmos_latest_version"><a href="http://mmosolution.com/index.php?route=product/search&search=<?php echo trim(strip_tags($heading_title)); ?>" target="_blank">Unknown -- Check</a></span></h5>
                                        <hr>
                                        <h4>About Author</h4>
                                        <div id="contact-infor">
                                            <i class="fa fa-envelope-o"></i> <a href="mailto:support@mmosolution.com?Subject=<?php echo trim(strip_tags($heading_title)).' OC '.VERSION; ?>" target="_top">support@mmosolution.com</a></br>
                                            <i class="fa fa-globe"></i> <a href="http://mmosolution.com" target="_blank">http://mmosolution.com</a> </br>
                                            <i class="fa fa-ticket"></i> <a href="http://mmosolution.com/support/" target="_blank">Open Ticket</a> </br>
                                            <br>
                                            <h4>Our on Social</h4>
                                            <a href="http://www.facebook.com/mmosolution" target="_blank"><i class="fa fa-2x fa-facebook-square"></i></a>
                                            <a class="text-success" href="http://plus.google.com/+Mmosolution" target="_blank"><i class="fa  fa-2x fa-google-plus-square"></i></a>
                                            <a class="text-warning" href="http://mmosolution.com/mmosolution_rss.rss" target="_blank"><i class="fa fa-2x fa-rss-square"></i></a>
                                            <a href="http://twitter.com/mmosolution" target="_blank"><i class="fa fa-2x fa-twitter-square"></i></a>
                                            <a class="text-danger" href="http://www.youtube.com/mmosolution" target="_blank"><i class="fa fa-2x fa-youtube-square"></i></a>
                                        </div>
                                        <div id="relate-products">
                                        </div>
                                    </div>
                                </div>
                            </div>	
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="//mmosolution.com/support.js"></script>
<script type="text/javascript"><!--
$('#language a:first').tab('show');
     $('.colorpicker').colorpicker();
    var productcode = '<?php echo $MMOS_code_id ;?>';
//--></script>
<script type="text/javascript"><!--
var button_define_row = <?php echo $button_define_row; ?> ;
            function addButton() {
                html = '<tr id="button-define-row' + button_define_row + '">';
                html += '<td class="text-left">';
                        <?php foreach ($languages as $language) { ?>
                        html += '<div class="input-group" style="margin-bottom: 5px"><span class="input-group-addon" style="border-right: 1px solid #cccccc;"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language["name"]; ?>" /></span>';
                html += '<div class="row">';
                html += '<div class="col-sm-3"><label class="col-sm-2 control-label"><?php echo $text_name;?></label>';
                html += '<div class="col-sm-10">';
                html += '<input type="text" name="popup_add_cart[button][' + button_define_row + '][name][<?php echo $language["language_id"]; ?>]" value="" placeholder="<?php echo $text_link_placeholder; ?>" class="form-control" />';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-sm-3"><label class="col-sm-6 control-label"><?php echo $text_color;?></label>';
                html += '<div class="col-sm-6">';

                html += '<select class="form-control"  name="popup_add_cart[button][' + button_define_row + '][color][<?php echo $language["language_id"]; ?>]">';
                html += '<option value="default" >default</option>';
                html += '<option value="primary" >primary</option>';
                html += '<option value="success">success</option>';
                html += '<option value="info">info</option>';
                html += '<option value="warning">warning</option>';
                html += '<option value="danger">danger</option>';
                html += '<option value="link">link</option>';
                html += '</select>';

                html += '</div>';
                html += '</div>';
                html += '<div class="col-sm-6"><label class="col-sm-2 control-label"><?php echo $text_link;?></label>';
                html += '<div class="col-sm-10">';
                html += '<input type="text" name="popup_add_cart[button][' + button_define_row + '][link][<?php echo $language["language_id"]; ?>]" value="" placeholder="<?php echo $text_link_placeholder; ?>" class="form-control" />';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                        <?php } ?>
                        html += '</td>';
                html += '<td class="text-left"><button type="button" onclick="$(\'#button-define-row' + button_define_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
                html += '</tr>';
                $('#define-button tbody').append(html);
                button_define_row++;

            }
			

    <?php foreach ($languages as $language) { ?>
            $('#customer-field<?php echo $language['language_id']; ?>').summernote({height: 300});
            <?php } ?>
//--></script>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script> 
<?php echo $footer; ?>