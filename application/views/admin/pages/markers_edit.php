<h2>Markers :: Edit</h2>

<?php echo form::open(); ?>
<?php echo form::hidden('id',$marker->id); ?>
<p>
<?php
echo form::auto_label('email');
echo form::input('email', $marker->email, array('size="20"'));
client::validation('email');
?>
</p>

<?php
echo form::auto_label('space', 'Spaces');
//var_dump($marker->spaces->find_all()->as_array('id','name'));
$space = $marker->spaces->find_all()->as_array('space_id','name');
//$space = key($space);
echo form::check_group('space', $spaces_list, $space);
client::validation('space');
?>

<p>
<?php
echo form::submit('submit', 'Save');
echo form::close();
?>
</p>

