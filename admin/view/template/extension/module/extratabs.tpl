<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-extratabs" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-extratabs" class="form-horizontal">
		  <input type="hidden" name="extratabs_installed" value="1" />
		  <fieldset>
		  <legend><?php echo $text_general; ?></legend>
          <div class="form-group">
			<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_status; ?>"><?php echo $entry_status; ?></span></label>
            <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($extratabs_status) { ?>
                    <input type="radio" name="extratabs_status" value="1" checked="checked" />
                    <?php echo $text_enabled; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_status" value="1" />
                    <?php echo $text_enabled; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$extratabs_status) { ?>
                    <input type="radio" name="extratabs_status" value="0" checked="checked" />
                    <?php echo $text_disabled; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_status" value="0" />
                    <?php echo $text_disabled; ?>
                    <?php } ?>
                  </label>			
            </div>
          </div>			
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_delete; ?></label>
            <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($extratabs_delete) { ?>
                    <input type="radio" name="extratabs_delete" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_delete" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$extratabs_delete) { ?>
                    <input type="radio" name="extratabs_delete" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_delete" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>			
            </div>
          </div>			
		  <div class="form-group">			
			<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_auto_assign; ?>"><?php echo $entry_auto_assign; ?></span></label>
            <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($extratabs_auto_assign) { ?>
                    <input type="radio" name="extratabs_auto_assign" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_auto_assign" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$extratabs_auto_assign) { ?>
                    <input type="radio" name="extratabs_auto_assign" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_auto_assign" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>			
            </div>				
          </div>	  
		</fieldset>
		<fieldset>
		  <legend><?php echo $text_template_form; ?></legend>
          <div class="form-group">
			<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_tree_type; ?>"><?php echo $entry_tree_type; ?></span></label>
            <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($extratabs_tree_type) { ?>
                    <input type="radio" name="extratabs_tree_type" value="1" checked="checked" />
                    <?php echo $text_products; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_tree_type" value="1" />
                    <?php echo $text_products; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$extratabs_tree_type) { ?>
                    <input type="radio" name="extratabs_tree_type" value="0" checked="checked" />
                    <?php echo $text_categories; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_tree_type" value="0" />
                    <?php echo $text_categories; ?>
                    <?php } ?>
                  </label>			
            </div>
          </div>			
		  <div class="form-group">
			<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_option_general; ?>"><?php echo $entry_option_general; ?></span></label>
            <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($extratabs_overwrite_general) { ?>
                    <input type="radio" name="extratabs_overwrite_general" value="1" checked="checked" />
                    <?php echo $text_overwrite; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_overwrite_general" value="1" />
                    <?php echo $text_overwrite; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$extratabs_overwrite_general) { ?>
                    <input type="radio" name="extratabs_overwrite_general" value="0" checked="checked" />
                    <?php echo $text_skip; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_overwrite_general" value="0" />
                    <?php echo $text_skip; ?>
                    <?php } ?>
                  </label>			
            </div>
          </div>			
		  <div class="form-group">			
			<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_option_content; ?>"><?php echo $entry_option_content; ?></span></label>
            <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($extratabs_overwrite_content) { ?>
                    <input type="radio" name="extratabs_overwrite_content" value="1" checked="checked" />
                    <?php echo $text_overwrite; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_overwrite_content" value="1" />
                    <?php echo $text_overwrite; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$extratabs_overwrite_content) { ?>
                    <input type="radio" name="extratabs_overwrite_content" value="0" checked="checked" />
                    <?php echo $text_skip; ?>
                    <?php } else { ?>
                    <input type="radio" name="extratabs_overwrite_content" value="0" />
                    <?php echo $text_skip; ?>
                    <?php } ?>
                  </label>			
            </div>				
          </div>	  
		</fieldset>	
		<?php if (false) { ?>
		<fieldset>
		  <legend><?php echo $text_upgrade; ?></legend>
          <div class="form-group">
            <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_upgrade; ?>"><?php echo $entry_upgrade; ?></span></label>
            <div class="col-sm-10">
				<a onclick="$('#form').attr('action','<?php echo $upgrade; ?>');$('#form-extratabs').submit();" class="btn btn-default"><?php echo $text_upgrade; ?></a>		
            </div>
          </div>				  
		</fieldset>	
		<?php } ?>		
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>