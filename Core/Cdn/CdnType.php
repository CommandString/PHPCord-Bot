<?php

namespace Core\Cdn;

enum CdnType: string
{
    case CUSTOM_EMOJI = '/emojis/emoji_id';
    case GUILD_ICON = '/icons/guild_id/guild_icon';
    case GUILD_SPLASH = '/splashes/guild_id/guild_splash';
    case GUILD_DISCOVERY_SPLASH = '/discovery-splashes/guild_id/guild_discovery_splash';
    case GUILD_BANNER = '/banners/guild_id/guild_banner';
    case USER_BANNER = '/banners/user_id/user_banner';
    case DEFAULT_USER_AVATAR = '/embed/avatars/index.png';
    case USER_AVATAR = '/avatars/user_id/user_avatar.png';
    case GUILD_MEMBER_AVATAR = '/guilds/guild_id/users/user_id/avatars/member_avatar.png';
    case USER_AVATAR_DECORATION = '/avatar-decorations/user_id/user_avatar_decoration.png';
    case APPLICATION_ICON = '/app-icons/application_id/icon.png';
    case APPLICATION_COVER = '/app-icons/application_id/cover_image.png';
    case APPLICATION_ASSET = '/app-assets/application_id/asset_id.png';
    case ACHIEVEMENT_ICON = '/app-assets/application_id/achievements/achievement_id/icons/icon_hash.png';
    case STORE_PAGE_ASSET = '/app-assets/application_id/store/asset_id';
    case STICKER_PACK_BANNER = '/app-assets/710982414301790216/store/sticker_pack_banner_asset_id.png';
    case TEAM_ICON = '/team-icons/team_id/team_icon.png';
    case STICKER = '/stickers/sticker_id.png';
    case ROLE_ICON = '/role-icons/role_id/role_icon.png';
    case GUILD_SCHEDULED_EVENT_COVER = '/guild-events/scheduled_event_id/scheduled_event_cover_image.png';
    case GUILD_MEMBER_BANNER = '/guilds/guild_id/users/user_id/banners/member_banner.png';
}
