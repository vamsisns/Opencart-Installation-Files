<?php
//  Live Price / Живая цена (Динамическое обновление цены)
//  Support: support@liveopencart.com / Поддержка: help@liveopencart.ru
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	
	<div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-liveprice" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $module_name; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
	<div class="container-fluid">
    <?php if (isset($error_warning) && $error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
		
		<?php if (isset($success) && $success) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
		<div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
				
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-settings" data-toggle="tab"><?php echo $entry_settings; ?></a></li>
					<?php if ( !empty($version_pro) ) { ?>
						<li><a href="#tab-customize-discounts" data-toggle="tab" id="tab-customize-discounts-button" style="display: none;"><?php echo $entry_customize_discounts; ?></a></li>
						<li><a href="#tab-discounts" data-toggle="tab" id="tab-discounts-button"><?php echo $entry_discounts; ?></a></li>
						<li><a href="#tab-specials" data-toggle="tab" id="tab-specials-button"><?php echo $entry_specials; ?></a></li>
					<?php } ?>
					<li><a href="#tab-about" data-toggle="tab" id="tab-about-button"><?php echo $entry_about; ?></a></li>
				</ul>
				
				
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-liveprice" class="form-horizontal">
				
				<div class="tab-content">
					
          <div class="tab-pane active" id="tab-settings" style="min-height: 300px;">
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="animation">
								<span data-toggle="tooltip" title="<?php echo $entry_animation_help; ?>">
									<?php echo $entry_animation; ?>
								</span>
							</label>
							<div class="col-sm-10">
								
								<div class="checkbox">
									<label>
										<input type="checkbox" name="liveprice_settings[animation]" id="animation" value="1" <?php if (isset($liveprice_settings['animation']) && $liveprice_settings['animation']) echo "checked"; ?> >
									</label>
								</div>
							
							</div>
						</div>
						
            <div class="form-group">
              <label class="col-sm-2 control-label" for="ignore_cart">
                <span data-toggle="tooltip" title="<?php echo $entry_ignore_cart_help; ?>">
                  <?php echo $entry_ignore_cart; ?>
                </span>
              </label>
              <div class="col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="liveprice_settings[ignore_cart]" id="ignore_cart" value="1" <?php if (isset($liveprice_settings['ignore_cart']) && $liveprice_settings['ignore_cart']) echo "checked"; ?> >
                  </label>
                </div>
              </div>
            </div>
          
            <div class="form-group">
              <label class="col-sm-2 control-label" for="multiplied_price"><?php echo $entry_multiplied_price; ?></label>
              <div class="col-sm-10">
                
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="liveprice_settings[multiplied_price]" id="multiplied_price" value="1" <?php if (isset($liveprice_settings['multiplied_price']) && $liveprice_settings['multiplied_price']) echo "checked"; ?> >
                  </label>
                </div>
              
              </div>
            </div>
						
						<div class="form-group">
              <label class="col-sm-2 control-label" for="ignore_cart">
                <span data-toggle="tooltip" title="<?php echo $entry_hide_tax_help; ?>">
                  <?php echo $entry_hide_tax; ?>
                </span>
              </label>
              <div class="col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="liveprice_settings[hide_tax]" id="hide_tax" value="1" <?php if (isset($liveprice_settings['hide_tax']) && $liveprice_settings['hide_tax']) echo "checked"; ?> >
                  </label>
                </div>
              </div>
            </div>
						
						<div class="form-group">
              <label class="col-sm-2 control-label" for="ropro_discounts_addition">
								<span data-toggle="tooltip" title="<?php echo $text_ropro_discounts_addition_help; ?>">
									<?php echo $entry_ropro_discounts_addition; ?>
								</span>
							</label>
              <div class="col-sm-1">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="liveprice_settings[ropro_discounts_addition]" id="ropro_discounts_addition" value="1" <?php if (!empty($liveprice_settings['ropro_discounts_addition'])) echo "checked"; ?> >
                  </label>
                </div>
							</div>	
							<div class="col-sm-9">	
								<span class="help-block" style="display: none;" data-notify="ropro_discounts_addition"><?php echo $text_relatedoptions_notify; ?></span>
              </div>
            </div>
						
						<div class="form-group">
              <label class="col-sm-2 control-label" for="ropro_specials_addition">
								<span data-toggle="tooltip" title="<?php echo $text_ropro_specials_addition_help; ?>">
									<?php echo $entry_ropro_specials_addition; ?>
								</span>
							</label>
              <div class="col-sm-1">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="liveprice_settings[ropro_specials_addition]" id="ropro_specials_addition" value="1" <?php if (!empty($liveprice_settings['ropro_specials_addition'])) echo "checked"; ?> >
                  </label>
                </div>
							</div>	
							<div class="col-sm-9">	
								<span class="help-block" style="display: none;" data-notify="ropro_specials_addition"><?php echo $text_relatedoptions_notify; ?></span>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label" for="discount_quantity"><?php echo $entry_discount_quantity; ?></label>
              <div class="col-sm-4">
                
                <select id="discount_quantity" name="liveprice_settings[discount_quantity]" class="form-control">
                  <option value="0" <?php if ( isset($liveprice_settings['discount_quantity']) && $liveprice_settings['discount_quantity']==0) echo "selected"; ?> ><?php echo $text_discount_quantity_0; ?></option>
                  <option value="1" <?php if ( isset($liveprice_settings['discount_quantity']) && $liveprice_settings['discount_quantity']==1) echo "selected"; ?> ><?php echo $text_discount_quantity_1; ?></option>
                  <option value="2" <?php if ( isset($liveprice_settings['discount_quantity']) && $liveprice_settings['discount_quantity']==2) echo "selected"; ?> ><?php echo $text_discount_quantity_2; ?></option>
                </select>
                
                <span class="help-block" style="display: none;" data-notify="ro"><?php echo $text_relatedoptions_notify; ?></span>
              
              </div>
							<?php if ( !empty($version_pro) ) { ?>
								<label class="col-sm-2 control-label"><?php echo $entry_customize_discounts; ?></label>
								<div class="col-sm-4">
									<label class="radio-inline">
										<input type="radio" name="liveprice_settings[discount_quantity_customize]" value="1"
											<?php if (!empty($liveprice_settings['discount_quantity_customize'])) echo "checked"; ?>
										><?php echo $text_yes; ?>
									</label>
									<label class="radio-inline">
										<input type="radio" name="liveprice_settings[discount_quantity_customize]" value=""
											<?php if (empty($liveprice_settings['discount_quantity_customize'])) echo "checked"; ?>
										><?php echo $text_no; ?>
									</label>
								</div>
							<?php } ?>
            </div>
            
						<?php if ( !empty($version_pro) ) { ?>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="percent_discount_to_total">
									<span data-toggle="tooltip" title="<?php echo $entry_entry_percent_discount_to_total_help; ?>">
										<?php echo $entry_percent_discount_to_total; ?>
									</span>
								</label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="liveprice_settings[percent_discount_to_total]" id="percent_discount_to_total" value="1" <?php if (isset($liveprice_settings['percent_discount_to_total']) && $liveprice_settings['percent_discount_to_total']) echo "checked"; ?> >
										</label>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="percent_special_to_total">
									<span data-toggle="tooltip" title="<?php echo $entry_entry_percent_special_to_total_help; ?>">
										<?php echo $entry_percent_special_to_total; ?>
									</span>
								</label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="liveprice_settings[percent_special_to_total]" id="percent_special_to_total" value="1" <?php if (isset($liveprice_settings['percent_special_to_total']) && $liveprice_settings['percent_special_to_total']) echo "checked"; ?> >
										</label>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="discount_like_special">
									<span data-toggle="tooltip" title="<?php echo $entry_discount_like_special_help; ?>">
										<?php echo $entry_discount_like_special; ?>
									</span>
								</label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="liveprice_settings[discount_like_special]" id="discount_like_special" value="1" <?php if (isset($liveprice_settings['discount_like_special']) && $liveprice_settings['discount_like_special']) echo "checked"; ?> >
										</label>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="default_price">
									<span data-toggle="tooltip" title="<?php echo $entry_default_price_help; ?>">
										<?php echo $entry_default_price; ?>
									</span>
								</label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="liveprice_settings[default_price]" id="default_price" value="1" <?php if (isset($liveprice_settings['default_price']) && $liveprice_settings['default_price']) echo "checked"; ?> >
										</label>
									</div>
									<span class="help-block" id="default_price_mods" style="display: none;"><?php echo $entry_default_price_mods; ?></span class="help-block">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="starting_from">
									<span data-toggle="tooltip" title="<?php echo $entry_starting_from_help; ?>">
										<?php echo $entry_starting_from; ?>
									</span>
								</label>
								<div class="col-sm-10">
									<select id="starting_from" name="liveprice_settings[starting_from]" class="form-control">
										<option value="0" <?php if ( isset($liveprice_settings['starting_from']) && $liveprice_settings['starting_from']==0) echo "selected"; ?> ><?php echo $text_value_disabled; ?></option>
										<option value="1" <?php if ( isset($liveprice_settings['starting_from']) && $liveprice_settings['starting_from']==1) echo "selected"; ?> ><?php echo $text_value_starting_from_required; ?></option>
										<option value="2" <?php if ( isset($liveprice_settings['starting_from']) && $liveprice_settings['starting_from']==2) echo "selected"; ?> ><?php echo $text_value_starting_from_all; ?></option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="show_from">
									<span data-toggle="tooltip" title="<?php echo htmlspecialchars($entry_show_from_help); ?>">
										<?php echo $entry_show_from; ?>
									</span>
								</label>
								<div class="col-sm-10">
									<select id="show_from" name="liveprice_settings[show_from]" class="form-control">
										<option value="0" <?php if ( isset($liveprice_settings['show_from']) && $liveprice_settings['show_from']==0) echo "selected"; ?> ><?php echo $text_value_disabled; ?></option>
										<option value="1" <?php if ( isset($liveprice_settings['show_from']) && $liveprice_settings['show_from']==1) echo "selected"; ?> ><?php echo $text_value_show_from_min; ?></option>
										<option value="2" <?php if ( isset($liveprice_settings['show_from']) && $liveprice_settings['show_from']==2) echo "selected"; ?> ><?php echo $text_value_show_from_all; ?></option>
									</select>
								</div>
							</div>
						<?php } ?>
							
					</div>
						
					<?php if ( !empty($version_pro) ) { ?>	
						<div class="tab-pane" id="tab-customize-discounts" style="min-height: 300px;">
							
							<div class="row">
								<div class="col-sm-12 text-right">
									<a class="btn btn-primary" id="add_customize_discounts_button" onclick="add_customize_discounts();"><?php echo $entry_add_customize_discounts; ?></a>
								</div>
							</div>
							
						</div>
						
						<div class="tab-pane" id="tab-discounts" style="min-height: 300px;">
							
							<div style="margin-bottom:20px;">
								<?php echo $text_discounts_description; ?>
							</div>
							
							<div class="table-responsive">
								<table id="discount" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_category; ?></td>
											<td class="text-left"><?php echo $entry_manufacturer; ?></td>
											<td class="text-left"><?php echo $entry_customer_group; ?></td>
											<td class="text-right"><?php echo $entry_quantity; ?></td>
											<td class="text-right"><?php echo $entry_priority; ?></td>
											<td class="text-center" colspan="2"><?php echo $entry_price; ?></td>
											<td class="text-left"><?php echo $entry_date_start; ?></td>
											<td class="text-left"><?php echo $entry_date_end; ?></td>
											<td></td>
										</tr>
									</thead>
									
									<tbody></tbody>
									
									<tfoot>
										<tr>
											<td colspan="9"></td>
											<td class="text-left"><button type="button" onclick="addDiscount();" data-toggle="tooltip" title="<?php echo $button_discount_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
							
						</div>
						
						<div class="tab-pane" id="tab-specials" style="min-height: 300px;">
							
							<div style="margin-bottom:20px;">
								<?php echo $text_specials_description; ?>
							</div>
							
							<div class="table-responsive">
								<table id="special" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_category; ?></td>
											<td class="text-left"><?php echo $entry_manufacturer; ?></td>
											<td class="text-left"><?php echo $entry_customer_group; ?></td>
											<td class="text-right"><?php echo $entry_priority; ?></td>
											<td class="text-center" colspan="2"><?php echo $entry_price; ?></td>
											<td class="text-left"><?php echo $entry_date_start; ?></td>
											<td class="text-left"><?php echo $entry_date_end; ?></td>
											<td></td>
										</tr>
									</thead>
									
									<tbody></tbody>
									
									<tfoot>
										<tr>
											<td colspan="8"></td>
											<td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="<?php echo $button_special_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
							
						</div>
					<?php } ?>	
					
					</form>
					
					<div class="tab-pane" id="tab-about" style="min-height: 300px;">
						
						<div id="module_description">
							<?php echo $module_description; ?>
						</div>
						<hr>
						<?php echo $text_conversation; ?>
						<hr>
						<br>
						<h4><?php echo $entry_we_recommend; ?></h4><br>
						<div id="we_recommend">
							<?php echo $text_we_recommend; ?>
						</div>	
						
					</div>
					
				</div>	
				
        <div style="margin-top:40px;">
          <hr>
				<?php echo sprintf($module_info, $module_version); ?><span id="module_page"><?php echo $module_page; ?></span><span class="help-block" style="font-size: 80%; line-height: 130%;"><?php echo $module_copyright; ?></span>
        </div>	
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--

$(document).ready(function(){
	
	$('select[name*="[discount_quantity]"]').change(function(){
		if ( $(this).val() == "2" ) {
			$(this).siblings('[data-notify="ro"]').show();
		} else {
			$(this).siblings('[data-notify="ro"]').hide();
		}
	});
	$('select[name*="[discount_quantity]"]').change();
	
});


//--></script>

<script type="text/javascript"><!--

<?php if ( !empty($version_pro) ) { ?>

	var discount_row = 0;
	var special_row = 0;
	
	function addDiscount(data) {
		discount_row = addDiscountSpecial(data, 'discount', discount_row);
	}
	
	function addSpecial(data) {
		special_row = addDiscountSpecial(data, 'special', special_row);
	}
	
	function addDiscountSpecial(data, name, current_row) {
		html  = '<tr id="'+name+'-row' + current_row + '">';
		
		var manufacturer = data ? data['manufacturer'] : '';
		var manufacturer_id = data ? data['manufacturer_id'] : '';
		var category = data ? data['category'] : '';
		var category_id = data ? data['category_id'] : '';
		var customer_group_id = data ? data['customer_group_id'] : '';
		var quantity = data ? data['quantity'] : '';
		var priority = data ? data['priority'] : '';
		var price_prefix = data ? data['price_prefix'] : '';
		var price = data ? data['price'] : '';
		var date_start = data ? data['date_start'] : '';
		var date_end = data ? data['date_end'] : '';
		
		var setting_name = 'liveprice_settings['+name+'s]['+current_row+']';
		
		html += '  <td class="text-left">';
		html += '    <input type="text" name="'+setting_name+'[category]" value="'+category+'" placeholder="<?php echo $text_category_all; ?>" class="form-control" />';
		html += '    <input type="hidden" name="'+setting_name+'[category_id]" value="'+category_id+'" />';
		html += '  </td>';
		
		html += '  <td class="text-left">';
		html += '    <input type="text" name="'+setting_name+'[manufacturer]" value="'+manufacturer+'" placeholder="<?php echo $text_manufacturer_all; ?>" id="input-manufacturer" class="form-control" />';
		html += '    <input type="hidden" name="'+setting_name+'[manufacturer_id]" value="'+manufacturer_id+'" />';
		html += '  </td>';
		
		html += '  <td class="text-left"><select name="'+setting_name+'[customer_group_id]" class="form-control">';
		html += '    <option value="-1" '+(customer_group_id==-1 ? 'selected':'')+'><?php echo addslashes($liveprice_all_customers_groups); ?></option>';
		<?php foreach ($customer_groups as $customer_group) { ?>
			html += '    <option value="<?php echo $customer_group['customer_group_id']; ?>" '+(customer_group_id==<?php echo $customer_group['customer_group_id']; ?> ? 'selected':'')+'><?php echo addslashes($customer_group['name']); ?></option>';
		<?php } ?>
		html += '  </select></td>';
		if ( name == 'discount' ) {
			html += '  <td class="text-right" style="max-width: 100px"><input type="text" name="'+setting_name+'[quantity]" value="'+quantity+'" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>';
		}
		html += '  <td class="text-right" style="max-width: 100px"><input type="text" name="'+setting_name+'[priority]" value="'+priority+'" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';
		
		html += '  <td class="text-left" style="width: 100px"><select name="'+setting_name+'[price_prefix]" class="form-control" >';
		html += '    <option value="=" '+(price_prefix=='=' ? 'selected':'')+'>=</option>';
		html += '    <option value="%" '+(price_prefix=='%' ? 'selected':'')+'>&minus; %</option>';
		html += '    <option value="_" '+(price_prefix=='_' ? 'selected':'')+'>= %</option>';
		html += '  </select></td>';
		
		html += '  <td class="text-right" style="min-width: 100px; max-width: 150px;"><input type="text" name="'+setting_name+'[price]" value="'+price+'" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
		html += '  <td class="text-left" style="width: 150px;"><div class="input-group date"><input type="text" name="'+setting_name+'[date_start]" value="'+(date_start=='0000-00-00'?'':date_start)+'" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
		html += '  <td class="text-left" style="width: 150px;"><div class="input-group date"><input type="text" name="'+setting_name+'[date_end]" value="'+(date_end=='0000-00-00'?'':date_end)+'" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
		html += '  <td class="text-left"><button type="button" onclick="$(\'#'+name+'-row' + current_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';
	
		$('#'+name+' tbody').append(html);
	
		$('.date').datetimepicker({
			pickTime: false
		});
		
		enableDiscountSpecialAutocomplete(setting_name);
	
		current_row++;
		
		return current_row;
	}
	
	
	
	
	
	<?php
	
		if ( $liveprice_settings && isset($liveprice_settings['discounts']) ) {
			foreach ($liveprice_settings['discounts'] as $discount) {
				echo "addDiscount(".json_encode($discount).");\n";
			}
		}
		
		if ( $liveprice_settings && isset($liveprice_settings['specials']) ) {
			foreach ($liveprice_settings['specials'] as $special) {
				echo "addSpecial(".json_encode($special).");\n";
			}
		}
		
	?>
	
	function enableDiscountSpecialAutocomplete(setting_name) {
	
		// Manufacturer
		$('input[name="'+setting_name+'[manufacturer]"]').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						json.unshift({
							manufacturer_id: -1,
							name: '<?php echo $text_manufacturer_all; ?>'
						});
		
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['manufacturer_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$(this).val( $(this).attr('placeholder') == item['label'] ? '' : item['label']);
				$(this).siblings('[name*="[manufacturer_id]"]').val(item['value']);
			}
		});
		
		// Category
		$('input[name="'+setting_name+'[category]"]').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						
						json.unshift({
							category_id: -1,
							name: '<?php echo $text_category_all; ?>'
						});
						
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['category_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$(this).val( $(this).attr('placeholder') == item['label'] ? '' : item['label']);
				$(this).siblings('[name*="[category_id]"]').val(item['value']);
			}
		});
	}
	
	$('#default_price').change(function(){
		$('#default_price_mods').toggle( $('#default_price').is(':checked') );
	});
	$('#default_price').change();
	
	$('[name="liveprice_settings[discount_quantity_customize]"]').change(function(){
		if ( $('[name="liveprice_settings[discount_quantity_customize]"][value="1"]:checked').length ) {
			$('#tab-customize-discounts-button').show();
			//$('#tab-customize-discounts').show();
		} else {
			$('#tab-customize-discounts-button').hide();
			//$('#tab-customize-discounts').hide();
		}
	});
	$('[name="liveprice_settings[discount_quantity_customize]"]').change();
	
	var customize_discounts_cnt = 0;
	
	function add_customize_discounts_html_elem(customize_discounts_cnt, block, name, id) {
		var html = '';
		html+= '<div ><i class="fa fa-minus-circle"></i> '+name;
		html+= '<input type="hidden" name="liveprice_settings[dqc]['+customize_discounts_cnt+']['+block+'][]" value="'+id+'" />';
		html+= '</div>';
		return html;
	}
	function add_customize_discounts(settings) {
	
		var html = '';
		
		html+= '<div class="form-group" data-cd="'+customize_discounts_cnt+'" >';
		
		html+= '<div class="col-sm-2">';
		html+= '<div class="col-sm-12">';
		html+= '<label class="control-label"><?php echo addslashes($entry_discount_quantity_spec); ?></label>';
		html+= '</div>';
		html+= '<div class="col-sm-12">';
		html+= '<select name="liveprice_settings[dqc]['+customize_discounts_cnt+'][discount_quantity]" class="form-control">';
		html+= '<option value="0" '+(typeof(settings)!='undefined'&&settings['discount_quantity']==0 ? 'selected' : '')+' ><?php echo addslashes($text_discount_quantity_0); ?></option>';
		html+= '<option value="1" '+(typeof(settings)!='undefined'&&settings['discount_quantity']==1 ? 'selected' : '')+' ><?php echo addslashes($text_discount_quantity_1); ?></option>';
		html+= '<option value="2" '+(typeof(settings)!='undefined'&&settings['discount_quantity']==2 ? 'selected' : '')+' ><?php echo addslashes($text_discount_quantity_2); ?></option>';
		html+= '</select>';
		html+= '<span class="help-block" style="display: none;" data-notify="ro"><?php echo addslashes($text_relatedoptions_notify); ?></span>';
		html+= '</div>';
		html+= '</div>';
		
		html+= '<div class="col-sm-3">';
		html+= '<label class="control-label" ><?php echo addslashes($entry_categories_spec); ?></label>';
		html+= '<input type="text" name="category" value="" placeholder="<?php echo addslashes($entry_categories_spec); ?>" data-cd="input-category-'+customize_discounts_cnt+'" class="form-control" />';
		html+= '<div data-cd="product-category-'+customize_discounts_cnt+'" class="well well-sm" style="height: 150px; overflow: auto;">';
		if ( typeof(settings)!='undefined' && typeof(settings['categories'])!='undefined') {
			for (var i in settings['categories']) {
				var category = settings['categories'][i];
				html+= add_customize_discounts_html_elem(customize_discounts_cnt, 'categories', category['name'], category['category_id']);
			}
		}
		html+= '</div>';
		html+= '</div>';
		
		html+= '<div class="col-sm-3">';
		html+= '<label class="control-label" ><?php echo addslashes($entry_manufacturers_spec); ?></label>';
		html+= '<input type="text" name="manufacturer" value="" placeholder="<?php echo addslashes($entry_manufacturers_spec); ?>" data-cd="input-manufacturer-'+customize_discounts_cnt+'" class="form-control" />';
		html+= '<div data-cd="product-manufacturer-'+customize_discounts_cnt+'" class="well well-sm" style="height: 150px; overflow: auto;">';
		if ( typeof(settings)!='undefined' && typeof(settings['manufacturers'])!='undefined') {
			for (var i in settings['manufacturers']) {
				var manufacturer = settings['manufacturers'][i];
				html+= add_customize_discounts_html_elem(customize_discounts_cnt, 'manufacturers', manufacturer['name'], manufacturer['manufacturer_id']);
			}
		}
		html+= '</div>';
		html+= '</div>';
		
		html+= '<div class="col-sm-3">';
		html+= '<label class="control-label"><?php echo addslashes($entry_products_spec); ?></label>';
		html+= '<input type="text" name="related" value="" placeholder="<?php echo addslashes($entry_products_spec); ?>" data-cd="input-related-'+customize_discounts_cnt+'" class="form-control" />';
		html+= '<div data-cd="product-related-'+customize_discounts_cnt+'" class="well well-sm" style="height: 150px; overflow: auto;">';
		if ( typeof(settings)!='undefined' && typeof(settings['products'])!='undefined') {
			for (var i in settings['products']) {
				var product = settings['products'][i];
				html+= add_customize_discounts_html_elem(customize_discounts_cnt, 'products', product['name'], product['product_id']);
			}
		}
		html+= '</div>';
		html+= '</div>';
		
		html+= '<div class="col-sm-1">';
		html+= '<a class="btn btn-danger" onclick="$(\'[data-cd='+customize_discounts_cnt+']\').remove();"><i class="fa fa-minus-circle"></i></a>';
		html+= '</div>';
		
		html+= '</div>';
		html+= '<hr data-cd="'+customize_discounts_cnt+'">';
		
		
		$('#add_customize_discounts_button').parent().before(html);
		enableCustomizeDiscountAutocomplete(customize_discounts_cnt);
		
		customize_discounts_cnt++;
	
	}
	
	function enableCustomizeDiscountAutocomplete(customize_discounts_cnt) {
		// Category
		$('[data-cd="'+customize_discounts_cnt+'"] input[name=\'category\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['category_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('[data-cd="'+customize_discounts_cnt+'"] input[name=\'category\']').val('');
				$('[data-cd="product-category-'+customize_discounts_cnt+'"] [value="'+item['value']+'"]').parent().remove();
				$('[data-cd="product-category-'+customize_discounts_cnt+'"]').append( add_customize_discounts_html_elem(customize_discounts_cnt, 'categories', item['label'], item['value']) );
			}
		});
		$('[data-cd="product-category-'+customize_discounts_cnt+'"]').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
		
		// Manufacturer
		$('[data-cd="'+customize_discounts_cnt+'"] input[name=\'manufacturer\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['manufacturer_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('[data-cd="'+customize_discounts_cnt+'"] input[name=\'manufacturer\']').val('');
				$('[data-cd="product-manufacturer-'+customize_discounts_cnt+'"] [value="'+item['value']+'"]').parent().remove();
				$('[data-cd="product-manufacturer-'+customize_discounts_cnt+'"]').append( add_customize_discounts_html_elem(customize_discounts_cnt, 'manufacturers', item['label'], item['value']) );
			}
		});
		$('[data-cd="product-manufacturer-'+customize_discounts_cnt+'"]').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
		// Product
		$('[data-cd="'+customize_discounts_cnt+'"] input[name=\'related\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['product_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('[data-cd="'+customize_discounts_cnt+'"] input[name=\'related\']').val('');
				$('[data-cd="product-related-'+customize_discounts_cnt+'"] [value="'+item['value']+'"]').parent().remove();
				$('[data-cd="product-related-'+customize_discounts_cnt+'"]').append( add_customize_discounts_html_elem(customize_discounts_cnt, 'products', item['label'], item['value']) );
			}
		});
		
		$('[data-cd="product-related-'+customize_discounts_cnt+'"]').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
	}
	
	<?php
	
	if (!empty($liveprice_settings['discount_quantity_customize'])) { // enabled
		if (!empty($liveprice_settings['dqc'])) {
			foreach ($liveprice_settings['dqc'] as $dqc) {
				echo "add_customize_discounts(".json_encode($dqc).");\n";
			}
			
		// old script compatibility	
		} elseif ( !empty($discount_quantity_spec) || !empty($product_categories) || !empty($product_manufacturers) || !empty($product_relateds) ) {
			
			echo "var current_dqc = {	discount_quantity: ".(!empty($discount_quantity_spec) ? $discount_quantity_spec : 0)."
															, categories: ".(!empty($product_categories) ? json_encode($product_categories) : '""')."
															, manufacturers: ".(!empty($product_manufacturers) ? json_encode($product_manufacturers) : '""')."
															, products: ".(!empty($product_relateds) ? json_encode($product_relateds) : '""')."
															};\n";
											
			echo "add_customize_discounts(current_dqc);\n";
		}
	}
	
	?>

