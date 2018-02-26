<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-extratab" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
<style>
#page-wrap ul li img {
	margin: 0px 3px 6px 3px;
}
</style>  
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-extratab" class="form-horizontal">
			<input type="hidden" name="extra_tab_id" value="<?php echo $extra_tab_id; ?>" />
		   <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-products" data-toggle="tab"><?php echo $tab_products; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                  <?php if ($error_name) { ?>
                  <div class="text-danger"><?php echo $error_name; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
				  <select name="status" id="input-status" class="form-control">
					<?php if ($status) { ?>
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
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $tab_stores)) { ?>
                        <input type="checkbox" name="tab_stores[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="tab_stores[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $tab_stores)) { ?>
                        <input type="checkbox" name="tab_stores[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="tab_stores[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_customer_group; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $tab_customer_groups)) { ?>
                        <input id="guests" type="checkbox" name="tab_customer_groups[]" value="0" checked="checked" />
                        <?php echo $text_guests; ?>
                        <?php } else { ?>
                        <input id="guests" type="checkbox" name="tab_customer_groups[]" value="0" />
                        <?php echo $text_guests; ?>
                        <?php } ?>
                      </label>
                    </div>
					<?php if (!in_array(0, $tab_customer_groups)) { ?>
						<?php foreach ($customer_groups as $customer_group) { ?>
						<div class="checkbox">
						  <label>
							<?php if (in_array($customer_group['customer_group_id'], $tab_customer_groups)) { ?>
							<input id="group<?php echo $customer_group['customer_group_id']; ?>" type="checkbox" name="tab_customer_groups[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
							<?php echo $customer_group['name']; ?>
							<?php } else { ?>
							<input id="group<?php echo $customer_group['customer_group_id']; ?>" type="checkbox" name="tab_customer_groups[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
							<?php echo $customer_group['name']; ?>
							<?php } ?>
						  </label>
						</div>
						<?php } ?>
					<?php } else { ?>	
						<?php foreach ($customer_groups as $customer_group) { ?>
						<div class="checkbox">
						  <label>
							<?php if (in_array($customer_group['customer_group_id'], $tab_customer_groups)) { ?>
							<input id="group<?php echo $customer_group['customer_group_id']; ?>" disabled="true" type="checkbox" name="tab_customer_groups[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
							<?php echo $customer_group['name']; ?>
							<?php } else { ?>
							<input id="group<?php echo $customer_group['customer_group_id']; ?>" disabled="true" type="checkbox" name="tab_customer_groups[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
							<?php echo $customer_group['name']; ?>
							<?php } ?>
						  </label>
						</div>
						<?php } ?>					
					<?php } ?>						
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>			  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-position"><?php echo $entry_position; ?></label>
                <div class="col-sm-10">
				  <select name="position" id="input-position" class="form-control">
                <?php if ($position==0) { ?>
					<option value="0" selected="selected"><?php echo $text_before0; ?></option>
                <?php } else { ?>
					<option value="0"><?php echo $text_before0; ?></option>	
				<?php } ?>
                <?php if ($position==1) { ?>
					<option value="1" selected="selected"><?php echo $text_before1; ?></option>
                <?php } else { ?>
					<option value="1"><?php echo $text_before1; ?></option>	
				<?php } ?>
                <?php if ($position==2) { ?>
					<option value="2" selected="selected"><?php echo $text_before2; ?></option>
                <?php } else { ?>
					<option value="2"><?php echo $text_before2; ?></option>	
				<?php } ?>
                <?php if ($position==3) { ?>
					<option value="3" selected="selected"><?php echo $text_before3; ?></option>
                <?php } else { ?>
					<option value="3"><?php echo $text_before3; ?></option>	
				<?php } ?>	
				  </select>
                </div>
              </div>	  
			  <fieldset>
			  <legend><?php echo $entry_select_option; ?></legend>
			  <div class="form-group">
				<label class="col-sm-2 control-label"><?php echo $entry_select_option_general; ?></label>
				<div class="col-sm-10">
					  <label class="radio-inline">
						<?php if ($extratabs_overwrite_general) { ?>
						<input type="radio" name="option_general" value="1" checked="checked" />
						<?php echo $text_overwrite; ?>					
						<?php } else { ?>
						<input type="radio" name="option_general" value="1" />
						<?php echo $text_overwrite; ?>					
						<?php } ?>
					  </label>
					  <label class="radio-inline">
						<?php if ($extratabs_overwrite_general) { ?>
						<input type="radio" name="option_general" value="0" />
						<?php echo $text_skip; ?>						
						<?php } else { ?>
						<input type="radio" name="option_general" value="0" checked="checked" />
						<?php echo $text_skip; ?>						
						<?php } ?>
					  </label>		
				</div>				
			  </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label"><?php echo $entry_select_option_content; ?></label>
				<div class="col-sm-10">
					  <label class="radio-inline">
						<?php if ($extratabs_overwrite_content) { ?>
						<input type="radio" name="option_content" value="1" checked="checked" />
						<?php echo $text_overwrite; ?>					
						<?php } else { ?>
						<input type="radio" name="option_content" value="1" />
						<?php echo $text_overwrite; ?>					
						<?php } ?>
					  </label>
					  <label class="radio-inline">
						<?php if ($extratabs_overwrite_content) { ?>
						<input type="radio" name="option_content" value="0" />
						<?php echo $text_skip; ?>						
						<?php } else { ?>
						<input type="radio" name="option_content" value="0" checked="checked" />
						<?php echo $text_skip; ?>						
						<?php } ?>
					  </label>		
				</div>				
			  </div>			  
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
				  <input type="hidden" name="descriptions[<?php echo $language['language_id']; ?>][language_id]" value="<?php echo $language['language_id']; ?>" />
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="descriptions[<?php echo $language['language_id']; ?>][extra_tab_title]" value="<?php echo isset($descriptions[$language['language_id']]) ? $descriptions[$language['language_id']]['extra_tab_title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-text<?php echo $language['language_id']; ?>"><?php echo $entry_text; ?></label>
                    <div class="col-sm-10">
                      <textarea name="descriptions[<?php echo $language['language_id']; ?>][extra_tab_text]" placeholder="<?php echo $entry_text; ?>" id="input-text<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($descriptions[$language['language_id']]) ? $descriptions[$language['language_id']]['extra_tab_text'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>			  
            <div class="tab-pane" id="tab-products">
			  <div class="form-group">
				<div class="col-sm-10">
				  <?php echo $tree; ?>
				</div>			  
			  </div>				  
            </div>				  
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>

