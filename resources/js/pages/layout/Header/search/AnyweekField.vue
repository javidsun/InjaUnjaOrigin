<template>
    <v-col class="field-wrapper" position="relative">
        <div class="field-content" @click="showCalendar = true">
            <img src="/assets/images/calendar-icon.png" alt="Calendar Icon" class="icon-img" />
            <span class="field-text" v-show="!isMobile">{{ translate('ANYWEEK_ANYWEEK') }}</span>
        </div>

        <v-dialog v-model="showCalendar" max-width="350px" class="custom-dialog" @click:outside="closeCalendar">
            <v-card>
                <v-card-text @click.stop>
                    <v-date-picker v-model="selectedDates" multiple></v-date-picker>
                </v-card-text>
                <v-card-actions @click.stop>
                    <v-btn color="primary" @click="handleDateSelection">{{ translate('SEARCH') }}</v-btn>
                    <v-btn color="grey" text @click="closeCalendar">{{ translate('CANCEL') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-col>
</template>

<script>
import { translate } from '@/store/languageStore';

export default {
    name: 'DateRangePicker',
    data() {
        return {
            showCalendar: false,
            selectedDates: [],
            isMobile: false,
            windowWidth: 0
        };
    },
    mounted() {
        try {
            this.checkMobileView();
            window.addEventListener('resize', this.handleResize);
        } catch (error) {
            this.handleError('Initialization error', error);
        }
    },
    beforeDestroy() {
        try {
            window.removeEventListener('resize', this.handleResize);
        } catch (error) {
            this.handleError('Cleanup error', error);
        }
    },
    methods: {
        translate,

        handleDateSelection() {
            try {
                if (this.selectedDates.length === 0) {
                    this.showAlert(this.translate('NO_DATES_APPLIED'));
                    return;
                }

                this.$emit('dates-selected', this.selectedDates);
                this.showCalendar = false;
                this.showSuccess(this.translate('DATES_APPLIED'));
            } catch (error) {
                this.handleError('Date selection error', error);
            }
        },

        closeCalendar() {
            this.showCalendar = false;
        },

        checkMobileView() {
            this.windowWidth = window.innerWidth;
            this.isMobile = this.windowWidth < 768;
        },

        handleResize() {
            try {
                this.checkMobileView();
            } catch (error) {
                this.handleError('Resize handler error', error);
            }
        },

        showSuccess(message) {
            this.$emit('show-alert', {
                type: 'success',
                message: message,
                duration: 3000
            });
        },
        showAlert(message) {
            this.$store.dispatch('showNotification', {
                type: 'warning',
                message: message
            });
        },

        handleError(context, error) {
            this.$store.dispatch('showNotification', {
                type: 'error',
                message: `${context}: ${error.message}`
            });
        }
    }
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
    transition: background-color 0.3s, color 0.3s;
}

.icon-img {
    width: 40px;
    height: 40px;
}
.custom-dialog{
    padding-top: 300px;
}
.field-text {
    font-size: 14px;
}

</style>
