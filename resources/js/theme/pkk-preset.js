import Preset from '@primeuix/themes/aura';
import { definePreset, palette } from '@primeuix/themes';

// Warna utama brand PKK DIY: #0d76b6 (shade 500)
const customThemePreset = definePreset(Preset, {
    semantic: {
        primary: palette('#0d76b6'),
        colorScheme: {
            light: {
                primary: {
                    color: '{primary.500}',
                    contrastColor: '#ffffff',
                    hoverColor: '{primary.400}',
                    activeColor: '{primary.600}',
                },
            },
            dark: {
                primary: {
                    color: '{primary.400}',
                    contrastColor: '{surface.900}',
                    hoverColor: '{primary.300}',
                    activeColor: '{primary.200}',
                },
            },
        },
    },
});

export default customThemePreset;
