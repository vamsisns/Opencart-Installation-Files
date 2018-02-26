<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <td class="text-center"><?php echo $column_image; ?></td>
        <td class="text-left"><?php echo $column_product_name; ?></td>
        <td class="text-left"><?php echo $column_model; ?></td>
        <td class="text-left" ><?php echo $column_quantity; ?></td>
        </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td class="text-center"><?php if ($product['thumb']) { ?>
          <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
          <?php } ?></td>
        <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a><?php if ($product['option']) { ?>
                  <?php foreach ($product['option'] as $option) { ?>
                  <br />
                  <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                  <?php } ?>
                  <?php } ?></td>
        <td class="text-left"><?php echo $product['model']; ?></td>
		<td class="text-left"><?php echo $product['quantity']; ?></td>
       </tr>
      <?php } ?>
    </tbody>
  </table>
  <p>&nbsp;</p>
  <table class="table table-bordered">
    <thead>
      <tr> <td class="text-center"><?php echo $column_comments; ?></td> </tr>
    </thead>
    <tbody>
      <tr> <td class="text-left"><?php echo $comments; ?></td> </tr>
    </tbody>
  </table>
</div> 