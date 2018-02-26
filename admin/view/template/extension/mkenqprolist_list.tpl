<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-mkenqpro').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-2">
              <div class="form-group">
                <label class="control-label" for="input-mkenqpro_id"><?php echo $column_mkenqpro_id; ?></label>
                <input type="text" name="filter_mkenqpro_id" value="<?php echo $filter_mkenqpro_id; ?>" placeholder="<?php echo $column_mkenqpro_id; ?>" id="input-mkenqpro_id" class="form-control" />
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label class="control-label" for="input-store_id"><?php echo $column_store; ?></label>
                <select name="filter_store_id" id="input-store_id" class="form-control">
                  <option value="*" <?php if ('*' == $filter_store_id) { ?> selected="selected" <?php } ?>><?php echo $text_select; ?></option>
				  <option value="0" <?php if (0 == $filter_store_id && '*' != $filter_store_id) { ?> selected="selected" <?php } ?>><?php echo $text_default; ?></option>
                  <?php foreach ($stores as $store) { ?>
                  <option value="<?php echo $store['store_id']; ?>" <?php if ($store['store_id'] == $filter_store_id) { ?> selected="selected" <?php } ?>><?php echo $store['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_customer_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_customer_name; ?>" id="input-name" class="form-control" />
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label class="control-label" for="input-phnum"><?php echo $entry_phnum; ?></label>
                <input type="text" name="filter_phnum" value="<?php echo $filter_phnum; ?>" placeholder="<?php echo $entry_phnum; ?>" id="input-phnum" class="form-control" />
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-group">
                <label class="control-label">&nbsp;</label>
                <button type="button" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
              </div>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-mkenqpro">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'mkenqpro_id') { ?>
                    <a href="<?php echo $sort_mkenqpro_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_mkenqpro_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_mkenqpro_id; ?>"><?php echo $column_mkenqpro_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_store; ?> </td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_customer_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'email') { ?>
                    <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'phnum') { ?>
                    <a href="<?php echo $sort_phnum; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_phnum; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_phnum; ?>"><?php echo $column_phnum; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_address; ?> </td>
                  <td class="text-left"><?php if ($sort == 'date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
					<td class="text-left"><?php if ($sort == 'replied_enquiry') { ?>
                    <a href="<?php echo $sort_replied_enquiry; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_replied_enquiry; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_replied_enquiry; ?>"><?php echo $column_replied_enquiry; ?></a>
                    <?php } ?></td>
 				  <td class="text-right"><?php echo $column_view_enquiry; ?> </td>
                </tr>
              </thead>
              <tbody>
                <?php if ($mkenqpros) { ?>
                <?php foreach ($mkenqpros as $mkenqpro) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($mkenqpro['mkenqpro_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $mkenqpro['mkenqpro_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $mkenqpro['mkenqpro_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $mkenqpro['mkenqpro_id']; ?></td>
                  <td class="text-left"><?php echo $mkenqpro['store_name']; ?></td>
                  <td class="text-left"><?php echo $mkenqpro['name']; ?></td>
                  <td class="text-left"><?php echo $mkenqpro['email']; ?></td>
                  <td class="text-left"><?php echo $mkenqpro['phnum']; ?></td>
                  <td class="text-left"><?php echo $mkenqpro['address']; ?></td>
                  <td class="text-left"><?php echo $mkenqpro['date_added']; ?></td>
				  <td class="text-center"><input value="1" type="checkbox" id="replied_enquiry<?php echo $mkenqpro['mkenqpro_id'];?>" onclick="replied_enquiry('<?php echo $mkenqpro['mkenqpro_id'];?>');" <?php if($mkenqpro['replied_enquiry'] == 1) { ?> checked="checked" <?php } ?> /> </td>
                  <td class="text-right"><button type="button" id="button-mailsend" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $btn_sendmail;?>" onclick="sendenquirymail('<?php echo $mkenqpro['mkenqpro_id']; ?>');"><i class="fa fa-envelope"></i></button> &nbsp;
				  <button type="button" id="button-view-enquiry" data-toggle="tooltip" title="<?php echo $btn_view;?>" onclick="view_mkenqpro(<?php echo $mkenqpro['mkenqpro_id']; ?>);" class="btn btn-primary pull-right"><i class="fa fa-eye"></i> </button></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <div id="mkenqpropopup" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $column_view_enquiry;?></h4>
        </div>
        <div class="modal-body"> </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $btn_close;?></button>
        </div>
      </div>
    </div>
  </div>
   

<script type="text/javascript"><!--
function sendenquirymail(mkenqpro_id) {
	window.open('index.php?route=<?php echo $modpath;?>/sendenquirymail&token=<?php echo $token; ?>&mkenqpro_id='+mkenqpro_id);
}

function view_mkenqpro(mkenqpro_id) { 
	$('#mkenqpropopup').modal('show'); 
	$('#mkenqpropopup .modal-body').load('index.php?route=<?php echo $modpath;?>/viewenquiry&token=<?php echo $token;?>&mkenqpro_id=' + mkenqpro_id); 
}

function replied_enquiry(mkenqpro_id) {
	chkval = 0;
	sucid = 'replied_enquiry_success'+mkenqpro_id;
	
	if($('#replied_enquiry' + mkenqpro_id).is(":checked")) {
		chkval = 1;
	}
	
	$.ajax({
		url: 'index.php?route=<?php echo $modpath;?>/updaterepliedenquiry&token=<?php echo $token;?>',
		type: 'post',
		data: { mkenqpro_id: mkenqpro_id, chkval: chkval },
 		success: function() {
			//alert('Success');
  			$('#replied_enquiry' + mkenqpro_id).parent().prepend('<div class="alert alert-success" id="'+sucid+'"> <strong>Success!</strong> </div>');
			setTimeout(function() { $("#"+sucid).remove(); }, 800);

		}
	});
}

$('#button-filter').on('click', function() {
	url = 'index.php?route=<?php echo $modpath;?>&token=<?php echo $token; ?>';
	
	var filter_mkenqpro_id= $('input[name=\'filter_mkenqpro_id\']').val();
 	if (filter_mkenqpro_id) {
		url += '&filter_mkenqpro_id=' + encodeURIComponent(filter_mkenqpro_id);
	}
	
	var filter_store_id= $('select[name=\'filter_store_id\']').val();
 	if (filter_store_id != '') {
		url += '&filter_store_id=' + encodeURIComponent(filter_store_id);
	}
	
 	var filter_name= $('input[name=\'filter_name\']').val();
 	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_phnum = $('input[name=\'filter_phnum\']').val();
 	if (filter_phnum) {
		url += '&filter_phnum=' + encodeURIComponent(filter_phnum);
	}
	
	var filter_email = $('input[name=\'filter_email\']').val();
 	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
  		
	var filter_date_added = $('input[name=\'filter_date_added\']').val();
 	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location = url;
}); 
//--></script>
</div>
<?php echo $footer; ?> 