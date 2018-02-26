<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <style type="text/css">
.control-label{text-align:left !important;}
</style>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-module" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <button type="submit" form="form-module" data-toggle="tooltip" onclick="$('#svsty').val(1);" title="Save & Stay" class="btn btn-primary">Save & Stay</button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
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
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-<?php echo $modname;?>" class="form-horizontal">
          <input type="hidden"  name="svsty" id="svsty" />
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="mkenqpro_status" id="input-status" class="form-control">
                <?php if ($mkenqpro_status) { ?>
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
            <label class="col-sm-2 control-label"><?php echo $entry_btntype; ?></label>
            <div class="col-sm-10">
              <select name="mkenqpro_setting[btntype]" class="form-control">
                <option value="1">-SELECT-</option>
                <option value="1" <?php if(isset($mkenqpro_setting['btntype']) && $mkenqpro_setting['btntype'] == 1) { ?> selected="selected" <?php } ?> ><?php echo $entry_replacewithadc;?></option>
                <option value="2" <?php if(isset($mkenqpro_setting['btntype']) && $mkenqpro_setting['btntype'] == 2) { ?> selected="selected" <?php } ?> ><?php echo $entry_keepboth;?></option>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_captcha_type; ?></label>
            <div class="col-sm-10">
              <select id="captcha_type" name="mkenqpro_setting[captcha_type]" class="form-control" onchange="showgooglekey(this.value);">
                <option value="1">-SELECT-</option>
                <option value="1" <?php if(isset($mkenqpro_setting['captcha_type']) && $mkenqpro_setting['captcha_type'] == 1) { ?> selected="selected" <?php } ?> ><?php echo $entry_captcha_numeric;?></option>
                <option value="2" <?php if(isset($mkenqpro_setting['captcha_type']) && $mkenqpro_setting['captcha_type'] == 2) { ?> selected="selected" <?php } ?> ><?php echo $entry_captcha_google;?></option>
              </select>
            </div>
          </div>
		  <div class="form-group" id="captcha_google_key" style="display:none">
            <label class="col-sm-2 control-label"><?php echo $entry_captcha_google_key; ?></label>
            <div class="col-sm-10">
              <input type="text" name="mkenqpro_setting[captcha_google_key]" value="<?php echo (isset($mkenqpro_setting['captcha_google_key'])) ? $mkenqpro_setting['captcha_google_key'] : ''; ?>" class="form-control" /> 
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_btnhideprodbox; ?></label>
            <div class="col-sm-10">
              <select name="mkenqpro_setting[btnhideprodbox]" class="form-control">
                <?php if ($mkenqpro_setting['btnhideprodbox']) { ?>
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
            <label class="col-sm-2 control-label"><?php echo $entry_btnhideprodpage; ?></label>
            <div class="col-sm-10">
              <select name="mkenqpro_setting[btnhideprodpage]" class="form-control">
                <?php if ($mkenqpro_setting['btnhideprodpage']) { ?>
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
            <label class="col-sm-2 control-label"><?php echo $entry_prodoption; ?></label>
            <div class="col-sm-10">
              <select name="mkenqpro_setting[prodoption]" class="form-control">
                <?php if ($mkenqpro_setting['prodoption']) { ?>
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
            <label class="col-sm-2 control-label"><?php echo $entry_redirectenquiry; ?></label>
            <div class="col-sm-10">
              <select name="mkenqpro_setting[redirectenquiry]" class="form-control">
                <?php if ($mkenqpro_setting['redirectenquiry']) { ?>
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
            <label class="col-sm-2 control-label"><?php echo $entry_popenquiry; ?></label>
            <div class="col-sm-10">
              <select name="mkenqpro_setting[popenquiry]" class="form-control">
                <?php if ($mkenqpro_setting['popenquiry']) { ?>
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
            <label class="col-sm-2 control-label"><?php echo $entry_stockzero; ?></label>
            <div class="col-sm-10">
              <select name="mkenqpro_setting[stockzero]" class="form-control">
                <option value="0">-SELECT-</option>
                <option value="1" <?php if(isset($mkenqpro_setting['stockzero']) && $mkenqpro_setting['stockzero'] == 1) { ?> selected="selected" <?php } ?> ><?php echo $text_enabled;?></option>
                <option value="0" <?php if(isset($mkenqpro_setting['stockzero']) && $mkenqpro_setting['stockzero'] == 0) { ?> selected="selected" <?php } ?> ><?php echo $text_disabled;?></option>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_pricezero; ?></label>
            <div class="col-sm-10">
              <select name="mkenqpro_setting[pricezero]" class="form-control">
                <option value="0">-SELECT-</option>
                <option value="1" <?php if(isset($mkenqpro_setting['pricezero']) && $mkenqpro_setting['pricezero'] == 1) { ?> selected="selected" <?php } ?> ><?php echo $text_enabled;?></option>
                <option value="0" <?php if(isset($mkenqpro_setting['pricezero']) && $mkenqpro_setting['pricezero'] == 0) { ?> selected="selected" <?php } ?> ><?php echo $text_disabled;?></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name_label"><?php echo $entry_btntext;?></label>
            <div class="col-sm-10">
            <?php foreach ($languages as $language) { ?>
            <div class="input-group"><span class="input-group-addon"><img src="<?php echo $language['imgsrc'];?>" title="<?php echo $language['name'];?>"></span>
              <input type="text" name="mkenqpro_setting[btntext][<?php echo $language['language_id'];?>]" placeholder="<?php echo $entry_btntext;?>" class="form-control" value="<?php echo $mkenqpro_setting['btntext'][$language['language_id']];?>" /></div>
              <?php } ?>
            </div>
          </div>
          
		  <div class="form-group col-sm-4">
            <label class="col-sm-12 control-label" for="input-product"><?php echo $entry_product; ?></label>
            <div class="col-sm-12">
              <input type="text" name="mkenqpro_setting[product]" value="" id="input-product" class="form-control" />
              <div id="mkenqpro-product" class="well well-sm" style="height: 150px; overflow: auto;">
                <?php if($mkenqpro_setting['product']) { foreach ($mkenqpro_setting['product'] as $product) { ?>
                <div id="mkenqpro-product<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
                  <input type="hidden" name="mkenqpro_setting[product][]" value="<?php echo $product['product_id']; ?>" />
                </div>
                <?php } } ?>
              </div>
            </div>
          </div>
          <div class="form-group col-sm-4">
            <label class="col-sm-12 control-label" for="input-category"><?php echo $entry_category; ?></label>
            <div class="col-sm-12">
              <input type="text" name="mkenqpro_setting[category]" value="" id="input-category" class="form-control" />
              <div id="mkenqpro-category" class="well well-sm" style="height: 150px; overflow: auto;">
                <?php if($mkenqpro_setting['category']) { foreach ($mkenqpro_setting['category'] as $category) { ?>
                <div id="mkenqpro-category<?php echo $category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category['name']; ?>
                  <input type="hidden" name="mkenqpro_setting[category][]" value="<?php echo $category['category_id']; ?>" />
                </div>
                <?php } } ?>
              </div>
            </div>
          </div>
          <div class="form-group col-sm-4">
            <label class="col-sm-12 control-label" for="input-manufacturer"><?php echo $entry_manufacturer; ?></label>
            <div class="col-sm-12">
              <input type="text" name="mkenqpro_setting[manufacturer]" value="" id="input-manufacturer" class="form-control" />
              <div id="mkenqpro-manufacturer" class="well well-sm" style="height: 150px; overflow: auto;">
                <?php if($mkenqpro_setting['manufacturer']) { foreach ($mkenqpro_setting['manufacturer'] as $manufacturer) { ?>
                <div id="mkenqpro-manufacturer<?php echo $manufacturer['manufacturer_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $manufacturer['name']; ?>
                  <input type="hidden" name="mkenqpro_setting[manufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                </div>
                <?php } } ?>
              </div>
            </div>
          </div>
          <div class="form-group col-sm-4">
            <label class="col-sm-12 control-label"><?php echo $entry_store; ?></label>
            <div class="col-sm-12">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <div class="checkbox">
                  <label>
                  <?php if (isset($mkenqpro_setting['store']) && in_array(0, $mkenqpro_setting['store'])) { ?>
                  <input type="checkbox" name="mkenqpro_setting[store][]" value="0" checked="checked" />
                  <?php echo $text_default; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="mkenqpro_setting[store][]" value="0" />
                  <?php echo $text_default; ?>
                  <?php } ?>
                  </label>
                </div>
                <?php foreach ($stores as $store) { ?>
                <div class="checkbox">
                  <label>
                  <?php if (isset($mkenqpro_setting['store']) && in_array($store['store_id'], $mkenqpro_setting['store'])) { ?>
                  <input type="checkbox" name="mkenqpro_setting[store][]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                  <?php echo $store['name']; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="mkenqpro_setting[store][]" value="<?php echo $store['store_id']; ?>" />
                  <?php echo $store['name']; ?>
                  <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-group col-sm-4">
            <label class="col-sm-12 control-label"><?php echo $entry_customer_group; ?></label>
            <div class="col-sm-12">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($customer_group as $cgrp) { ?>
                <div class="checkbox">
                  <label>
                  <?php if (isset($mkenqpro_setting['customer_group']) &&  in_array($cgrp['customer_group_id'], $mkenqpro_setting['customer_group'])) { ?>
                  <input type="checkbox" name="mkenqpro_setting[customer_group][]" value="<?php echo $cgrp['customer_group_id']; ?>" checked="checked" />
                  <?php echo $cgrp['name']; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="mkenqpro_setting[customer_group][]" value="<?php echo $cgrp['customer_group_id']; ?>" />
                  <?php echo $cgrp['name']; ?>
                  <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$( document ).ready(function() {
	$('#captcha_google_key').hide();
    if($('#captcha_type').val() == 2) { 
		$('#captcha_google_key').show();
	}
});
function showgooglekey(selectval) {
	if(selectval == 2) {
		$('#captcha_google_key').show();
	} else {
		$('#captcha_google_key').hide();
	}
}
function loadajaxautocomplete(target) { 
	$('input[name=\'mkenqpro_setting['+target+']\']').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/'+target+'/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {
					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item[''+target+'_id']
						}
					}));
				}
			});
		},
		select: function(item) {
			$('input[name=\'mkenqpro_setting['+target+']\']').val('');
			
			$('#mkenqpro-'+target+'' + item['value']).remove();
			
			$('#mkenqpro-'+target+'').append('<div id="mkenqpro-'+target+'' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="mkenqpro_setting['+target+'][]" value="' + item['value'] + '" /></div>');	
		}
	});
		
	$('#mkenqpro-'+target+'').delegate('.fa-minus-circle', 'click', function() {
		$(this).parent().remove();
	});
}

loadajaxautocomplete('product');
loadajaxautocomplete('category');
loadajaxautocomplete('manufacturer');
//--></script>
<?php echo $footer; ?>