<h3>World: <?php echo "$x, $y"; ?>!</h3>
<?php foreach ($map_data as $field) : ?>
  <?php echo link_to($field->Settlement, "@settlement?id={$field->Settlement->id}"); ?><br />
<?php endforeach;?>