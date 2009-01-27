<h3>World: <?php echo "$x, $y"; ?>!</h3>
<?php foreach ($map_data as $field) : ?>
  <?php echo "{$field->x}, {$field->y}: {$field->Settlement->name}"; ?><br />
<?php endforeach;?>