<template class="modal">
    <v-dialog v-model="isOpen" max-width="600px" transition="dialog-transition">
        <v-card class="modal-container">
            <v-card-title class="header">
                <span>{{ translate('SETTING_PERSONALINFO') }}</span>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <div class="profile-info">
                    <v-avatar size="100" class="profile-avatar">
                        <img :src="userProfileImage" alt="Profile Picture" />
                    </v-avatar>
                    <h3 class="user-name">{{ userName }}</h3>
                    <v-chip color="blue" outlined class="verified-chip">{{ translate('SETTING_VERIFIED') }}</v-chip>
                </div>
                <v-list class="info-list">
                    <v-list-item v-for="(item, key) in user" :key="key">
                        <v-list-item-content class="list-item-content">
                            <v-icon>{{ icons[key] }}</v-icon>
                            <v-list-item-title>{{ translate(labels[key]) }}</v-list-item-title>
                            <v-list-item-subtitle v-if="!isEditing && key !== 'more'">{{ item }}</v-list-item-subtitle>
                            <v-textarea
                                v-else-if="isEditing && key === 'more'"
                                v-model="user[key]"
                                outlined
                                rows="3"
                                auto-grow
                            ></v-textarea>
                            <v-text-field
                                v-else-if="isEditing && key !== 'more'"
                                v-model="user[key]"
                                dense
                                outlined
                            ></v-text-field>
                            <v-list-item-subtitle v-else-if="key === 'more'" class="more-content">{{ item }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card-text>
            <v-card-actions>
                <v-btn block @click="toggleEdit" class="edit-btn">
                    {{ isEditing ? translate("SAVE") : translate("EDIT") }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { translate } from "@/store/languageStore";

export default {
    data() {
        return {
            isOpen: false,
            isEditing: false,
            userProfileImage: '/avatar-2.png',
            userName: 'آرش',
            user: {
                school: 'Polino',
                job: 'Developer',
                hobbies: 'Reading',
                traits: 'Creative',
                birthYear: '1990',
                languages: 'English, Persian',
                location: 'Tehran',
                more: 'فارغ التحصیل رشته معماری و بازاریابی دیجیتال. علاقه مند به سفر و تجربه کردن و آشنا شدن با فرهنگ های جدید. آشنا شدن با ادم های جدید.'
            },
            labels: {
                school: 'setting.school',
                job: 'setting.job',
                hobbies: 'setting.hobbies',
                traits: 'setting.traits',
                birthYear: 'setting.birthYear',
                languages: 'setting.languages',
                location: 'setting.location',
                more: 'setting.more',
            },
            icons: {
                school: 'mdi-school',
                job: 'mdi-briefcase',
                hobbies: 'mdi-heart',
                traits: 'mdi-star',
                birthYear: 'mdi-cake',
                languages: 'mdi-translate',
                location: 'mdi-map-marker',
            }
        }
    },
    methods: {
        openModal() {
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
            this.isEditing = false;
        },
        toggleEdit() {
            if (this.isEditing) {
                console.log('ذخیره تغییرات:', this.user);
            }
            this.isEditing = !this.isEditing;
        },
        translate(key) {
            return translate(key);
        }
    }
}
</script>

<style scoped>
.modal-container {
    border-radius: 15px !important;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    font-weight: bold;
    color: white;
    background-color: #3b3b3b;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.profile-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 24px;
    border-bottom: 1px solid #e0e0e0;
}

.profile-avatar {
    border: 4px solid #3ca6ff;
    transition: transform 0.3s ease;
}

.profile-avatar:hover {
    transform: scale(1.1);
}

.user-name {
    font-size: 1.5rem;
    font-weight: bold;
    color: #3ca6ff;
}

.verified-chip {
    margin-top: 8px;
}

.info-list {
    padding: 16px;
}

.info-list .v-list-item {
    padding: 12px 0;
    display: flex;
    align-items: center;
}

.info-list .v-list-item-icon {
    margin-right: 16px;
}

.list-item-content {
    display: flex;
    align-items: center;
    gap: 16px;
    width: 400px;
}

.list-item-content .v-list-item-title {
    font-weight: bold;
    color: #1976d2;
    min-width: 120px;
    font-size: 18px;
}

.list-item-content .v-list-item-subtitle {
    color: #b7b5b5;
    flex-grow: 1;
    font-size: 16px;
}
.list-item {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 8px;
}


.more-content {
    white-space: pre-wrap;
    word-wrap: break-word;
    max-width: 100%;
    overflow: auto;
    font-size: 0.8rem;
}

.edit-btn {
    margin: 16px;
    font-weight: bold;
    letter-spacing: 1px;
    background-color: #1976d2;
    color: white;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.edit-btn:hover {
    background-color: #1565c0;
    transform: translateY(-2px);
}

@media (max-width: 600px) {
    .user-name {
        font-size: 1.2rem;
    }
    .list-item-content{
        max-width: 100%;

    }
    .list-item-content .v-list-item-title {
        font-size: 12px;
    }

    .list-item-content .v-list-item-subtitle {
        font-size: 12px;
    }

    .more-content {
        font-size: 0.7rem;

    }

    .profile-avatar {
        width: 80px;
        height: 80px;
    }

    .edit-btn {
        font-size: 0.8rem;
    }
}
</style>
