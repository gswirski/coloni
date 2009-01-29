<h3><?php echo $settlement; ?></h3>

Select area: 
<a href="">Production</a>, 
<a href="">Defences</a>, 
<a href="">City</a>, 
<a href="">Square</a>
<br /><br />

<?php foreach($settlement->Field as $field) : ?>
  <?php echo "Field {$field->id} - {$field->type}"; ?><br />
<?php endforeach; ?>