<template>
    <UserSidebar class="back">
        <v-container class="messages-container">
            <v-btn color="primary" @click="newMessageDialog = true" aria-label="Send new message">
                {{ translate('Message.NewMessage') }}
            </v-btn>

            <v-dialog v-model="newMessageDialog" max-width="500px">
                <v-card class="modal1">
                    <v-card-title>{{ translate('Message.NewMessage') }}</v-card-title>
                    <v-card-text>
                        <v-select v-model="newMessageType" :items="categories2" item-value="type" item-text="title" :label="translate('Message.SelectCategory')"></v-select>
                        <v-text-field v-model="newMessageUsername" :label="translate('Message.Username')" dense outlined v-if="newMessageType === 'host' || newMessageType === 'guest'"></v-text-field>
                        <v-text-field v-model="newMessageText" :label="translate('Message.MessageText')" dense outlined></v-text-field>
                        <v-file-input
                            @change="handleImageUpload"
                            :label="translate('Message.Image_selection')"
                            dense
                            outlined
                            accept="image/*">
                        </v-file-input>
                        <v-img v-if="previewImage" :src="previewImage" class="preview-image"></v-img>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" @click="sendNewMessage" :disabled="!newMessageText || (newMessageType !== 'support' && !newMessageUsername)">{{ translate('Message.SendMessage') }}</v-btn>
                        <v-btn text @click="newMessageDialog = false">{{ translate('housescontent.close') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>


            <v-row>
                <v-col cols="12">
                    <div class="tabs">
                        <span
                            v-for="(category, index) in categories"
                            :key="index"
                            @click="selectCategory(category)"
                            :class="{'active-tab': selectedCategory === category.type}"
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
                                <v-btn class="message-time2" color="red" @click.stop="closeMessage(message)">{{ translate('Message.Close') }}</v-btn>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>

            <v-dialog v-model="selectedMessage" max-width="500px">
                <v-card v-if="selectedMessage">
                    <v-card-title>{{ selectedMessage.sender }}</v-card-title>
                    <v-card-text>
                        {{ sanitizeMessage(selectedMessage.fullText) }}
                        <div v-if="selectedMessage.image">
                            <v-img v-if="selectedMessage.image" :src="selectedMessage.image" class="message-image"></v-img>
                        </div>
                        <div v-if="selectedMessage.replies">
                            <hr>
                            <div v-for="(reply, index) in selectedMessage.replies" :key="index" class="reply">
                                <p>{{ sanitizeMessage(reply.text) }} <span class="reply-time">{{ reply.time }}</span></p>
                                <v-img v-if="reply.image" :src="reply.image" class="reply-image"></v-img>
                            </div>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-text-field v-model="replyText" :label="translate('Message.Reply')" dense outlined :disabled="selectedMessage.closed"></v-text-field>
                        <v-file-input
                            @change="handleReplyImageUpload"
                            :label="translate('Message.Image_selection')"
                            dense
                            outlined
                            accept="image/*">
                        </v-file-input>
                        <v-img v-if="replyPreviewImage" :src="replyPreviewImage" class="preview-image"></v-img>
                        <v-btn color="primary" @click="sendReply" :disabled="selectedMessage.closed">{{ translate('Message.SendMessage') }}</v-btn>
                        <v-btn text @click="selectedMessage = null">{{ translate('housescontent.close') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </UserSidebar>
</template>

<script>
//TODO : composition --> option & const & error warning

import UserSidebar from '../Layout.vue';
import { translate } from "@/store/languageStore.js";

export default {
    setup() {
        return { translate };
    },
    components: {
        UserSidebar,

    },
    data() {
        return {
            newMessageUsername: "",
            newMessageDialog: false,
            newMessageType: null,
            newMessageText: "",
            selectedCategory: "all",
            selectedMessage: null,
            newMessageImage: null,
            previewImage: null,
            replyPreviewImage: null,
            replyText: "",
            replyImage: null,
            categories: [
                { title: translate("all"), type: "all" },
                { title: translate("host"), type: "host" },
                { title: translate("guest"), type: "guest" },
                { title: translate("support"), type: "support" }
            ],
            categories2: [
                { title: translate("host"), type: "host" },
                { title: translate("guest"), type: "guest" },
                { title: translate("support"), type: "support" }
            ],

            messages: [
                { sender: "آرش", avatar: "avatar-2.png", preview: "سلام، چندتا سوال بابت اجاره اتاق داشتم. می خواس...", fullText: "سلام، چندتا سوال ببت اجاره اتاق داشتم. می خواس... ", time: " 1:10:10 PM", type: "host", approved: true, status: "تایید شد. یک اتاق برای اجاره در یک خانه دو خوابه" },
                { sender: "مریم", avatar: "avatar-1.png", preview: "سلام، برای سفر به سوئیس و این تور جنگل می تونم...", fullText: "سلام، برای سفر به سوئیس و این تور جنگل می تونم...", time: "  10:28:25 AM", type: "guest", approved: false, status: "تایید نشده. یک اتاق برای اجاره در یک خانه دو خوابه" },
                { sender: "کیارش", avatar: "avatar3.svg", preview: "وقت بخیر، من و دوستم دنبال دو نفر همسفر می گر...", fullText: "وقت بخیر، من و دوستم دنبال دو نفر همسفر می گر...", time: "01/03/2024 ", type: "guest", approved: true, status: "تایید شد. جستجوی همسفر برای رفتن به سیسیل" },
                { sender: "میترا", avatar: "avatar4.svg", preview: "وقت بخیر، من دوشنبه میرسم ونیز با چندتا از دوس...", fullText: "وقت بخیر، من دوشنبه میرسم ونیز با چندتا از دوس...", time: "02/02/2024  ", type: "host", approved: true, status: "تایید شد. تور لیدر در شهر ونیز با ۸ سال سابقه" },
                { sender: "پشتیبان InjaOnja", avatar: "inja-unja.png", preview: "شما، مراحل بازپرداخت را انجام دادم. تشکر", fullText: "شما، مراحل بازپرداخت را انجام دادم. تشکر", time: "01/02/2024   ", type: "support", approved: false, status: "پایان" },
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
                },

            ]
        };
    },
    computed: {
        filteredMessages() {
            if (this.selectedCategory === "all") return this.messages;
            return this.messages.filter(msg => msg.type === this.selectedCategory);
        }
    },
    methods: {
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                if (this.previewImage) {
                    URL.revokeObjectURL(this.previewImage);
                }
                this.previewImage = URL.createObjectURL(file);
                this.newMessageImage = file;
            }
        },
        handleReplyImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.replyPreviewImage = URL.createObjectURL(file);
                this.replyImage = file;
            }
        },
        beforeUnmount() {
            if (this.previewImage) {
                URL.revokeObjectURL(this.previewImage);
            }
            if (this.replyPreviewImage) {
                URL.revokeObjectURL(this.replyPreviewImage);
            }
        },

        selectCategory(category) {
            this.selectedCategory = category.type;
        },
        openMessage(message) {
            if (!message.closed) {
                this.selectedMessage = message;
            }
        },
        closeMessage(message) {
            message.closed = true;
            if (this.selectedMessage === message) {
                this.selectedMessage = null;
            }
        },
        sendNewMessage() {
            if (this.newMessageText.trim() && this.newMessageType) {
                const sanitizedText = this.sanitizeMessage(this.newMessageText);
                const newMessage = {
                    sender: "you",
                    avatar: "avatar1.svg",
                    preview: sanitizedText.slice(0, 20) + "...",
                    fullText: sanitizedText,
                    image: this.previewImage,
                    time: new Date().toLocaleTimeString(),
                    type: this.newMessageType,
                    approved: false,
                    status: "Awaiting review"
                };

                this.messages.unshift(newMessage);

                this.newMessageText = "";
                this.previewImage = null;
                this.newMessageImage = null;
                this.newMessageDialog = false;
            }
        },

        sanitizeMessage(message) {
            message = message.replace(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/g, '***');
            message = message.replace(/(\+|0)?9\d{9}/g, '***');
            return message;
        },
        sendReply() {
            if (this.replyText.trim() && this.selectedMessage && !this.selectedMessage.closed) {
                if (!this.selectedMessage.replies) {
                    this.selectedMessage.replies = [];
                }
                const sanitizedText = this.sanitizeMessage(this.replyText);
                this.selectedMessage.replies.push({
                    text: sanitizedText,
                    image: this.replyImage && this.replyImage.length > 0 ? URL.createObjectURL(this.replyImage[0]) : null,
                    time: new Date().toLocaleTimeString(),
                });
                this.replyText = "";
                this.replyImage = null;
                this.selectedMessage = null;
            }
        },

        //برای زمانیکه میخواهم به بک متصل کنم
        // async fetchMessages() {
        //     try {
        //         const response = await fetch('http://127.0.0.1:8003/api/messages');
        //
        //         if (!response.ok) {
        //             throw new Error(`خطای شبکه: ${response.status} ${response.statusText}`);
        //         }
        //
        //         const contentType = response.headers.get('content-type');
        //         if (!contentType || !contentType.includes('application/json')) {
        //             throw new TypeError('پاسخ دریافتی JSON نیست.');
        //         }
        //
        //         const data = await response.json();
        //         this.messages = data;
        //     } catch (error) {
        //         console.error("Error fetching messages:", error);
        //         alert("خطا در دریافت پیام‌ها. لطفاً دوباره تلاش کنید.");
        //     }
        // }
    },
    // mounted() {
    //     this.fetchMessages();
    // }
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
