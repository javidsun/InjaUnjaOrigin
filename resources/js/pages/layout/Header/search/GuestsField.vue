<template>
    <v-col class="field-wrapper" position="relative">
        <div class="field-content" @click="toggleMenu">
            <img
                src="/assets/images/guests-icon.png"
                alt="Guests Icon"
                class="icon-img"
            />
            <span class="field-text" v-show="!isMobile">{{ translate('GUESTS_TITLE') }}</span>
        </div>

        <div v-if="isActive" class="modal-overlay" @click="toggleMenu"></div>

        <div v-if="isActive" class="modal-content">
            <div class="guest-field">
                <div class="guest-info">
                    <span class="guest-title">{{ translate('GUESTS_ADULTS') }}</span>
                    <span class="guest-subtitle">{{ translate('GUESTS_ADULTSSUBTITLE') }}</span>
                </div>
                <div class="guest-controls">
                    <button @click.stop="decrement('adults')" :disabled="adults === 0" class="control-btn">-</button>
                    <span class="guest-count">{{ adults }}</span>
                    <button @click.stop="increment('adults')" class="control-btn">+</button>
                </div>
            </div>

            <div class="guest-field">
                <div class="guest-info">
                    <span class="guest-title">{{ translate('GUESTS_CHILDREN') }}</span>
                    <span class="guest-subtitle">{{ translate('GUESTS_CHILDRENSUBTITLE') }}</span>
                </div>
                <div class="guest-controls">
                    <button @click.stop="decrement('children')" :disabled="children === 0" class="control-btn">-</button>
                    <span class="guest-count">{{ children }}</span>
                    <button @click.stop="increment('children')" class="control-btn">+</button>
                </div>
            </div>

            <div class="guest-field">
                <div class="guest-info">
                    <span class="guest-title">{{ translate('GUESTS_INFANTS') }}</span>
                    <span class="guest-subtitle">{{ translate('GUESTS_INFANTSSUBTITLE') }}</span>
                </div>
                <div class="guest-controls">
                    <button @click.stop="decrement('infants')" :disabled="infants === 0" class="control-btn">-</button>
                    <span class="guest-count">{{ infants }}</span>
                    <button @click.stop="increment('infants')" class="control-btn">+</button>
                </div>
            </div>

            <div class="guest-field">
                <div class="guest-info">
                    <span class="guest-title">{{ translate('GUESTS_PETS') }}</span>
                    <span class="guest-subtitle">{{ translate('GUESTS_PETSSUBTITLE') }}</span>
                </div>
                <div class="guest-controls">
                    <button @click.stop="decrement('pets')" :disabled="pets === 0" class="control-btn">-</button>
                    <span class="guest-count">{{ pets }}</span>
                    <button @click.stop="increment('pets')" class="control-btn">+</button>
                </div>
            </div>
        </div>
    </v-col>
</template>

<script>
import { translate } from '@/store/languageStore';

export default {
    setup() {
        return { translate };
    },
    props: {
        activeMenu: String,
    },
    data() {
        return {
            isMobile: false,
            adults: 0,
            children: 0,
            infants: 0,
            pets: 0,
        };
    },
    computed: {
        isActive() {
            return this.activeMenu === "Guests";
        },
    },
    methods: {
        toggleMenu() {
            this.$emit("update-active-menu", this.isActive ? null : "Guests");
        },
        increment(type) {
            this[type]++;
        },
        decrement(type) {
            if (this[type] > 0) this[type]--;
        },
        checkScreenSize() {
            this.isMobile = window.innerWidth <= 950;
        },
    },
    mounted() {
        this.checkScreenSize();
        window.addEventListener("resize", this.checkScreenSize);
    },
    beforeDestroy() {
        window.removeEventListener("resize", this.checkScreenSize);
    },
};
</script>

<style scoped>
.field-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: pointer;
}

.field-content {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-color);
    background-color: var(--background-color);
    padding: 10px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    transition: background-color 0.3s ease, color 0.3s ease;
}

.icon-img {
    width: 40px;
    height: 40px;
}

.field-text {
    font-size: 14px;
}

/* Modal Overlay Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9998;
}

/* Modal Content Styles */
.modal-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 400px;
    background: var(--search-background-color);
    color: var(--text-color);
    z-index: 9999;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
    padding: 20px;
    box-sizing: border-box;
    max-height: 80vh;
    overflow-y: auto;
    line-height: 1.2;
    transition: all 0.3s ease;
}

.guest-field {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 12px 0;
    padding: 12px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: var(--background-color--groups);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.guest-info {
    display: flex;
    flex-direction: column;
}

.guest-title {
    font-weight: bold;
    color: var(--text-color);
    font-size: 14px;
}

.guest-subtitle {
    font-size: 12px;
    color: var(--text-color);
    opacity: 0.8;
}

.guest-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.control-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--search-background-color);
    border: 1px solid var(--border-color);
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-color);
    transition: all 0.2s ease;
}

.control-btn:hover:not(:disabled) {
    background: var(--border-color);
}

.control-btn:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

.guest-count {
    min-width: 24px;
    text-align: center;
    font-weight: bold;
    color: var(--text-color);
}

@media (max-width: 768px) {
    .modal-content {
        width: 85%;
        padding: 15px;
    }

    .guest-field {
        padding: 10px;
        margin: 10px 0;
    }

    .guest-title {
        font-size: 13px;
    }

    .guest-subtitle {
        font-size: 11px;
    }

    .control-btn {
        width: 28px;
        height: 28px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .modal-content {
        width: 90%;
        padding: 12px;
    }

    .guest-field {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .guest-controls {
        width: 100%;
        justify-content: space-between;
    }

    .field-text {
        display: none;
    }

    .icon-img {
        width: 30px;
        height: 30px;
    }
}
</style>
