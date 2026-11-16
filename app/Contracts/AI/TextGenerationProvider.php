<?php

namespace App\Contracts\AI;

interface TextGenerationProvider
{
    public function generate(string $prompt): string;
}
