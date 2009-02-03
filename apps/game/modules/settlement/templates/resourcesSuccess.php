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
  <a href="">Production</a>, 
  <a href="">Defences</a>, 
  <a href="">City</a>, 
  <a href="">Square</a>
<p>

<?php foreach($settlement->Field as $field) : ?>
  <?php echo "Field {$field->id} - {$field->type}"; ?><br />
<?php endforeach; ?>