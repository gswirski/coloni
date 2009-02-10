<h3>Field <?php echo $sf_request->getParameter('field_id'); ?> - available buildings</h3>
<?php foreach ($buildings as $building) : ?>
  <h4><?php echo $building['title']; ?></h4>
  <p><?php echo $building['description']; ?></p>
  <form method="post">
    <input type="hidden" name="building_id" value="<?php echo $building->id; ?>" />
    <input type="submit" value="Build" />
  </form>
<?php endforeach; ?>