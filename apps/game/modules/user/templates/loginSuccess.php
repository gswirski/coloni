<h3>Login / <?php echo link_to('Register', '@register'); ?></h3>
<form action="<?php echo url_for('@login') ?>" method="POST">
<table>
<?php echo $form; ?>
<tr>
	<td colspan="2">
		<input type="submit" />
	</td>
</tr>
</table>
<form>