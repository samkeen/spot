<h2>Spaces :: Add</h2>

<?php echo form::open(); ?>
<p>
<?php
//@todo fix auto label (required and truncate /.*_id$/
echo form::auto_label('building_id');
echo form::input('building_id', $space->building_id, array('size="20"'));
client::validation('building_id');
?>
</p>
<p>
<?php
echo form::auto_label('name');
echo form::input('name', $space->name, array('size="20"'));
client::validation('name');
?>
</p>

<p>
<?php
echo form::auto_label('index');
echo form::input('index', $space->index, array('size="20"'));
client::validation('index');
?>
</p>

<p>
<?php
echo form::auto_label('img_filename');
echo form::input('img_filename', $space->img_filename, array('size="20"'));
client::validation('img_filename');
?>
</p>

<p>
<?php
echo form::submit('submit', 'Save');
echo form::close();
?>
</p>