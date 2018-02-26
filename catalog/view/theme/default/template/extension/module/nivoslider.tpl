<div class="slider-wrapper theme-<?php echo $style; ?>">
  <div id="nivoSlider-<?php echo $module; ?>" class="nivoSlider">
    <?php foreach ($banners as $banner) { ?>
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" data-thumb="<?php echo $banner['thumb']; ?>" alt="<?php echo $banner['title']; ?>" 
      <?php if ($caption) { ?>
      title="<?php echo $banner['description']; ?>" 
      <?php } ?>
      /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" data-thumb="<?php echo $banner['thumb']; ?>" alt="<?php echo $banner['title']; ?>" 
      <?php if ($caption) { ?>
      title="<?php echo $banner['description']; ?>" 
      <?php } ?>
      />
    <?php } ?>
    <?php } ?>
  </div>
</div>  
<script type="text/javascript"><!--
$('#nivoSlider-<?php echo $module; ?>').nivoSlider({
  effect: '<?php echo $effect; ?>',
  slices: <?php echo $slices; ?>,
  boxCols: <?php echo $boxcols; ?>,
  boxRows: <?php echo $boxrows; ?>,
  animSpeed: <?php echo $duration; ?>,
  pauseTime: <?php echo $speed; ?>,
  directionNav: <?php echo $directionnav; ?>,
  startSlide: <?php echo $start; ?>,
  controlNav: <?php echo $controlnav; ?>,
  controlNavThumbs: <?php echo $controlnavthumbs; ?>,
  pauseOnHover: <?php echo $pause; ?>,
  manualAdvance: <?php echo $autoplay; ?>,
  randomStart: <?php echo $random; ?>,
  <?php if ($beforechange) { ?>
  beforeChange: <?php echo $beforechange; ?>,
  <?php } ?>
  <?php if ($afterchange) { ?>
  afterChange: <?php echo $afterchange; ?>,
  <?php } ?>
  <?php if ($slideshowend) { ?>
  slideshowEnd: <?php echo $slideshowend; ?>,
  <?php } ?>
  <?php if ($lastslide) { ?>
  lastSlide: <?php echo $lastslide; ?>,
  <?php } ?>
  <?php if ($afterload) { ?>
  afterLoad: <?php echo $afterload; ?>
  <?php } ?> 
});
--></script>

