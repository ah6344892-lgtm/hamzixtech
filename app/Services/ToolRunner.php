<?php

namespace App\Services;

use Illuminate\Support\Str;
use InvalidArgumentException;
use JsonException;

class ToolRunner
{
    public function run(string $slug, string $input, string $operation = 'format'): string
    {
        return match ($slug) {
            'json-formatter' => $this->formatJson($input),
            'text-utilities' => $this->transformText($input, $operation),
            'slug-generator' => Str::slug($input),
            'url-encoder-decoder' => $operation === 'decode' ? urldecode($input) : urlencode($input),
            default => throw new InvalidArgumentException('This tool does not have a configured operation.'),
        };
    }

    private function formatJson(string $input): string
    {
        $decoded = json_decode($input, true, 512, JSON_THROW_ON_ERROR);

        return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }

    private function transformText(string $input, string $operation): string
    {
        return match ($operation) {
            'uppercase' => mb_strtoupper($input),
            'lowercase' => mb_strtolower($input),
            'trim' => trim($input),
            'count' => 'Characters: '.mb_strlen($input).' | Words: '.str_word_count($input),
            default => throw new InvalidArgumentException('Choose a text operation.'),
        };
    }
}
