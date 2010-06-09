<h2>Sites</h2>
<?php echo HTML::anchor("admin/sites/add/","New"); ?>
<ul>
<?php foreach ($sites as $site)  { ?>
    <li>
        <span class="name"><?php echo HTML::chars($site->name); ?></span>
        <?php echo HTML::anchor("admin/sites/edit/{$site->id}","Edit"); ?>
        <?php echo HTML::anchor("admin/sites/delete/{$site->id}","Delete"); ?>
        <ul>
            <?php foreach($site->buildings->find_all() as $building) { ?>
            <li>
                <span class="name"><?php echo HTML::chars($building->name); ?></span>
                <?php echo HTML::anchor("admin/buildings/edit/{$building->id}","Edit"); ?>
                <?php echo HTML::anchor("admin/buildings/delete/{$building->id}","Delete"); ?>
            </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>
</ul>