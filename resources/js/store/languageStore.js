import { ref } from 'vue';

const currentLanguage = ref('en');
const messages = ref({});

const setLanguage = (lang) => {
    currentLanguage.value = lang;

    if (lang === 'fa') {
        import('../language/fa.js').then((module) => {
            messages.value = module.default;
        });
    } else {
        import('../language/en.js').then((module) => {
            messages.value = module.default;
        });
    }
};

setLanguage(currentLanguage.value);

const translate = (key) => {
    if (!messages.value) return key;

    if (typeof key !== 'string') {
        return key;
    }

    const keys = key.split('.');
    let result = messages.value;

    for (const k of keys) {
        if (result && result[k] !== undefined) {
            result = result[k];
        } else {
            return key;
        }
    }

    return result || key;
};

export { currentLanguage, messages, setLanguage, translate };
