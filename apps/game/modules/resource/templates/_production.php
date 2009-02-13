<h4>Production:</h4>
<ul>
<?php foreach ($productionList as $production) : ?>
  <li><strong><?php echo ucfirst($production['resource']); ?>:</strong> <?php echo (int) $production['amount']; ?> per <i>time unit</i></li>
<?php endforeach; ?>
</ul>