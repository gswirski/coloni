<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body>
    <?php if ($sf_user->isAuthenticated()): ?>
    <ul id="menu">
      <li><?php echo link_to('Country', '@countryMap'); ?></li>
      <li><?php echo link_to('World', '@worldMap'); ?></li>
      <li><?php echo link_to('Logout', '@logout'); ?></li>
    </ul>
    <?php endif; ?>
    <?php echo $sf_content ?>
  </body>
</html>
