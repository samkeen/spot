<h2>Markers :: Add</h2>

<?php echo form::open(); ?>
<p>
<?php
echo form::auto_label('email');
echo form::input('email', $marker->email, array('size="20"'));
client::validation('email');
?>
</p>

<p>
<?php
echo form::submit('submit', 'Save');
echo form::close();
?>
</p>