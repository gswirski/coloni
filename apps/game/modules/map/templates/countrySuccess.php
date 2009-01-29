<h3>Country!</h3>
<?php foreach ($list as $settlement) : ?>
  <?php echo link_to($settlement, "@settlement?id={$settlement->id}"); ?>
<?php endforeach; ?>