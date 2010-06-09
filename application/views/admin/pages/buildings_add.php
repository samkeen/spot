<h2>Buildings :: Add</h2>

<?php echo form::open(); ?>
<p>
<?php
echo form::auto_label('site_id');
echo form::input('site_id', $building->site_id, array('size="20"'));
client::validation('site_id');
?>
</p>
<p>
<?php
echo form::auto_label('name');
echo form::input('name', $building->name, array('size="20"'));
client::validation('name');
?>
</p>

<p>
<?php
echo form::auto_label('lat');
echo form::input('lat', $building->lat, array('size="20"'));
client::validation('lat');
?>
</p>

<p>
<?php
echo form::auto_label('long');
echo form::input('long', $building->long, array('size="20"'));
client::validation('long');
?>
</p>

<p>
<?php
echo form::submit('submit', 'Save');
echo form::close();
?>
</p>