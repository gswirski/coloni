<h3>Country!</h3>
<?php foreach ($list as $country) : ?>
<?php echo $country->Settlement[0]->name . "\n"; ?><br />
<?php endforeach; ?>