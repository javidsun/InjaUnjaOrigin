<template>
    <v-dialog v-model="isModalOpen" max-width="800px" persistent>
        <v-card class="rounded-lg">
            <v-card-title class="header">
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <span class="text-h5 font-weight-bold">{{ translate('ROLE_AND_PERMISSION') }}</span>

            </v-card-title>

            <v-card-text class="pa-0">
                <v-tabs v-model="tab" grow color="primary" slider-color="accent">
                    <v-tab value="role" class="font-weight-bold">
                        <v-icon left>mdi-account-star</v-icon>
                        {{ translate('ACCESS_LEVEL') }}
                    </v-tab>
                    <v-tab value="permissions" class="font-weight-bold">
                        <v-icon left>mdi-key-chain</v-icon>
                        {{ translate('ACCESSES') }}
                    </v-tab>

                </v-tabs>

                <v-divider></v-divider>

                <v-window v-model="tab">
                    <v-window-item value="role">
                        <div class="pa-6">
                            <v-alert
                                v-if="pendingRoleRequest"
                                type="info"
                                border="left"
                                class="mb-6"
                            >
                                <div class="d-flex align-center">
                                    <v-icon left>mdi-clock</v-icon>
                                    <span>
                                   {{ translate('REQUEST_LEVEL_UPGRADE') }}

                                        <strong>{{ pendingRoleRequest.requestedRoleName }}</strong>
                                   {{ translate('UNDER_REVIEW') }}

                                    </span>
                                </div>
                                <div class="mt-2 text-caption">

                                    {{ translate('APPLICATION_DATE') }}

                                    {{ pendingRoleRequest.date }}</div>
                            </v-alert>

                            <div class="current-role-box pa-4 mb-6 rounded-lg" :class="roleStatusClass">
                                <h3 class="d-flex align-center mb-2">
                                    <v-icon :color="currentRole.color" class="ml-2">{{ currentRole.icon }}</v-icon>
                                    {{ translate('CURRENT_ACCESS_LEVEL') }}

                                    <span :class="`${currentRole.color}--text font-weight-bold mr-1`">{{ currentRole.name }}</span>
                                </h3>
                                <p class="text-caption mb-0">{{ currentRole.description }}</p>
                                <v-chip small class="mt-2" :color="currentRole.color" dark>
                                    {{ roleStatusText }}
                                </v-chip>
                            </div>

                            <v-divider class="my-4"></v-divider>

                            <h4 class="mb-3 d-flex align-center">
                                <v-icon color="primary" class="ml-2">mdi-account-arrow-up</v-icon>

                                {{ translate('REQUEST_CHANGE_LEVEL') }}

                            </h4>

                            <v-select
                                v-model="requestedRole"
                                :items="availableRoles"
                                item-text="name"
                                item-value="id"
                                label="سطح دسترسی مورد نظر"
                                outlined
                                prepend-inner-icon="mdi-account-cog"
                                class="mb-4"
                                :menu-props="{ contentClass: 'role-menu' }"
                                :disabled="pendingRoleRequest"
                            >
                                <template v-slot:item="{ item }">
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold">{{ item.name }}</span>
                                        <span class="text-caption">{{ item.description }}</span>
                                        <v-chip x-small class="mt-1 align-self-start" :color="item.color" dark v-if="item.requiresApproval">
                                            {{ translate('REQUIRE_APPROVAL') }}

                                        </v-chip>
                                    </div>
                                </template>
                            </v-select>

                            <v-textarea
                                v-model="roleChangeReason"
                                label="دلیل درخواست (اختیاری)"
                                outlined
                                rows="3"
                                prepend-inner-icon="mdi-text-box"
                                counter="200"
                                :rules="[v => !v || v.length <= 200 || 'حداکثر 200 کاراکتر مجاز است']"
                                :disabled="pendingRoleRequest"
                            ></v-textarea>

                            <v-btn
                                color="primary"
                                @click="requestRoleChange"
                                :disabled="!requestedRole || requestedRole === currentRole.id || pendingRoleRequest"
                                block
                                large
                                class="mt-2"
                                depressed
                            >
                                <v-icon left>mdi-send</v-icon>
                                {{ pendingRoleRequest ? 'درخواست در حال بررسی' : 'ارسال درخواست' }}
                            </v-btn>
                        </div>
                    </v-window-item>

                    <v-window-item value="permissions">
                        <div class="pa-6">
                            <div class="d-flex align-center mb-4">
                                <v-icon color="primary" class="ml-2">mdi-shield-key</v-icon>
                                <h3>
                                    {{ translate('EXCLUSIVE_ACCESSES') }}
                                </h3>
                            </div>
                            <p class="text-caption mb-6">
                                {{ translate('MANAGE_PERSONAL_ACCESS') }}

                                </p>

                            <v-alert
                                v-if="permissionChangesPending"
                                type="warning"
                                border="left"
                                class="mb-6"
                            >
                                <div class="d-flex align-center">
                                    <v-icon left>mdi-alert</v-icon>
                                    <span>
                                   {{ translate('UNSAVED_CHANGE') }}

                                    </span>
                                </div>
                            </v-alert>

                            <v-divider class="my-4"></v-divider>

                            <v-expansion-panels accordion flat multiple v-model="expandedPanels">
                                <v-expansion-panel v-for="(group, index) in userPermissions" :key="index">
                                    <v-expansion-panel-header class="font-weight-bold">
                                        <v-icon left>{{ group.icon }}</v-icon>
                                        {{ group.name }}
                                        <v-chip x-small class="ml-2" color="primary" text-color="white">
                                            {{ enabledPermissionsCount(group) }}/{{ group.permissions.length }}
                                        </v-chip>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-checkbox
                                            v-for="perm in group.permissions"
                                            :key="perm.id"
                                            v-model="perm.enabled"
                                            :label="perm.name"
                                            :disabled="perm.required"
                                            color="primary"
                                            class="mt-1"
                                            dense
                                            @change="onPermissionChange"
                                        >
                                            <template v-slot:append>
                                                <v-tooltip top>
                                                    <template v-slot:activator="{ on }">
                                                        <v-icon small color="grey" v-on="on">mdi-information</v-icon>
                                                    </template>
                                                    <span>{{ perm.description }}</span>
                                                </v-tooltip>
                                            </template>
                                        </v-checkbox>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>

                            <v-btn
                                color="primary"
                                @click="savePermissions"
                                block
                                large
                                class="mt-6"
                                depressed
                                :loading="isSavingPermissions"
                            >
                                <v-icon left>mdi-content-save</v-icon>
                                {{ translate('SAVE') }}

                            </v-btn>
                        </div>
                    </v-window-item>

                </v-window>
            </v-card-text>

            <v-snackbar v-model="alert.show" :color="alert.color" top right :timeout="alert.timeout">
                <div class="d-flex align-center">
                    <v-icon left dark>{{ alert.icon }}</v-icon>
                    {{ alert.message }}
                </div>
                <template v-slot:action="{ attrs }">
                    <v-btn
                        text
                        v-bind="attrs"
                        @click="alert.show = false"
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </template>
            </v-snackbar>
        </v-card>
    </v-dialog>
