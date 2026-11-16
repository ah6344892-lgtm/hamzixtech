<?php

namespace App\Services\AI;

use App\Contracts\AI\TextGenerationProvider;
use RuntimeException;

class AiManager
{
    /** @var array<string, class-string<TextGenerationProvider>> */
    private const PROVIDERS = [];

    public function available(): bool
    {
        $name = (string) config('hamzixtech.ai.provider');
        return isset(self::PROVIDERS[$name])
            && filled(config('hamzixtech.ai.api_key'))
            && filled(config('hamzixtech.ai.model'));
    }

    public function provider(): TextGenerationProvider
    {
        $name = (string) config('hamzixtech.ai.provider');
        $provider = self::PROVIDERS[$name] ?? null;
        if (! $provider || ! $this->available()) {
            throw new RuntimeException('No AI provider is installed and configured.');
        }

        return app($provider);
    }
}
