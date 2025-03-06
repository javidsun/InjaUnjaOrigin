<template>
  <div class="dashboard-container">
    <VCard class="dashboard-card">
      <VDataTable
          :headers="headers.map(header => ({ ...header, text:  translate(`userinfo.${header.title}`) }))"

          :items="userData"
          item-value="id"
          class="text-no-wrap"
      >
        <template #item.username="{ item }">
          <div class="d-flex align-center gap-x-4">
            <VAvatar
                size="40"
                :variant="!item.avatar ? 'tonal' : undefined"
                :color="!item.avatar ? resolveUserRoleVariant(item.role).color : undefined"
            >
              <VImg
                  v-if="item.avatar"
                  :src="item.avatar"
              />
              <span v-else>{{ avatarText(item.fullName) }}</span>
            </VAvatar>
            <div class="d-flex flex-column">
              <span class="text-h6 font-weight-medium">{{ translate(item.fullName) }}</span>
              <span class="text-sm text-medium-emphasis">@{{ translate(item.username) }}</span>
            </div>
          </div>
        </template>
        <template #item.role="{ item }">
          <div class="d-flex gap-4">
            <VIcon
                :icon="resolveUserRoleVariant(item.role).icon"
                :color="resolveUserRoleVariant(item.role).color"
                size="22"
            />
            <div class="text-capitalize text-high-emphasis">
              {{ translate(`userinfo.${item.role}`) }}
            </div>
          </div>
        </template>
        <template #item.plan="{ item }">
          <span class="text-capitalize text-high-emphasis">{{ translate(`userinfo.${item.currentPlan}`) }}</span>
        </template>
        <template #item.status="{ item }">
          <VChip
              :color="resolveUserStatusVariant(translate(item.status))"
              size="small"
              class="text-capitalize"
          >
            {{ translate(`userinfo.${item.status}`) }}
          </VChip>
        </template>
      </VDataTable>
    </VCard>
  </div>
</template>

<script setup>
import { translate } from "../../../../../store/languageStore.js";

const avatar1 = './avatar1.svg';
const avatar2 = './avatar2.svg';
const avatar3 = './avatar3.svg';
const avatar4 = './avatar4.svg';
const avatar5 = './avatar1.svg';
const avatar6 = './avatar1.svg';
const avatar7 = './avatar-1.png';
const avatar8 = './avatar-2.png';
const headers = [
  {
    title: "user",
    key: 'username',
  },
  {
    title: "email",
    key: 'email',
  },
  {
    title: "role",
    key: 'role',
  },
  {
    title: "status",
    key: 'status',
  },
];


const userData = [
  {
    id: 1,
    fullName: 'Galasasen Slixby',
    company: 'Yotz PVT LTD',
    role: 'editor',
    username: 'gslixby0',
    country: 'El Salvador',
    contact: '(479) 232-9151',
    email: 'gslixby0@abc.net.au',
    currentPlan: 'enterprise',
    status: 'inactive',
    avatar: avatar1,
  },
  {
    id: 2,
    fullName: 'Halsey Redmore',
    company: 'Skinder PVT LTD',
    role: 'author',
    username: 'hredmore1',
    country: 'Albania',
    contact: '(472) 607-9137',
    email: 'hredmore1@imgur.com',
    currentPlan: 'team',
    status: 'pending',
    avatar: avatar2,
  },
  {
    id: 3,
    fullName: 'Marjory Sicely',
    company: 'Oozz PVT LTD',
    role: 'maintainer',
    username: 'msicely2',
    country: 'Russia',
    contact: '(321) 264-4599',
    email: 'msicely2@who.int',
    currentPlan: 'enterprise',
    status: 'active',
    avatar: avatar3,
  },
  {
    id: 4,
    fullName: 'Cyrill Risby',
    company: 'Oozz PVT LTD',
    role: 'admin',
    username: 'crisby3',
    country: 'China',
    contact: '(923) 690-6806',
    email: 'crisby3@wordpress.com',
    currentPlan: 'team',
    status: 'inactive',
    avatar: avatar4,
  },
  {
    id: 5,
    fullName: 'Maggy Hurran',
    company: 'Aimbo PVT LTD',
    role: 'subscriber',
    username: 'mhurran4',
    country: 'Pakistan',
    contact: '(669) 914-1078',
    email: 'mhurran4@yahoo.co.jp',
    currentPlan: 'enterprise',
    status: 'pending',
    avatar: avatar5,
  },
  {
    id: 6,
    fullName: 'Silvain Halstead',
    company: 'Jaxbean PVT LTD',
    role: 'author',
    username: 'shalstead5',
    country: 'China',
    contact: '(958) 973-3093',
    email: 'shalstead5@shinystat.com',
    currentPlan: 'company',
    status: 'active',
    avatar: avatar6,
  },
  {
    id: 7,
    fullName: 'Breena Gallemore',
    company: 'Jazzy PVT LTD',
    role: 'subscriber',
    username: 'bgallemore6',
    country: 'Canada',
    contact: '(825) 977-8152',
    email: 'bgallemore6@boston.com',
    currentPlan: 'company',
    status: 'pending',
    avatar: avatar7,
  },
  {
    id: 8,
    fullName: 'Kathryne Liger',
    company: 'Pixoboo PVT LTD',
    role: 'author',
    username: 'kliger7',
    country: 'France',
    contact: '(187) 440-0934',
    email: 'kliger7@vinaora.com',
    currentPlan: 'enterprise',
    status: 'pending',
    avatar: avatar8,
  },
]

const resolveUserRoleVariant = role => {
  const roleLowerCase = role.toLowerCase()
  if (roleLowerCase === 'subscriber')
    return {
      color: 'success',
      icon: 'ri-user-line',
    }
  if (roleLowerCase === 'author')
    return {
      color: 'error',
      icon: 'ri-computer-line',
    }
  if (roleLowerCase === 'maintainer')
    return {
      color: 'info',
      icon: 'ri-pie-chart-line',
    }
  if (roleLowerCase === 'editor')
    return {
      color: 'warning',
      icon: 'ri-edit-box-line',
    }
  if (roleLowerCase === 'admin')
    return {
      color: 'primary',
      icon: 'ri-vip-crown-line',
    }

  return {
    color: 'success',
    icon: 'ri-user-line',
  }
}

const resolveUserStatusVariant = stat => {
  const statLowerCase = stat.toLowerCase()
  if (statLowerCase === 'pending')
    return 'warning'
  if (statLowerCase === 'active')
    return 'success'
  if (statLowerCase === 'inactive')
    return 'secondary'

  return 'primary'
}
</script>

<style scoped>
.dashboard-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: var(--background-color);
}

.dashboard-card {
  width: 80%;
  max-width: 1200px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  border-radius: 16px;
  padding: 16px;
  background-color: var(--backgroundcards2-color--groups);
}
.text-no-wrap{
  background-color: var(--backgroundcards2-color--groups);
}
</style>
