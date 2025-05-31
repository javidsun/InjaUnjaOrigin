<template>
    <UserSidebar class="back">
        <v-container class="messages-container">
            <v-btn color="primary" @click="openNewMessageDialog" aria-label="Send new message">
                {{ translate('MESSAGE_NEWMESSAGE') }}
            </v-btn>

            <v-dialog v-model="uiState.newMessageDialog" max-width="500px">
                <v-card class="modal1">
                    <v-card-title>{{ translate('MESSAGE_NEWMESSAGE') }}</v-card-title>
                    <v-card-text>
                        <v-select v-model="messageData.newMessageType" :items="messageCategories" item-value="type" item-text="title" :label="translate('MESSAGE_SELECTCATEGORY')"></v-select>
                        <v-text-field v-model="messageData.newMessageUsername" :label="translate('MESSAGE_USERNAME')" dense outlined v-if="messageData.newMessageType === 'host' || messageData.newMessageType === 'guest'"></v-text-field>
                        <v-text-field v-model="messageData.newMessageText" :label="translate('MESSAGE_MESSAGETEXT')" dense outlined></v-text-field>
                        <v-file-input
                            @change="handleImageUpload"
                            :label="translate('MESSAGE_IMAGE_SELECTION')"
                            dense
                            outlined
                            accept="image/*">
                        </v-file-input>
                        <v-img v-if="uiState.previewImage" :src="uiState.previewImage" class="preview-image"></v-img>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" @click="sendNewMessage" :disabled="!messageData.newMessageText || (messageData.newMessageType !== 'support' && !messageData.newMessageUsername)">{{ translate('MESSAGE_SENDMESSAGE') }}</v-btn>
                        <v-btn text @click="closeNewMessageDialog">{{ translate('CLOSE') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-row>
                <v-col cols="12">
                    <div class="tabs">
                        <span
                            v-for="(category, index) in allCategories"
                            :key="index"
                            @click="selectCategory(category)"
                            :class="{'active-tab': uiState.selectedCategory === category.type}"
                        >
                            {{ category.title }}
                        </span>
                    </div>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-list class="messages-list">
                        <v-list-item v-for="(message, index) in filteredMessages.slice(0, 5)" :key="index" class="message-item" @click="openMessage(message)" :disabled="message.closed">
                            <v-list-item-avatar>
                                <v-avatar>
                                    <img :src="message.avatar" alt="avatar" class="avatar-img" />
                                </v-avatar>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>{{ message.sender }}</v-list-item-title>
                                <v-list-item-subtitle :class="{'approved': message.approved, 'pending': !message.approved}">
                                    {{ sanitizeMessage(message.preview) }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action>
                                <span class="message-time">{{ message.time }}</span>
                                <span :class="{'approved': message.approved, 'pending': !message.approved}">
                                    {{ message.status }}
                                </span>
                                <v-btn class="message-time2" color="red" @click.stop="closeMessage(message)">{{ translate('CLOSE') }}</v-btn>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>

            <v-dialog v-model="uiState.selectedMessage" max-width="500px">
                <v-card v-if="uiState.selectedMessage">
                    <v-card-title>{{ uiState.selectedMessage.sender }}</v-card-title>
                    <v-card-text>
                        {{ sanitizeMessage(uiState.selectedMessage.fullText) }}
                        <div v-if="uiState.selectedMessage.image">
                            <v-img v-if="uiState.selectedMessage.image" :src="uiState.selectedMessage.image" class="message-image"></v-img>
                        </div>
                        <div v-if="uiState.selectedMessage.replies">
                            <hr>
                            <div v-for="(reply, index) in uiState.selectedMessage.replies" :key="index" class="reply">
                                <p>{{ sanitizeMessage(reply.text) }} <span class="reply-time">{{ reply.time }}</span></p>
                                <v-img v-if="reply.image" :src="reply.image" class="reply-image"></v-img>
                            </div>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-text-field v-model="messageData.replyText" :label="translate('MESSAGE_REPLY')" dense outlined :disabled="uiState.selectedMessage.closed"></v-text-field>
                        <v-file-input
                            @change="handleReplyImageUpload"
                            :label="translate('MESSAGE_IMAGE_SELECTION')"
                            dense
                            outlined
                            accept="image/*">
                        </v-file-input>
                        <v-img v-if="uiState.replyPreviewImage" :src="uiState.replyPreviewImage" class="preview-image"></v-img>
                        <v-btn color="primary" @click="sendReply" :disabled="uiState.selectedMessage.closed">{{ translate('MESSAGE_SENDMESSAGE') }}</v-btn>
                        <v-btn text @click="closeMessageDialog">{{ translate('CLOSE') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </UserSidebar>
</template>

<script>
//Todo:id/sender:username-or-id/profileImage/preview/fullText/SendImage:image-or-null/time/type/approved/status/closed/replies:id/text/image/time/sender username-or-id

import UserSidebar from '../Layout.vue';
import { translate } from "@/store/languageStore";

export default {
    name: 'Message',
    components: {
        UserSidebar
    },
    data() {
        return {
            uiState: {
                newMessageDialog: false,
                selectedCategory: "all",
                selectedMessage: null,
                previewImage: null,
                replyPreviewImage: null
            },
            messageData: {
                newMessageUsername: "",
                newMessageType: null,
                newMessageText: "",
                replyText: "",
                newMessageImage: null,
                replyImage: null
            },
            allCategories: [
                { title: translate("MESSAGE_ALL"), type: "all" },
                { title: translate("MESSAGE_HOST"), type: "host" },
                { title: translate("MESSAGE_GUEST"), type: "guest" },
                { title: translate("MESSAGE_SUPPORT"), type: "support" }
            ],
            messageCategories: [
                { title: translate("MESSAGE_HOST"), type: "host" },
                { title: translate("MESSAGE_GUEST"), type: "guest" },
                { title: translate("MESSAGE_SUPPORT"), type: "support" }
            ],
            messages: [
                {
                    sender: "آرش",
                    avatar: "avatar-2.png",
                    preview: "سلام، چندتا سوال بابت اجاره اتاق داشتم. می خواس...",
                    fullText: "سلام، چندتا سوال ببت اجاره اتاق داشتم. می خواس... ",
                    time: " 1:10:10 PM",
                    type: "host",
                    approved: true,
                    status: "تایید شد. یک اتاق برای اجاره در یک خانه دو خوابه"
                },
                {
                    sender: "مریم",
                    avatar: "avatar-1.png",
                    preview: "سلام، برای سفر به سوئیس و این تور جنگل می تونم...",
                    fullText: "سلام، برای سفر به سوئیس و این تور جنگل می تونم...",
                    time: "  10:28:25 AM",
                    type: "guest",
                    approved: false,
                    status: "تایید نشده. یک اتاق برای اجاره در یک خانه دو خوابه"
                },
                {
                    sender: "کیارش",
                    avatar: "avatar3.svg",
                    preview: "وقت بخیر، من و دوستم دنبال دو نفر همسفر می گر...",
                    fullText: "وقت بخیر، من و دوستم دنبال دو نفر همسفر می گر...",
                    time: "01/03/2024 ",
                    type: "guest",
                    approved: true,
                    status: "تایید شد. جستجوی همسفر برای رفتن به سیسیل"
                },
                {
                    sender: "میترا",
                    avatar: "avatar4.svg",
                    preview: "وقت بخیر، من دوشنبه میرسم ونیز با چندتا از دوس...",
                    fullText: "وقت بخیر، من دوشنبه میرسم ونیز با چندتا از دوس...",
                    time: "02/02/2024  ",
                    type: "host",
                    approved: true,
                    status: "تایید شد. تور لیدر در شهر ونیز با ۸ سال سابقه"
                },
                {
                    sender: "پشتیبان InjaOnja",
                    avatar: "inja-unja.png",
                    preview: "شما، مراحل بازپرداخت را انجام دادم. تشکر",
                    fullText: "شما، مراحل بازپرداخت را انجام دادم. تشکر",
                    time: "01/02/2024   ",
                    type: "support",
                    approved: false,
                    status: "پایان"
                },
                {
                    sender: "پشتیبان InjaOnja",
                    avatar: "inja-unja.png",
                    preview: "مراحل جا به جایی را انجام دادم.",
                    fullText: "مراحل جا به جایی را انجام دادم.",
                    time: "5:17:04 PM",
                    type: "support",
                    approved: false,
                    status: "پایان",
                    closed: true
                }
            ]
        };
    },
    computed: {
        filteredMessages() {
            if (this.uiState.selectedCategory === "all") return this.messages;
            return this.messages.filter(msg => msg.type === this.uiState.selectedCategory);
        }
    },
    methods: {
        translate,
        openNewMessageDialog() {
            this.uiState.newMessageDialog = true;
        },

        closeNewMessageDialog() {
            this.uiState.newMessageDialog = false;
            this.resetNewMessageForm();
        },


        closeMessageDialog() {
            this.uiState.selectedMessage = null;
            this.resetReplyForm();
        },


        handleImageUpload(event) {
            try {
                const file = event.target.files[0];
                if (!file) return;

                if (this.uiState.previewImage) {
                    URL.revokeObjectURL(this.uiState.previewImage);
                }

                this.uiState.previewImage = URL.createObjectURL(file);
                this.messageData.newMessageImage = file;
            } catch (error) {
                this.showErrorAlert(this.translate('SECURITY_ERROR'));
            }
        },

        handleReplyImageUpload(event) {
            try {
                const file = event.target.files[0];
                if (!file) return;

                this.uiState.replyPreviewImage = URL.createObjectURL(file);
                this.messageData.replyImage = file;
            } catch (error) {
                this.showErrorAlert(this.translate('SECURITY_ERROR'));
            }
        },

        selectCategory(category) {
            this.uiState.selectedCategory = category.type;
        },

        openMessage(message) {
            if (!message.closed) {
                this.uiState.selectedMessage = message;
            }
        },

        closeMessage(message) {
            try {
                message.closed = true;
                if (this.uiState.selectedMessage === message) {
                    this.uiState.selectedMessage = null;
                }
                this.showSuccessAlert(this.translate('MESSAGE_CLOSED'));
            } catch (error) {
                this.showErrorAlert(this.translate('SECURITY_ERROR'));
            }
        },

        sendNewMessage() {
            try {
                if (!this.messageData.newMessageText.trim() || !this.messageData.newMessageType) {
                    throw new Error(this.translate('REQUIRED_FIELDS'));
                }

                const sanitizedText = this.sanitizeMessage(this.messageData.newMessageText);
                const newMessage = {
                    sender: "you",
                    avatar: "avatar1.svg",
                    preview: sanitizedText.slice(0, 20) + "...",
                    fullText: sanitizedText,
                    image: this.uiState.previewImage,
                    time: new Date().toLocaleTimeString(),
                    type: this.messageData.newMessageType,
                    approved: false,
                    status: "Awaiting review"
                };

                this.messages.unshift(newMessage);
                this.resetNewMessageForm();
                this.uiState.newMessageDialog = false;
                this.showSuccessAlert(this.translate('SEND_SUCCESS'));
            } catch (error) {
                this.showErrorAlert(error.message || this.translate('SECURITY_ERROR'));
            }
        },

        sanitizeMessage(message) {
            try {
                if (!message) return '';
                let sanitized = message;
                sanitized = sanitized.replace(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/g, '***');
                sanitized = sanitized.replace(/(\+|0)?9\d{9}/g, '***');
                return sanitized;
            } catch (error) {
                return message;
            }
        },

        sendReply() {
            try {
                if (!this.messageData.replyText.trim() || !this.uiState.selectedMessage || this.uiState.selectedMessage.closed) {
                    throw new Error(this.translate('INVALID_REPLY'));
                }

                if (!this.uiState.selectedMessage.replies) {
                    this.uiState.selectedMessage.replies = [];
                }

                const sanitizedText = this.sanitizeMessage(this.messageData.replyText);
                this.uiState.selectedMessage.replies.push({
                    text: sanitizedText,
                    image: this.uiState.replyPreviewImage,
                    time: new Date().toLocaleTimeString(),
                });

                this.resetReplyForm();
                this.uiState.selectedMessage = null;
                this.showSuccessAlert(this.translate('REPLY_SENT'));
            } catch (error) {
                this.showErrorAlert(error.message || this.translate('SECURITY_ERROR'));
            }
        },

        resetNewMessageForm() {
            this.messageData.newMessageUsername = "";
            this.messageData.newMessageText = "";
            this.messageData.newMessageImage = null;
            if (this.uiState.previewImage) {
                URL.revokeObjectURL(this.uiState.previewImage);
            }
            this.uiState.previewImage = null;
        },

        resetReplyForm() {
            this.messageData.replyText = "";
            this.messageData.replyImage = null;
            if (this.uiState.replyPreviewImage) {
                URL.revokeObjectURL(this.uiState.replyPreviewImage);
            }
            this.uiState.replyPreviewImage = null;
        },

        showSuccessAlert(message) {
            this.$emit('show-alert', {
                type: 'success',
                message: message,
                title: this.translate('SUCCESS')
            });
        },

        showErrorAlert(message) {
            this.$emit('show-alert', {
                type: 'error',
                message: message,
                title: this.translate('ERROR')
            });
        }
    },
    beforeUnmount() {
        if (this.uiState.previewImage) {
            URL.revokeObjectURL(this.uiState.previewImage);
        }
        if (this.uiState.replyPreviewImage) {
            URL.revokeObjectURL(this.uiState.replyPreviewImage);
        }
    }
};
</script>


<style scoped>
.messages-container {
    background-color: var(--background-color);
    color: var(--text-color);
    padding: 20px;
}
.message-image, .reply-image {
    max-width: 100%;
    border-radius: 8px;
    margin-top: 10px;
}

.tabs {
    display: flex;
    justify-content: space-around;
    border-bottom: 2px solid var(--text-color);
    padding-bottom: 10px;
    font-weight: bold;
    font-size: 16px;
}

.tabs span {
    cursor: pointer;
    padding: 10px 15px;
    color: var(--text-color);
    font-weight: bold;
    transition: color 0.3s;
}

.tabs span:hover {
    color: var(--text-color);
}

.active-tab {
    color: var(--text-color);
    border-bottom: 3px solid var(--text-color);
    transition: all 0.3s ease-in-out;
}

.messages-list {
    border-radius: 10px;
    padding: 20px;
    margin: 0 auto;
    max-width: 800px;

}

.message-item {
    display: flex;
    align-items: center;
    border-bottom: 1px solid var(--text-color);
    padding: 25px 0;
    margin: 0 10px;
}

.message-item:hover {
    background-color: var(--background-color);
    cursor: pointer;
}

.approved {
    padding-top: 10px;
    color: #4CAF50;
    font-weight: bold;
}

.pending {
    color: #FF5722;
    font-weight: bold;
    padding-top: 10px;

}

.closed {
    color: #9E9E9E;
    font-weight: bold;
}

.v-btn {
    margin: 5px;
    font-weight: bold;
}

.v-text-field {
    margin: 10px 0;
}

.v-select {
    margin: 10px 0;
}

.v-dialog {
    border-radius: 10px;
}

.v-card {
    padding: 20px;
}

.v-card-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.v-card-text {
    font-size: 14px;
    line-height: 1.6;
}

.reply {
    background: var(--background-color);
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
}

.reply-time {
    font-size: 12px;
    color: var(--text-color);
    margin-left: 10px;
}

.message-time {
    color: var(--text-color);
    font-size: 12px;
    position: absolute;
    right: 0;
    margin-top: -120px !important;

}
.message-time2 {
    color: var(--text-color);
    font-size: 12px;
    position: absolute;
    right: 0;

}
.avatar-img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
}
.modal-card {
    background-color: var(--background-color);
    color: var(--text-color);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 5%!important;
}
.modal1{
    border-radius: 5%!important;

}
.modal-title {
    font-size: 20px;
    font-weight: bold;
    color: var(--text-color);
}

.modal-text {
    font-size: 16px;
    line-height: 1.6;
    color: var(--text-color);
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    padding: 10px;
}
.reply {
    background: var(--background-color);
    padding: 5px;
    margin-top: 10px;
    border-radius: 5px;
}
.back{
    background-color: var(--background-color);
}
.reply-time {
    font-size: 12px;
    color: var(--text-color);
}
.preview-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-top: 10px;
}

</style>
