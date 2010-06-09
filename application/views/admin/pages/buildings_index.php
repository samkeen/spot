<h2>Buildings</h2>
<?php echo HTML::anchor("admin/buildings/add/","New"); ?>
<ul>
<?php foreach ($buildings as $building)  { ?>
    <li>
        <span class="name"><?php echo HTML::chars($building->name); ?></span>
        <?php echo HTML::anchor("admin/buildings/edit/{$building->id}","Edit"); ?>
        <?php echo HTML::anchor("admin/buildings/delete/{$building->id}","Delete"); ?>
        <ul>
            <?php foreach($building->spaces->find_all() as $space) { ?>
            <li>
                <span class="name"><?php echo HTML::chars($space->name); ?></span>
                <?php echo HTML::anchor("admin/buildings/edit/{$space->id}","Edit"); ?>
                <?php echo HTML::anchor("admin/buildings/delete/{$space->id}","Delete"); ?>
            </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>
</ul>