<?php } ?>	
	
$('#ropro_discounts_addition').change(function(){
	$('[data-notify="ropro_discounts_addition"]').toggle($(this).is(':checked'));
});
$('#ropro_discounts_addition').change();

$('#ropro_specials_addition').change(function(){
	$('[data-notify="ropro_specials_addition"]').toggle($(this).is(':checked'));
});
$('#ropro_specials_addition').change();

//--></script>

<script type="text/javascript"><!--

	function check_for_updates() {
		
		$.ajax({
			url: window.location.protocol+'//update.liveopencart.com/upd.php',
			type: 'post',
			data: {module:'<?php echo $extension_code; ?>', version:'<?php echo $module_version; ?>', lang: '<?php echo $config_admin_language; ?>'},
			dataType: 'json',
	
			success: function(data) {
				
				if (data) {
					
					if (data['recommend']) {
						$('#we_recommend').html(data['recommend']);
					}
					if (data['update']) {
						$('#tab-about-button').append('&nbsp;&nbsp;<font style="color:red;font-weight:normal;"><?php echo addslashes($text_update_alert); ?></font>');
						$('#module_description').after('<hr><div class="alert alert-info" role="alert">'+data['update']+'</div>');
					}
					if (data['product_pages']) {
						$('#module_page').html(data['product_pages']);
					}
				}
			}
		});
		
	}

	check_for_updates();

//--></script>

<?php echo $footer; ?>