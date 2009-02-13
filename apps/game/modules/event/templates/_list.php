<?php if (is_array($list)) : ?>
<h4>Events:</h4>
<ul id="events">
  <?php foreach ($list as $event): ?>
  <li><?php $still = $event['end'] - time(); echo "Building {$event['EventBuildField']['Building']['title']} - {$still} seconds left"; ?></li>
  <?php endforeach; endif; ?>
</ul>