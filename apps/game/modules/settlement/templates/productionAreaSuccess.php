<h3><?php echo $settlement; ?></h3>
<hr />
<?php if ($settlement->type == 'capital' or $settlement->type == 'city') : ?>
<p>This settlement is civilized enought to <a href="<?php echo url_for("@found_settlement?id={$settlement->id}"); ?>">found dependent village</a>.</p>
<?php endif; ?>
<?php if ($settlement->type == 'village') : ?>
<p>This settlement can be <a href="">upgraded to city</a>.</p>
<?php endif; ?>
<hr />
<p>
  Select area: 
  <?php echo link_to('Production', "@settlement_production_area?id={$settlement->id}"); ?>, 
  <?php echo link_to('Defences', "@settlement_defences_area?id={$settlement->id}"); ?>, 
  <?php echo link_to('City', "@settlement_city_area?id={$settlement->id}"); ?>, 
  <?php echo link_to('Square', "@settlement_square_area?id={$settlement->id}"); ?>
<p>

<?php foreach($fields as $field) : ?>
  <?php echo link_to(
    "Field {$field['id']}",
    "@settlement_production_field?settlement_id={$settlement->id}&field_id={$field['id']}");

    if ($field['FieldBuilding'])
    {
      echo " - {$field['FieldBuilding']['Building']['title']} ({$field['FieldBuilding']['level']})";
    }
  ; ?><br />
<?php endforeach; ?>