//import '@fortawesome/fontawesome-pro/css/all.min.css'
import '@mdi/font/css/materialdesignicons.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'vuetify/dist/vuetify.min.css';
import '@/pages/plugins/vuetify/styles.scss'
import './styles.scss'

import { createVuetify } from 'vuetify'
import { VBtn, VCard, VIcon } from "vuetify/components";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { fa } from 'vuetify/iconsets/fa'
import { md,aliases as aliasesMd } from 'vuetify/iconsets/md'


const light = {
    dark: false,
    colors: {
        // TODO
    }
}

const dark = {
    dark: true,
    colors: {
        background: '#121212',
        'on-background': '#FFFFFF',
        surface: '#2F2F2F',
        'on-surface': '#FFFFFF',

        primary: '#448AFF',
        'on-primary': '#000000',
        'primary-over': '#14294C',
        'on-primary-over': '#FFFFFF',
        'primary-disabled': '#31548F',
        'on-primary-disabled': '#212121',

        secondary: '#E0E0E0',
        'on-secondary': '#212121',
        'secondary-over': '#424242',
        'on-secondary-over': '#FFFFFF',
        'secondary-disabled': '#212121',
        'on-secondary-disabled': '#424242',

        android: '#3DDA84',
        windows: '#0076FD',
        apple: '#FFFFFF',
        mixed: '#777777',

        switch: '#4CAF50',

        'table-header': '#212121',
        'table-row-even': '#121212',
        'table-row-odd': '#2F2F2F',
        'table-divider': '#616161',
        'pagination-footer': '#616161',

        error: '#FF797D',
        info: '#0D47A1',
        success: '#0da167',
        warning: '#e89413',

        'on-error': '#000000',
        'on-info': '#000000',
        'on-success': '#000000',
        'on-warning': '#000000',
    },
    variables: {
        // 'border-color': '#000000',
        // 'border-opacity': 0.12,
        // 'high-emphasis-opacity': 0.87,
        // 'medium-emphasis-opacity': 0.60,
        // 'disabled-opacity': 1,
        // 'idle-opacity': 0.04,
        // 'hover-opacity': 0.04,
        // 'focus-opacity': 0.12,
        // 'selected-opacity': 0.08,
        // 'activated-opacity': 0.12,
        // 'pressed-opacity': 0.12,
        // 'dragged-opacity': 0.08,
        // 'theme-kbd': '#212529',
        // 'theme-on-kbd': '#FFFFFF',
        // 'theme-code': '#F5F5F5',
        // 'theme-on-code': '#000000',
    }
}


// https://vuetifyjs.com/en/features/theme/
export default createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: 'dark',
        themes: {
            light, dark
        }
    },
    aliases: {
        VBtnPrimary: VBtn,
        VBtnSecondary: VBtn,
        VIconPrimary: VIcon,
        VBtnTableAction: VBtn,
        VBtnCloseCard: VBtn,
        VBtnCardAction: VBtn,
        VBtnAddAction: VBtn,
        VCardMain: VCard,
        VBtnPaginator: VBtn,
    },
    defaults: {
        VCard: {
            style: "border-color: rgb(var(--v-theme-primary)); !important"
        },
        VCardMain: {
            style: "border-color: rgb(var(--v-theme-primary)); !important",
            color: 'background',
            flat: true,
        },
        VBtnPrimary: {
            color: 'primary',
            variant: 'elevated'
        },
        VBtnSecondary: {
            color: 'secondary',
            variant: 'outlined'
        },
        VIconPrimary: {
            color: 'primary',
        },
        VBtnTableAction: {
            color: 'primary',
        },
        VBtnCloseCard: {
            variant: 'text',
            'box-shadow': 'none',
            icon: "mdi-close",
        },
        VBtnCardAction: {
            variant: 'text',
            'box-shadow': 'none',
            class: 'v-btn-card-action',
        },
        VSwitch: {
            color: 'switch',
            inset: true,
            hideDetails: true,
        },
        VCheckbox: {
            hideDetails: true
        },
        VBtnPaginator: {
            variant: 'text',
            icon: true,
        },
    },
    icons: {
        defaultSet: 'mdi', // This is already the default value - only for display purposes
        aliasesMd,
        sets: {
            fa,
            md
        },
    },
})
