<template>
    <v-container class="text-center">
        <v-btn icon @click="$router.go(-1)" class="back-btn">
            <v-icon>mdi-arrow-right</v-icon>
        </v-btn>
        <h2 class="text-h5 font-weight-bold">New Ad</h2>
        <p class="text-body-2 txt">Select the desired option.</p>

        <v-row class="mt-6" justify="center">
            <v-col cols="4" sm="6" md="3">
                <v-card class="option-card txt2" @click="openModal('accommodation')">
                    <v-img src="/Untitled design (1) 10.png" contain height="100"></v-img>
                    <v-btn class="mt-2 option-card2 txt3 txt2" block>Accommodation</v-btn>
                </v-card>
            </v-col>
            <v-col cols="4" sm="6" md="3">
                <v-card class="option-card txt2" @click="openModal('vehicle')">
                    <v-img src="/Untitled design (1) 11.png" contain height="100"></v-img>
                    <v-btn class="mt-2 option-card2 txt2" block>Vehicle</v-btn>
                </v-card>
            </v-col>
            <v-col cols="4" sm="6" md="3">
                <v-card class="option-card txt2" @click="openModal('companion')">
                    <v-img src="/Untitled design (1) 12.png" contain height="100"></v-img>
                    <v-btn class="mt-2 option-card2 txt2" block>Companion</v-btn>
                </v-card>
            </v-col>
        </v-row>

        <v-dialog v-model="showModal" max-width="500">
            <v-card>
                <v-card-title class="headline">
                    Create New {{ capitalizeFirstLetter(modalType) }} Ad
                </v-card-title>
                <v-card-text>
                    <v-alert v-if="errorMessage" type="error" dismissible>
                        {{ errorMessage }}
                    </v-alert>
                    <p>You are creating a new {{ modalType }} advertisement.</p>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="createAd">Create</v-btn>
                    <v-btn color="secondary" @click="closeModal">Cancel</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>

export default {
    name: 'NewAdSelection',
    props: {
        title: String,
        image: String,
        cols: {
            type: [Number, String],
            default: 4
        },
        sm: {
            type: [Number, String],
            default: 6
        },
        md: {
            type: [Number, String],
            default: 3
        }
    },
    data() {
        return {
            modalType: "",
            selectedProperty: null,
            errorMessage: "",
            showModal: false
        };
    },
    methods: {

        openModal(type) {
            try {
                if (!['accommodation', 'vehicle', 'companion'].includes(type)) {
                    throw new Error('Invalid ad type selected');
                }

                this.modalType = type;
                this.showModal = true;
                this.selectedProperty = null;
                this.errorMessage = "";

                this.$emit('ad-type-selected', type);
            } catch (error) {
                this.showError(error.message);
            }
        },


        closeModal() {
            this.showModal = false;
            this.modalType = "";
            this.errorMessage = "";
        },


        createAd() {
            try {
                if (!this.modalType) {
                    throw new Error('No ad type selected');
                }

                this.$emit('create-ad', {
                    type: this.modalType,
                    data: this.selectedProperty
                });

                this.showSuccess(`New ${this.modalType} ad created successfully!`);
                this.closeModal();
            } catch (error) {
                this.showError(error.message);
            }
        },


        showError(message) {
            this.errorMessage = message;
            this.$notify({
                type: 'error',
                title: 'Error',
                text: message,
                duration: 5000
            });
        },


        showSuccess(message) {
            this.$notify({
                type: 'success',
                title: 'Success',
                text: message,
                duration: 5000
            });
        },

        capitalizeFirstLetter(string) {
            return string ? string.charAt(0).toUpperCase() + string.slice(1) : '';
        },

    }
};
</script>

<style scoped>
.back-btn {
    position: absolute;
    left: 16px;
    top: 16px;
}

.option-card {
    cursor: pointer;
    transition: transform 0.3s;
    padding: 16px;
    border-radius: 12px !important;
}

.option-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.option-card2 {
    background-color: #f5f5f5 !important;
    color: #333 !important;
    font-weight: 500;
    border-radius: 8px !important;
}

.txt {
    color: #666;
}

.txt2 {
    font-size: 14px;
}

.txt3 {
    font-weight: bold;
}
</style>
