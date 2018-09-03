<?php
if (!isset($SERVER_INCLUDES)) {
    exit();
}
?>

<p class="lead text-center mb-4">Please select the server you would like to manage.</p>

<div class="row">
    <?php
    foreach ($discord->user->getCurrentUserGuilds([]) as $guild) {
        $permissions = $guild->permissions;
        // Check for MANAGE GUILD permissions
        if (($permissions & MANAGE_GUILD) != 0) {
            ?>
            <div class="col-lg-2 col-md-3 col-sm-4 mb-4">
                <a href="server.php?server=<?=$guild->id?>">
                    <div class="card">
                        <?php if ($guild->icon == NULL) { ?>
                            <img class="card-img" src="https://ui-avatars.com/api/?name=<?=urlencode($guild->name)?>&size=128" alt="Image">
                        <?php } else { ?>
                            <img class="card-img" src="https://cdn.discordapp.com/icons/<?=$guild->id?>/<?=$guild->icon?>.png" alt="Image">
                        <?php } ?>
                        <div class="card-img-overlay" style="background-color: rgba(0, 0, 0, 0.6);">
                            <h5 class="text-center text-white" style="position:absolute; top:50%; left:50%; padding:15px; -ms-transform: translateX(-50%) translateY(-50%); -webkit-transform: translate(-50%,-50%); transform: translate(-50%,-50%);"><?=botHasGuild($guild->id) ? '<i class="fas fa-check"></i> ' : ''?><?=$guild->name?></h5>
                        </div>
                    </div>
                </a>
            </div>

            <?php
        }
    }
    ?>
</div>