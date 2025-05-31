import { ref } from 'vue';

const currentLanguage = ref('en');
const messages = ref({});

const setLanguage = async (lang) => {
    currentLanguage.value = lang;

    try {
        const module = await import(`../language/${lang}.json`);
        messages.value = module.default || module;
    } catch (error) {
        console.error(`Error loading language file for ${lang}`, error);
        messages.value = {};
    }
};

setLanguage(currentLanguage.value);

const translate = (key) => {
    if (!messages.value || typeof key !== 'string') {
        return key;
    }

    const value = messages.value[key.toUpperCase()];
    return value !== undefined ? value : key;
};

export { currentLanguage, messages, setLanguage, translate };
