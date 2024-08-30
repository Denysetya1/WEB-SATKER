import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/jaocero/radio-deck/resources/views/**/*.blade.php',
        './vendor/andrewdwallo/filament-selectify/resources/views/**/*.blade.php',
        './vendor/awcodes/filament-badgeable-column/resources/**/*.blade.php',
        './vendor/bezhansalleh/filament-exceptions/resources/views/**/*.blade.php',
    ],
}
