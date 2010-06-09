<h2>Markers</h2>
<?php echo HTML::anchor("admin/markers/add/","New"); ?>
<ul>
<?php foreach ($markers as $marker)  { ?>
    <li>
        <span class="name"><?php echo HTML::chars($marker->email); ?></span>
        <?php echo HTML::anchor("admin/markers/edit/{$marker->id}","Edit"); ?>
        <?php echo HTML::anchor("admin/markers/delete/{$marker->id}","Delete"); ?>
    </li>
<?php } ?>
</ul>