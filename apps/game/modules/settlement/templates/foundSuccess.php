<h3>Found new settlement dependent on <?php echo $settlement->name; ?></h3>
<p>Main settlement position: 0, 0</p>
<p>Type new settlement position. Remember, that distance cannot be longer than 7 fields (optimal) and shorten than 3 fields.</p>
<p>
  
  <form action="<?php echo url_for("@found_settlement?id={$sf_request->getParameter('id')}") ?>" method="POST">
    <table>
      <?php echo $form ?>
      <tr>
        <td colspan="2">
          <input type="submit" />
        </td>
      </tr>
    </table>
  </form>  
  
  <br />
<?php echo link_to('Cancel', "@settlement?id={$settlement->id}"); ?></form></p>
