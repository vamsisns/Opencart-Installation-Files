<div class="mkenqpro_maindiv">
  <div id="mkenqpro_content" class="mkenqpro_popupclass">
    <h1><?php echo $heading_title; ?> </h1>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td class="text-center"><?php echo $column_image; ?></td>
            <td class="text-left"><?php echo $column_name; ?></td>
            <td class="text-left"><?php echo $column_model; ?></td>
            <td class="text-left" style="max-width: 200px;"><?php echo $column_quantity; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product) { ?>
          <tr>
            <td class="text-center"><?php if ($product['thumb']) { ?>
              <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
              <?php } ?></td>
            <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
              <?php if ($product['option']) { ?>
              <?php foreach ($product['option'] as $option) { ?>
              <br />
              <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
              <?php } ?>
              <?php } ?></td>
            <td class="text-left"><?php echo $product['model']; ?></td>
            <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
                <input type="text" id="quantity<?php echo $product['cart_id']; ?>" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default" onclick="update_mkenqpro_qty('<?php echo $product['cart_id']; ?>');"><i class="fa fa-refresh"></i></button>
                <button type="button" class="btn btn-danger" onclick="update_mkenqpro_remove_cart('<?php echo $product['cart_id']; ?>');"><i class="fa fa-times-circle"></i></button>
                </span></div></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="table-responsive">
      <form method="post" name="submitmkenqpro" id="submitmkenqpro" action="index.php?route=<?php echo $modpathcart;?>/submitmkenqpro">
        <div class="form-group col-sm-12">
          <label class="col-sm-2 control-label"><?php echo $entry_customer_name; ?></label>
          <div class="col-sm-10">
            <input type="text" name="customer_name" id="input-customer_name" value="" placeholder="<?php echo $entry_customer_name; ?>" class="form-control" />
            <span class="text-danger" id="error-input-customer_name"></span> </div>
        </div>
        <div class="form-group col-sm-12">
          <label class="col-sm-2 control-label"><?php echo $entry_customer_email; ?></label>
          <div class="col-sm-10">
            <input type="text" name="customer_email" id="input-customer_email" value="" placeholder="<?php echo $entry_customer_email; ?>" class="form-control" />
            <span class="text-danger" id="error-input-customer_email"></span> </div>
        </div>
        <div class="form-group col-sm-12">
          <label class="col-sm-2 control-label"><?php echo $entry_customer_phonenum; ?></label>
          <div class="col-sm-10">
            <input type="text" name="customer_phonenum" id="input-customer_phonenum" value="" placeholder="<?php echo $entry_customer_phonenum; ?>" class="form-control" />
            <span class="text-danger" id="error-input-customer_phonenum"></span> </div>
        </div>
        <div class="form-group col-sm-12">
          <label class="col-sm-2 control-label"><?php echo $entry_customer_address; ?></label>
          <div class="col-sm-10">
            <textarea name="customer_address" id="input-customer_address" placeholder="<?php echo $entry_customer_address; ?>" class="form-control"></textarea>
            <span class="text-danger" id="error-input-customer_address"></span> </div>
        </div>
        <div class="form-group col-sm-12">
          <label class="col-sm-2 control-label"><?php echo $entry_comment; ?></label>
          <div class="col-sm-10">
            <textarea name="comment" id="input-comment" placeholder="<?php echo $entry_comment; ?>" class="form-control"></textarea>
            <span class="text-danger" id="error-input-comment"></span> </div>
        </div>
        <?php if($captcha_type == 1) { ?>
        <div class="form-group col-sm-12">
          <label class="col-sm-2 control-label"><?php echo $entry_captcha;?> <br />
            ( <?php echo $captch_str;?> ) </label>
          <div class="col-sm-10">
            <input type="text" required name="captcha" id="input-captcha" value="" placeholder="<?php echo $entry_captcha; ?>" class="form-control" />
            <input type="hidden" name="captcha1" id="captcha1" value="<?php echo $rand1;?>" />
            <input type="hidden" name="captcha2" id="captcha2" value="<?php echo $rand2;?>" />
            <span class="text-danger" id="error-input-captcha"></span> </div>
        </div>
        <?php } else { ?>
        <div class="form-group col-sm-12">
          <label class="col-sm-2 control-label"><?php echo $entry_captcha;?> </label>
          <div class="col-sm-10"> <span class="text-danger" id="error-input-captcha"></span> 
            <script src="https://www.google.com/recaptcha/api.js"></script>
            <div class="g-recaptcha" data-sitekey="<?php echo $captcha_google_key; ?>"></div>
          </div>
        </div>
        <?php } ?>
        <div class="form-group col-sm-12">
          <button type="button" class="btn btn-primary" id="mkenqprosubmit" onclick="submitdatamkenqprod();"><?php echo $btn_submit;?></button>
          <a href="<?php echo $continue_btn_href; ?> " class="btn btn-default" data-dismiss="modal"><?php echo $btn_continue;?></a> </div>
      </form>
    </div>
  </div>
</div>
<script language="javascript">
$( document ).ready(function() {
    $('.text-danger').html('');
	$('.form-group').removeClass('has-error');
});

function IsRecapchaValid() {
	var res = grecaptcha.getResponse();
 	if (res == "" || res == undefined || res.length == 0) {
		return true;
 	} 
	return false;
}
 
function update_mkenqpro_qty(cartid, sign) { 
	var quantity_val = $('#quantity'+cartid).val();

	$.ajax({
		url: "index.php?route=<?php echo $modpathcart;?>/checkouteditqty",
		type: 'post',
		data: 'key=' + cartid + '&quantity=' + quantity_val,
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
				updatecart_mkenqprocart();
			}
		} 
	}); 
}
function update_mkenqpro_remove_cart(key) {  
	$.ajax({
		url: 'index.php?route=<?php echo $modpathcart;?>/remove',
		type: 'post',
		data: 'key=' + key,
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
				updatecart_mkenqprocart();
			}
 		} 
	}); 
} 
function updatecart_mkenqprocart() {
 	$.ajax({
 		url: 'index.php?route=<?php echo $modpathcart;?>/getpopup',
 		dataType: 'html',
		beforeSend: function() {
			$('#mkenqpro_content').html('<img src="image/catalog/loader.gif"/>'); 
		}, 
		success: function(html) {
			var div = $('#mkenqpro_content', $(html));
  			if(div != '') {
				$('#mkenqpro_content').html(div);
			} else {
 				location = 'index.php?route=checkout/cart';
 			}
		}
	}); 
}
function ValidateEmail(email) {
    var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
         return false;
    }
} 
function submitdatamkenqprod() {   
 	$('.text-danger').html('');
	$('.form-group').removeClass('has-error');
	if ($('#input-customer_name').val().length < 3) {
		$('#error-input-customer_name').html("<?php echo $txt_name_error;?>");
		$('#error-input-customer_name').parent().parent().addClass('has-error');
 		return false;
	}
	if (ValidateEmail($('#input-customer_email').val()) == false) {
 		$('#error-input-customer_email').html("<?php echo $txt_email_error;?>");
		$('#error-input-customer_email').parent().parent().addClass('has-error');
 		return false;
	}
	if ($('#input-customer_address').val().length < 10) {
 		$('#error-input-customer_address').html("<?php echo $txt_address_error;?>");
		$('#error-input-customer_address').parent().parent().addClass('has-error');
 		return false;
	}
	if ($('#input-customer_phonenum').val().length < 3) {
 		$('#error-input-customer_phonenum').html("<?php echo $txt_phone_error;?>");
		$('#error-input-customer_phonenum').parent().parent().addClass('has-error');
 		return false;
	}
	if ($('#input-comment').val().length < 10) {
 		$('#error-input-comment').html("<?php echo $txt_comment_error;?>");
		$('#error-input-comment').parent().parent().addClass('has-error');
 		return false;
	}
	<?php if($captcha_type == 1) { ?>
		if( parseInt($('#input-captcha').val()) != ( parseInt($('#captcha1').val()) + parseInt($('#captcha2').val()) ) ) {
			$('#error-input-captcha').html("<?php echo $txt_captcha_error;?>");
			$('#error-input-captcha').parent().parent().addClass('has-error');
			return false;
		}
	<?php } else { ?>
		if(IsRecapchaValid()) {
			$('#error-input-captcha').html("<?php echo $txt_captcha_error;?>");
			return false;
		}
	<?php } ?>
 	
	$.ajax({
		type: "POST",
		data: $("#submitmkenqpro").serialize(),
		url: $("#submitmkenqpro").attr( 'action' ),
		dataType: 'json',
		beforeSend: function() {
 			$('#mkenqpro_content').html('<img src="image/catalog/loader.gif"/>'); 
 		},success:function(json) {
			$('#mkenqpro_content').html(json['response']); 
		}
	}); 
}
</script> 