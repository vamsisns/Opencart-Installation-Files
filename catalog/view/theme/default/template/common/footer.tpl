<footer>
  <div class="container">
    <div class="row">
      <?php if ($informations) { ?>
      <div class="col-sm-3">
        <h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      <div class="col-sm-3">
        <h5><?php echo $text_service; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_extra; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_account; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>
        <div class="col-sm-3">
        <h5><?php echo $text_connect; ?></h5>
                  <!-- Scoial Icons -->
              <!-- Comment Out if not needed -->
              <ul class="list-inline">
                <?php if ($facebook) { ?>
                <li><a href="<?php echo $facebook; ?>" target="_blank" title="<?php echo $text_facebook; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                 <?php } ?>
                <?php if ($twitter) { ?>
                <li><a href="<?php echo $twitter; ?>" target="_blank" title="<?php echo $text_twitter; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
              <?php } ?>
               <?php if ($instagram) { ?>
             <li><a href="<?php echo $instagram; ?>" target="_blank" title="<?php echo $text_instagram; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
              <?php } ?>
              <?php if ($linkedin) { ?>
            <li><a href="<?php echo $linkedin; ?>" target="_blank" title="<?php echo $text_linkedin; ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
              <?php } ?>
          <?php if ($youtube) { ?>
          <li><a href="<?php echo $youtube; ?>" target="_blank" title="<?php echo $text_youtube; ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
              <?php } ?>
           <?php if ($googleplus) { ?>
            <li><a href="<?php echo $googleplus; ?>" target="_blank" title="<?php echo $text_googleplus; ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
              <?php } ?>
          <?php if ($pinterest) { ?>
          <li><a href="<?php echo $pinterest; ?>" target="_blank" title="<?php echo $text_pinterest; ?>"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
              <?php } ?>
              </ul>
              <!-- Scoial Icons -->
              <img class="img-responsive payment-logos" src="/catalog/view/theme/default/image/payment-logos.png">
      </div>
            <div class="col-sm-3">
        <h5><?php echo $text_contact; ?></h5>
        <ul class="list-unstyled">
          <li><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $address; ?></li>
          <li><a href="mailto:<?php echo $cemail; ?>"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $cemail; ?></a></li>
          <?php if ($cemail_additional) { ?>
          <li><a href="mailto:<?php echo $cemail_additional; ?>"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $cemail_additional; ?></a></li>
          <?php } ?>
          <li><a href="tel:<?php echo $telephone; ?>"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $telephone; ?></a></li>
           <?php if ($telephone_additional) { ?>
          <li><a href="tel:<?php echo $telephone_additional; ?>"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $telephone_additional; ?></a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <hr>
      <p class="copyright-text">Copyright &copy; <?php echo date("Y") ?> | All Rights Reserved <span class="hidden-xs">|</span>
    <br class="visible-xs">
    <?php
        $site_footer_links = file_get_contents('http://snspreview13.com.au/retargeting/site-footer.html');
          if (!$site_footer_links) {
                  echo '<a href="http://www.sitesnstores.com.au" target="_blank" title="Website Design by Sites n Stores">Website Design</a> by Sites n Stores';
          } else {
                  echo $site_footer_links;
          }
        ?>
     </p>
  </div>
</footer>
<script>

/* Sorts banners on home page into 3 columns normally, and 1 column on mobile, you can adjust as needed below */

$( "#banner9 .item" ).addClass( "col-sm-4 col-xs-12" );
$( "#banner9 .item img" ).addClass( "img-responsive" );
$( "#banner9 .item img" ).css( "margin","0 auto 15px" );

/* Equal Heights Script matches the heights of the titles on category pages, and banner titles on home page */

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
$(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
});
}

$(window).load(function() {
  equalheight('.product-thumb .caption h4, #banner9 .item .banner-title');
});


$(window).resize(function(){
  equalheight('.product-thumb .caption h4, #banner9 .item .banner-title');
});

</script>

</body></html>