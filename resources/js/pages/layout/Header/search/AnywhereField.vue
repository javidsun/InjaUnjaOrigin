<template>
  <v-col class="field-wrapper" position="relative" @click="toggleMenu">
    <div class="field-content">
      <img src="/assets/images/location-icon.png" alt="Location Icon" class="icon-img" />
      <span class="field-text" v-show="!isMobile">{{ t(selectedOption) || t('Anywhere.anywhere') }}</span>
    </div>

    <div v-if="isActive" class="options-menu">
      <v-btn @click="selectOption('Anywhere.flexible')">{{ t('Anywhere.flexible') }}</v-btn>
      <v-btn @click="selectOption('Anywhere.italy')">{{ t('Anywhere.italy') }}</v-btn>
      <v-btn @click="selectOption('Anywhere.spain')">{{ t('Anywhere.spain') }}</v-btn>
      <v-btn @click="selectOption('Anywhere.france')">{{ t('Anywhere.france') }}</v-btn>
      <v-btn @click="selectOption('Anywhere.turkey')">{{ t('Anywhere.turkey') }}</v-btn>
      <v-btn @click="selectOption('Anywhere.unitedStates')">{{ t('Anywhere.unitedStates') }}</v-btn>
    </div>
  </v-col>
</template>

<script>
import { t } from '../../../../store/languageStore';

export default {
  setup() {
    return {t};
  },
  props: {
    activeMenu: String,
  },
  data() {
    return {
      selectedOption: null,
      isMobile: false,
    };
  },
  computed: {
    isActive() {
      return this.activeMenu === "anywhere";
    },
  },
  methods: {
    toggleMenu() {
      this.$emit("update-active-menu", this.isActive ? null : "anywhere");
    },
    selectOption(option) {
      this.selectedOption = option;
      this.$emit("update-active-menu", null);
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
  background-color: var(--search-background-color);
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

.options-menu {
  position: fixed;
  top: 50px;
  left: 0;
  width: 15%;
  z-index: 9999;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  color: var(--text-color); /* Match theme */
  background-color: var(--search-background-color); /* Match theme */
  border: 1px solid var(--border-color);
  padding: 10px 8px;
  box-sizing: border-box;
  max-height: 300px;
  overflow-y: auto;
  margin-left: 30%;
  line-height: 1.2;
  display: flex;
  flex-direction: column;
  gap: 8px;
  transition: background-color 0.3s, color 0.3s;
}

.options-menu v-btn {
  flex: none;
  padding: 8px 14px;
  font-size: 10px;
  text-align: center;
  background: var(--search-background-color);
  color: var(--text-color);
  border: 1px solid var(--border-color);
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.options-menu v-btn.active {
  background: var(--primary-color);
  color: white;
  border-color: var(--primary-color);
}

.options-menu v-btn:hover {
  background: var(--background-color--groups);
  color: var(--text-color);
  border-color: var(--border-color);
}

/* Responsive Design */
@media (max-width: 768px) {
  .icon-img {
    width: 24px;
    height: 24px;
  }

  .field-text {
    display: none;
  }

  .options-menu {
    width: 30%;
    padding: 8px 0;
  }
}
@media (max-width: 768px) {
    .field-wrapper {
        flex-direction: row;
        justify-content: flex-start;
        gap: 4px;
    }

    .field-content {
        padding: 5px 8px;
        gap: 4px;
    }

    .icon-img {
        width: 24px;
        height: 24px;
    }

    .field-text {
        font-size: 12px;
    }

    .options-menu {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 4px;
        padding: 5px;
    }

    .options-menu v-btn {
        padding: 4px 8px;
        font-size: 10px;
    }
}

@media (max-width: 1030px) {
    .field-wrapper {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .field-content {
        gap: 6px;
    }

    .icon-img {
        width: 30px;
        height: 30px;
    }

    .field-text {
        display: none;
    }

    .options-menu {
        width: 100%;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 6px;
    }

    .options-menu v-btn {
        flex: 1 1 calc(33.33% - 8px);
        margin: 0;
        padding: 4px 8px;
        font-size: 10px;
    }
}

</style>
