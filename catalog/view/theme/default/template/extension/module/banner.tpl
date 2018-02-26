<div id="banner<?php echo $module; ?>" class="">
  <?php foreach ($banners as $banner) { ?>
  <div class="item">
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
          <?php if ($banner['description']) { ?>
      <?php echo $banner['description']; ?>
      <?php } ?>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
              <?php if ($banner['description']) { ?>
      <?php echo $banner['description']; ?>
      <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
</div>
