<template class="main">
  <Layout>
    <template #sidebar>
      <v-list dense>
        <v-list-item v-for="(item, index) in menuItems" :key="index" :to="item.link">
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-title>{{ t(item.title) }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </template>
    <v-container fluid class="user-profile">
      <v-row class="profile-header">
        <v-col cols="12" class="text-center">

          <UploadAvatar />
          <h2 class="user-name">{{ userName }}</h2>
          <p class="user-email">{{ userEmail }}</p>
        </v-col>
      </v-row>

      <v-row class="profile-actions1">
        <v-col cols="5">
          <v-btn class="profile-actions" block color="secondary" @click="editProfile">
            {{ t('profile.editProfile') }}
          </v-btn>
        </v-col>
        <v-col cols="5">
          <v-btn class="profile-actions" block color="secondary" @click="viewActivities">
            {{ t('profile.viewActivities') }}
          </v-btn>
        </v-col>
      </v-row>

      <v-row class="profile-info" justify="center">
        <v-col cols="12" sm="10" md="8">
          <h3>{{ t('profile.accountInfo') }}</h3>
          <v-form v-if="isEditing" @submit.prevent="saveProfile" class="profile-info3">
            <v-list class="profile-info3">
              <v-list-item v-for="(item, index) in editableInfo" :key="index" class="fade-in profile-info">
                <v-list-item-content>
                  <v-list-item-title>
                    {{ t(item.label) }}:
                    <v-text-field v-model="item.value" outlined dense :style="{ minWidth: '500px' }" />
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list>
            <v-btn  color="success" type="submit" class="btn_success">{{ t('profile.saveChanges') }}</v-btn>
          </v-form>

          <v-list v-else class="profile-info3">
            <v-list-item v-for="(item, index) in userInfo" :key="index" class="fade-in profile-info">

              <v-list-item-content>
                <v-list-item-title>{{ t(item.label) }}: <span>{{ item.value }}</span></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-col>
      </v-row>
    </v-container>
    <Footer app class="footer">...</Footer>
  </Layout>
</template>

<script setup>
import { ref } from "vue";
import Layout from "../Layout.vue";
import Footer from "../../layout/Footer.vue";
import { t } from "../../../store/languageStore";
import UploadAvatar from "../UploadAvatar.vue";

const userProfileImage = ref("/avatar-2.png");
const userName = ref("Zahra Azizi");
const userEmail = ref("zahra@example.com");

const userInfo = ref([
  { label: "profile.username", value: "@zahra", icon: "mdi-account" },
  { label: "profile.billingEmail", value: "zahra@example.com", icon: "mdi-email" },
  { label: "profile.status", value: "Active", icon: "mdi-check-circle" },
  { label: "profile.role", value: "User", icon: "mdi-account-tie" },
  { label: "profile.taxId", value: "123-456", icon: "mdi-numeric" },
  { label: "profile.contact", value: " +989035044816", icon: "mdi-phone" },
  { label: "profile.language", value: "English", icon: "mdi-translate" },
  { label: "profile.country", value: "iRAN", icon: "mdi-map-marker" },
]);

const editableInfo = ref([...userInfo.value]);

const isEditing = ref(false);

const editProfile = () => {
  isEditing.value = !isEditing.value;
};

const saveProfile = () => {
  console.log("Information saved:", editableInfo.value);
  userInfo.value = [...editableInfo.value];
  isEditing.value = false;
};

const viewActivities = () => {
  this.$router.push("/activities");
};
</script>


<style scoped>
.main{
  background: var(--liner-background);

}

.user-profile {
  background: var(--liner-background);
  padding: 30px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  animation: fadeIn 1.5s ease-in-out;
}

.profile-header {
  margin-bottom: 20px;
}

.profile-avatar img {
  border-radius: 50%;
  border: 4px solid #fff;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  transition: transform 0.3s;
}

.profile-avatar img:hover {
  transform: scale(1.1);
}

.user-name {
  font-weight: bold;
  margin: 10px 0;
  font-size: 24px;
  color: #fff;
}

.user-email {
  color: rgba(255, 255, 255, 0.8);
  font-style: italic;
}

.profile-actions1 {
  display: flex;
  justify-content: center;
  gap: 20px;
  flex-wrap: wrap;
  width: 70%;
  margin: 0 auto;
}

@media (max-width: 768px) {
  .profile-actions {
    font-size: 14px !important;
    font-family: "2 Baran", serif;
  }
  .profile-info .v-text-field {
    min-width: 100%;
  }
}
@media (max-width: 320px) {
  .profile-actions {
    font-size: 10px !important;
    font-family: "2 Baran", serif;
  }
}

.profile-actions {
  font-family: "2 Baran", serif;
  font-size: 22px;
  height: 70px;
  border-radius: 10px;
  transition: background-color 0.3s, transform 0.3s;
  justify-content: center;
}

.profile-actions:hover {
  background-color: #ffffff !important;
  color: #0101ac !important;
  transform: translateY(-5px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.profile-info {
  font-weight: bold;
  color: var(--text-color);
  text-align: center;
  background: var(--sidebar-background-color);
  border-radius: 15px;
  padding: 20px;
  border: 2px solid #ffffff;
  width: 70%;
  margin: 0 auto;

}

.profile-info h3 {
  font-size: 20px;
  margin-bottom: 10px;
  color: var(--text-color);

}
.profile-info .v-list-item {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  margin-bottom: 15px;
  padding: 10px;
  background: var(--backgroundcards-color--profile);
  border-radius: 8px;
  transition: background-color 0.3s ease;
  border: 1px solid #ccc;
}

.profile-info .v-list-item-icon {
  margin-right: 10px;
  color: #af4261;
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 30px;
}

.profile-info .v-list-item-title {
  font-size: 14px;
  color: var(--text-color);
  text-align: left;
  display: flex;
  align-items: center;
}


.profile-info .v-list-item-title {
  font-size: 14px;
  color: var(--text-color);

}

.profile-info .v-list-item-title span {
  margin-left: 10px;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in {
  animation: fadeIn 1s ease-in-out;
}
.profile-info3{
  background-color: var(--sidebar-background-color);
}
btn_success{
  max-width: 10% !important;
}

</style>
