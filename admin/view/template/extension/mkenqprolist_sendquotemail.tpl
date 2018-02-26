<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
         <h1><?php echo $enquiry_email_heading; ?></h1>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-envelope"></i> <?php echo $enquiry_email_heading; ?></h3>
      </div>
      <div class="panel-body" id="mkenqpro_emailresp">
        <form class="form-horizontal" id="sendenquirymail-form" method="post" enctype="multipart/form-data">	
		<input type="hidden" name="mkenqpro_id" value="<?php echo $mkenqpro_data['mkenqpro_id'];?>" />
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-store"><?php echo $entry_store; ?></label>
            <div class="col-sm-10">
              <select name="store_id" id="input-store" class="form-control">
                <option value="0"><?php echo $text_default; ?></option>
                <?php foreach ($stores as $store) { ?>
                <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-toemail"><?php echo $entry_to; ?></label>
            <div class="col-sm-10">
 				<input type="text" name="toemail" value="<?php echo $toemail; ?>" id="input-toemail" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-subject"><?php echo $entry_subject; ?></label>
            <div class="col-sm-10">
              <input type="text" name="subject" value="" placeholder="<?php echo $entry_subject; ?>" id="input-subject" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-message"><?php echo $entry_message; ?></label>
            <div class="col-sm-10">
              <textarea name="message" placeholder="<?php echo $entry_message; ?>" id="input-message" class="form-control summernote"></textarea>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-attachmentfile"><?php echo $entry_attachmentfile; ?></label>
            <div class="col-sm-10">
				<input type="file" name="attachmentfile" id="input-attachmentfile" class="form-control" />
            </div>
          </div>
        </form>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-button-send">&nbsp;</label>
            <div class="col-sm-10"> <button id="button-send" data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip" title="<?php echo $button_send; ?>" class="btn btn-primary" onclick="send();"><i class="fa fa-envelope"></i> <?php echo $btn_sendmail; ?></button> </div>
         </div>
      </div>
    </div>
  </div> 
</div>
  
<?php if(substr(VERSION,0,3)=='2.3') { ?>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<?php } else if(substr(VERSION,0,3)=='2.0' || substr(VERSION,0,3)=='2.1') { ?>
<script type="text/javascript">$('.summernote').summernote({height: 300});</script>
<?php } ?>

<script type="text/javascript"><!--
$(document).ready(function(){
	$('#input-attachmentfile').change(function(e){
		var file = this.files[0];
		var form = new FormData();
		//alert(form);
		form.append('attachmentfile', file);
		$.ajax({
			url : 'index.php?route=<?php echo $modpath;?>/upload&token=<?php echo $token; ?>',
			type: "POST",
			cache: false,
			contentType: false,
			processData: false,
			data : form,
			beforeSend: function() {
				$('input[name=\'attachmentfile\']').after('<div class="text-info waitattach"> pls wait...</div>');
			},
			success: function(response){
				$('input[name=\'attachmentfile\']').after('<div class="text-success"> File uploaded successfully !</div>');
				$('.waitattach').remove();
 			}
		});
	});
});

function send() {
	<?php if(substr(VERSION,0,3)=='2.0' || substr(VERSION,0,3)=='2.1') { ?>
	$('textarea[name=\'message\']').html($('.summernote').code());
	<?php } ?>
 	$.ajax({
		url: 'index.php?route=<?php echo $modpath;?>/sendmail&token=<?php echo $token; ?>',
		type: 'post',
		data: $('#sendenquirymail-form').serialize(),
		dataType: 'json',
		beforeSend: function() {
			$('#button-send').button('loading');
		},
		complete: function() {
			$('#button-send').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '</div>');
				}

 				if (json['error']['email']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['email'] + '</div>');
				}
				
				if (json['error']['toemail']) {
					$('input[name=\'toemail\']').after('<div class="text-danger">' + json['error']['toemail'] + '</div>');
				}
				
				if (json['error']['subject']) {
					$('input[name=\'subject\']').after('<div class="text-danger">' + json['error']['subject'] + '</div>');
				}

				if (json['error']['message']) {
					$('textarea[name=\'message\']').parent().append('<div class="text-danger">' + json['error']['message'] + '</div>');
				}
			}

			if (json['success']) {
				$('#mkenqpro_emailresp').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['success'] + '</div>');
				setTimeout(function(){ location = 'index.php?route=<?php echo $modpath;?>&token=<?php echo $token; ?>'; }, 2000); 
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
//--></script></div>
<?php echo $footer; ?> 