</template>

<script>
import { translate } from '@/store/languageStore';

export default {
    data() {
        return {
            translate,
            isModalOpen: false,
            tab: 'role',
            notificationTab: 'offers',
            expandedPanels: [0, 1],
            internalNotificationTab: 'offers',
            currentRole: {
                id: 3,
                name: 'کاربر عادی',
                description: 'دسترسی به امکانات پایه سیستم',
                icon: 'mdi-account',
                color: 'blue'
            },
            availableRoles: [
                {
                    id: 2,
                    name: 'ویرایشگر',
                    description: 'امکان ایجاد و ویرایش محتوا',
                    icon: 'mdi-account-edit',
                    color: 'teal',
                    requiresApproval: true
                },
                {
                    id: 1,
                    name: 'مدیر',
                    description: 'دسترسی کامل به سیستم',
                    icon: 'mdi-account-cog',
                    color: 'orange',
                    requiresApproval: true
                },
            ],
            requestedRole: null,
            roleChangeReason: '',
            pendingRoleRequest: null,

            userPermissions: [
                {
                    name: 'تنظیمات حریم خصوصی',
                    icon: 'mdi-account-lock',
                    permissions: [
                        {
                            id: 'privacy.profile',
                            name: 'نمایش پروفایل برای عموم',
                            enabled: true,
                            required: false,
                            description: 'اجازه نمایش پروفایل شما به کاربران دیگر'
                        },
                        {
                            id: 'privacy.activity',
                            name: 'نمایش فعالیت‌های اخیر',
                            enabled: true,
                            required: false,
                            description: 'نمایش آخرین فعالیت‌های شما در پروفایل'
                        },
                    ],
                },
                {
                    name: 'اعلان‌ها و ارتباطات',
                    icon: 'mdi-bell',
                    permissions: [
                        {
                            id: 'notifications.email',
                            name: 'دریافت اعلان‌های ایمیلی',
                            enabled: true,
                            required: false,
                            description: 'دریافت اعلان‌های سیستم از طریق ایمیل'
                        },
                        {
                            id: 'notifications.sms',
                            name: 'دریافت اعلان‌های پیامکی',
                            enabled: false,
                            required: false,
                            description: 'دریافت اعلان‌های مهم از طریق پیامک'
                        },
                    ],
                },
            ],
            permissionChangesPending: false,
            isSavingPermissions: false,

            notifications: {
                recognition: true,
                insights: true,
                pricing: true,
                hosting: true,
                news: true,
                regulations: true,
                inspiration: true,
                tripPlanning: true,
                activityList: true,
                guestPolicies: true,
                hostPolicies: true,
                reminders: true,
                messages: true,
            },
            isSavingNotifications: false,

            alert: {
                show: false,
                message: '',
                color: 'success',
                icon: 'mdi-check-circle',
                timeout: 5000
            }
        };
    },
    computed: {
        roleStatusText() {
            if (this.pendingRoleRequest) {
                return 'در حال بررسی درخواست';
            }
            return this.currentRole.id === 1 ? 'فعال (مدیر سیستم)' :
                this.currentRole.id === 2 ? 'فعال (ویرایشگر)' : 'فعال (کاربر عادی)';
        },
        roleStatusClass() {
            return {
                'blue lighten-5': this.currentRole.id === 3,
                'teal lighten-5': this.currentRole.id === 2,
                'orange lighten-5': this.currentRole.id === 1,
                'border-left-blue': this.currentRole.id === 3,
                'border-left-teal': this.currentRole.id === 2,
                'border-left-orange': this.currentRole.id === 1
            };
        }
    },
    methods: {
        showNotificationAlert(settingName) {
            const settingState = this.notifications[settingName] ? 'فعال شد' : 'غیرفعال شد';
            this.showAlert(`تنظیمات اعلان ${settingName} ${settingState}`, 'success');
        },
        openModal() {
            this.isModalOpen = true;
            this.fetchUserData();
        },
        closeModal() {
            this.isModalOpen = false;
        },

        async fetchUserData() {
            try {
                // شبیه‌سازی دریافت داده از API
                // const response = await this.$api.get('/user/permissions');
                // this.currentRole = response.data.role;
                // this.userPermissions = response.data.permissions;
                // this.notifications = response.data.notifications;
                // this.pendingRoleRequest = response.data.pendingRequest;

                // شبیه‌سازی داده‌های نمونه
                this.pendingRoleRequest = null;

            } catch (error) {
                this.showAlert('خطا در دریافت اطلاعات کاربر', 'error');
            }
        },

        async requestRoleChange() {
            try {
                const requestedRole = this.availableRoles.find(r => r.id === this.requestedRole);
                this.pendingRoleRequest = {
                    requestedRoleId: this.requestedRole,
                    requestedRoleName: requestedRole.name,
                    date: new Date().toLocaleDateString('fa-IR'),
                    status: 'pending'
                };

                this.showAlert('درخواست تغییر سطح دسترسی با موفقیت ارسال شد', 'success');
                this.requestedRole = null;
                this.roleChangeReason = '';

            } catch (error) {
                this.showAlert('خطا در ارسال درخواست تغییر سطح دسترسی', 'error');
            }
        },

        async savePermissions() {
            this.isSavingPermissions = true;
            try {
                await new Promise(resolve => setTimeout(resolve, 1000));
                this.showAlert('تنظیمات دسترسی با موفقیت ذخیره شد', 'success');
                this.permissionChangesPending = false;
            } catch (error) {
                this.showAlert('خطا در ذخیره تنظیمات دسترسی', 'error');
            } finally {
                this.isSavingPermissions = false;
            }
        },

        onPermissionChange() {
            this.permissionChangesPending = true;
        },

        enabledPermissionsCount(group) {
            return group.permissions.filter(p => p.enabled).length;
        },

        showAlert(message, type = 'success') {
            const icons = {
                success: 'mdi-check-circle',
                error: 'mdi-alert-circle',
                warning: 'mdi-alert',
                info: 'mdi-information'
            };

            this.alert = {
                show: true,
                message,
                color: type,
                icon: icons[type] || 'mdi-information',
                timeout: type === 'error' ? 8000 : 5000
            };
        }
    }
};
</script>

<style scoped>
.dialog-header {
    padding: 16px 24px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.current-role-box {
    border-left: 4px solid;
}

.border-left-blue {
    border-left-color: #2196F3;
}
.border-left-teal {
    border-left-color: #009688;
}
.border-left-orange {
    border-left-color: #FF9800;
}

.v-expansion-panel::before {
    box-shadow: none;
}

.role-menu .v-list-item {
    border-bottom: 1px solid #eee;
    padding: 12px 16px;
}

.role-menu .v-list-item:last-child {
    border-bottom: none;
}

.notification-section {
    margin-bottom: 24px;
}

.notification-section:last-child {
    margin-bottom: 0;
}

.tab-content {
    padding: 10px;
}

.section {
    margin-bottom: 20px;
}

.toggle-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
}

.text-success {
    color: #4CAF50;
}

.text-error {
    color: #F44336;
}
.rounded-lg{
    border-radius: 15px !important;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    animation: slideIn 0.3s ease-out;

}

</style>
