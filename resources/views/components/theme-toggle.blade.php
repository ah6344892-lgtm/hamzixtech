<flux:button variant="subtle" square x-data="{ appearance: $flux.appearance, cycleAppearance() { const next = { system: 'light', light: 'dark', dark: 'system' } [this.appearance];
        $flux.appearance = next;
        this.appearance = next; } }" x-on:click="cycleAppearance()"
    x-bind:aria-label="'Theme: ' + appearance + '. Switch theme.'" x-bind:title="'Theme: ' + appearance"
    aria-label="Change theme" title="Change theme">
    <svg x-cloak x-show="appearance === 'light'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="1.7" class="size-4" aria-hidden="true">
        <circle cx="12" cy="12" r="4" />
        <path stroke-linecap="round"
            d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" />
    </svg>
    <svg x-cloak x-show="appearance === 'dark'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="1.7" class="size-4" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M20.2 15.1A8.5 8.5 0 0 1 8.9 3.8 8.5 8.5 0 1 0 20.2 15.1Z" />
    </svg>
    <svg x-cloak x-show="appearance === 'system'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="1.7" class="size-4" aria-hidden="true">
        <rect x="3" y="4" width="18" height="13" rx="2" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8m-4-4v4" />
    </svg>
</flux:button>