<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script>

<script type="text/javascript"><!--
    $('#guests').change(function() {
        if($(this).is(":checked")) {
			$("input[id^='group']").attr("disabled","disabled");
        }
		else {
			$("input[id^='group']").removeAttr("disabled");
		}	
 });		


  	$(function() {
  	 
      $('input[type="checkbox"]').change(function(e) {
      var checked = $(this).prop("checked"),
          container = $(this).parent(),
          siblings = container.siblings();	
			container.find('input[type="checkbox"]').prop({
          indeterminate: false,
          checked: checked
      });
  
      function checkSiblings(el) {
          var parent = el.parent().parent(),
              all = true;
  
          el.siblings().each(function() {
              return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
          });
  
          if (all && checked) {
              parent.children('input[type="checkbox"]').prop({
                  indeterminate: false,
                  checked: checked
              });
              checkSiblings(parent);
          } else if (all && !checked) {
              parent.children('input[type="checkbox"]').prop("checked", checked);
              parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
              checkSiblings(parent);
          } else {
              el.parents("li").children('input[type="checkbox"]').prop({
                  indeterminate: true,
                  checked: false
              });
          }
        }
    
        checkSiblings(container);
      });
    });

 //--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	<?php echo $products_assigned; ?>
	
});
//--></script> 
<?php echo $footer; ?>