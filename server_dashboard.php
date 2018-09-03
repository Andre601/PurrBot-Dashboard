<?php
if (!isset($SERVER_INCLUDES)) {
    exit();
}

require_once 'rethinkdb_connection.php';
$data = getServerData($id);
?>

<div class="row">
    <div class="col-12">
        <div id="success-alert" style="display: none;" class="alert alert-success" role="alert">
            This is a success alert—check it out!
        </div>
    </div>
    <div class="col-12">
        <div id="warning-alert" style="display: none;" class="alert alert-warning" role="alert">
            This is a warning alert—check it out!
        </div>
    </div>
	<div class="col-md-3 col-xs-12">
		<div class="card text-center">
            <?php if ($guild->icon == NULL) { ?>
                <img class="card-img" src="https://ui-avatars.com/api/?name=<?=urlencode($guild->name)?>&size=128" alt="Image">
            <?php } else { ?>
                <img class="card-img" src="https://cdn.discordapp.com/icons/<?=$guild->id?>/<?=$guild->icon?>.png" alt="Image">
            <?php } ?>
			<div class="card-body">
				<h5 class="card-title"><?=$guild->name?></h5>
				<a class="btn btn-block btn-danger" href="<?=createPath('server.php?reset')?>">Switch Server</a>
			</div>
		</div>
	</div>

	<div class="col-md-8 col-xs-12">
        <p class="lead">Edit the values below then click save when done.</p>
        <form id="form">
            <div class="card mb-4">
                <div class="card-body">
                    <label for="setting-prefix" style="font-size: 1.2rem;"><i class="fas fa-angle-double-right"></i> Prefix</label>
                    <input value="<?=$data['prefix'] != null ? $data['prefix'] : ''?>" id="setting-prefix" name="setting-prefix" type="text" class="form-control" pattern=".{1,}" required title="1 character minimum">
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <label for="setting-welcome-channel" style="font-size: 1.2rem;"><i class="fas fa-chevron-circle-down"></i> Welcome Channel</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">#</span>
                        </div>
                        <select id="setting-welcome-channel" name="setting-welcome-channel" class="form-control">
                            <?php
                            // https://discordapp.com/developers/docs/resources/channel#channel-object-channel-types
                            define('TEXT_CHANNEL', 0);
                            define('CHANNEL_CATEGORY', 4);
                            if (!isset($mapped)) {
                                $mapped = getTextChannelsIdMapped($id);
                            }
                            foreach (getTextChannelsCategorized($id) as $categoryId => $channels) {
                                $category = $mapped[$categoryId];
                                ?>
                                <option disabled>&#x25bc; <?=$category->name?></option>
                                <?php
                                foreach($channels as $channel) {
                                    ?>
                                    <option <?=$channel->id == $data['welcome_channel'] ? 'selected ' : ''?>value="<?=$channel->id?>"><?=$channel->name?></option>
                                    <?php
                                }
                            }
                            ?>
                            <option <?=$data['welcome_channel'] == 'none' ? 'selected ' : ''?>value="none">None</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <label for="setting-welcome-color" style="font-size: 1.2rem;"><i class="fas fa-palette"></i> Welcome Color</label>
                    <input value="<?=$data['welcome_color'] != null ? $data['welcome_color'] : ''?>" id="setting-welcome-color" name="setting-welcome-color-picker" type="text" class="form-control" pattern="(hex|rgb):.*" required title="Prefix with rgb: or hex:#">
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <label for="setting-welcome-image" style="font-size: 1.2rem;"><i class="fas fa-image"></i> Welcome Image</label>
                            <select class="form-control" id="setting-welcome-image" style="overflow: auto;">
                                <?php
                                foreach(config('imageSelect.images') as $name) {
                                    ?>
                                    <option <?=$name == $data['welcome_image'] ? 'selected ' : ''?>value="<?=$name?>"><?=$name?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <img id="preview-img" class="card-img-top" src="//via.placeholder.com/320x96" alt="Welcome Image Preview">
                        </div>
                    </div>
                </div>
            </div>
            <button id="submit-button" type="submit" class="btn btn-info btn-raised float-md-right">Save Changes</button>
        </form>
	</div>
</div>