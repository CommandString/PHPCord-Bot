<?php

$string = "
Custom Emoji---emojis/'emoji_id'
Guild Icon---icons/'guild_id'/'guild_icon'
Guild Splash---splashes/'guild_id'/'guild_splash'
Guild Discovery Splash---discovery-splashes/guild_id/guild_discovery_splash
Guild Banner---banners/guild_id/guild_banner
User Banner---banners/user_id/user_banner
Default User Avatar---embed/avatars/index.png
User Avatar---avatars/user_id/user_avatar.png
Guild Member Avatar---guilds/guild_id/users/user_id/avatars/member_avatar.png
User Avatar Decoration---avatar-decorations/user_id/user_avatar_decoration.png
Application Icon---app-icons/application_id/icon.png
Application Cover---app-icons/application_id/cover_image.png
Application Asset---app-assets/application_id/asset_id.png
Achievement Icon---app-assets/application_id/achievements/achievement_id/icons/icon_hash.png
Store Page Asset---app-assets/application_id/store/asset_id
Sticker Pack Banner---app-assets/710982414301790216/store/sticker_pack_banner_asset_id.png
Team Icon---team-icons/team_id/team_icon.png
Sticker---stickers/sticker_id.png
Role Icon---role-icons/role_id/role_icon.png
Guild Scheduled Event Cover---guild-events/scheduled_event_id/scheduled_event_cover_image.png
Guild Member Banner---guilds/guild_id/users/user_id/banners/member_banner.png
";

$enums = [];

foreach (explode("\n", $string) as $line) {
    $split = explode("---", $line);

    if (count($split) !== 2) {
        continue;
    }

    [$name, $path] = $split;

    $name = strtoupper(str_replace(" ", "_", $name));
    $path = "/{$path}";

    $enums[] = [$name, $path];
}

echo "enum CdnType: string\n{\n";

foreach ($enums as [$name, $path]) {
    echo "    case {$name} = '{$path}';\n";
}

echo "}\n";
