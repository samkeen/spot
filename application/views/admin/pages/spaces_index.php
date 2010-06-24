<h2>Spaces</h2>
<?php echo HTML::anchor("admin/spaces/add/","New"); ?>
<ul>
<?php foreach ($spaces as $space)  { ?>
    <li>
        <span class="name"><?php echo HTML::chars($space->name); ?></span>
        <?php echo HTML::anchor("admin/spaces/edit/{$space->id}","Edit"); ?>
        <?php echo HTML::anchor("admin/spaces/delete/{$space->id}","Delete"); ?>
        <ul>
            <?php foreach($space->markers->find_all() as $marker) { ?>
            
            <li>
                <span class="name">
                    <?php echo HTML::chars($marker->email); ?>
                    (<?php echo "{$marker->placement->x}, {$marker->y}" ?>)
                </span>
                
                <?php echo HTML::anchor("admin/markers/edit/{$marker->id}","Edit"); ?>
                <?php echo HTML::anchor("admin/markers/delete/{$marker->id}","Delete"); ?>
            </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>
</ul>