<?php

namespace App\Services;

use Common\Channels\GenerateChannelsFromConfig;

class GenerateDefaultChannels
{
    public function execute(): void
    {
        (new GenerateChannelsFromConfig())->execute([
            resource_path('defaults/channels/shared-channels.json'),
            resource_path('defaults/channels/default-channels.json'),
        ]);
    }

}
