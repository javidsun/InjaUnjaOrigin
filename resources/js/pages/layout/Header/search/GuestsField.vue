<!--فایل  GuestsField.js در services      فایل   GuestsField.json در پوشه docs -->


<template>
  <v-col class="field-wrapper" position="relative">
    <div class="field-content" @click="toggleMenu">
      <img
        src="/assets/images/guests-icon.png"
        alt="Guests Icon"
        class="icon-img"
      />

      <span class="field-text" v-show="!isMobile">{{ translate('guests.title') }}</span>
    </div>

    <div v-if="isActive" class="options-menu">
      <div class="guest-field">
        <div class="guest-info">
          <span class="guest-title">{{ translate('guests.adults') }}</span>
          <span class="guest-subtitle">{{ translate('guests.adultsSubtitle') }}</span>
        </div>
        <div class="guest-controls">
          <button @click.stop="decrement('adults')" :disabled="adults === 0" class="control-btn">-</button>
          <span class="guest-count">{{ adults }}</span>
          <button @click.stop="increment('adults')" class="control-btn">+</button>
        </div>
      </div>

      <div class="guest-field">
        <div class="guest-info">
          <span class="guest-title">{{ translate('guests.children') }}</span>
          <span class="guest-subtitle">{{ translate('guests.childrenSubtitle') }}</span>
        </div>
        <div class="guest-controls">
          <button @click.stop="decrement('children')" :disabled="children === 0" class="control-btn">-</button>
          <span class="guest-count">{{ children }}</span>
          <button @click.stop="increment('children')" class="control-btn">+</button>
        </div>
      </div>

      <div class="guest-field">
        <div class="guest-info">
          <span class="guest-title">{{ translate('guests.infants') }}</span>
          <span class="guest-subtitle">{{ translate('guests.infantsSubtitle') }}</span>
        </div>
        <div class="guest-controls">
          <button @click.stop="decrement('infants')" :disabled="infants === 0" class="control-btn">-</button>
          <span class="guest-count">{{ infants }}</span>
          <button @click.stop="increment('infants')" class="control-btn">+</button>
        </div>
      </div>

      <div class="guest-field">
        <div class="guest-info">
          <span class="guest-title">{{ translate('guests.pets') }}</span>
          <span class="guest-subtitle">{{ translate('guests.petsSubtitle') }}</span>
        </div>
        <div class="guest-controls">
          <button @click.stop="decrement('pets')" :disabled="pets === 0" class="control-btn">-</button>
          <span class="guest-count">{{ pets }}</span>
          <button @click.stop="increment('pets')" class="control-btn">+</button>
        </div>
      </div>
        <v-btn @click="submitGuests" color="primary">Ok</v-btn>

    </div>
  </v-col>
</template>

<script>
import { translate } from '../../../../store/languageStore';
import { sendGuestData } from '../../../../services/general/search/GuestsField.js';

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
      async submitGuests() {
          const payload = {
              adults: this.adults,
              children: this.children,
              infants: this.infants,
              pets: this.pets,
          };
          try {
              const result = await sendGuestData(payload);
              console.log('Success:', result);
          } catch (err) {
              console.error('Error:', err);
          }
      }
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
  width: 17%;
  background: var(--search-background-color);
  color: var(--text-color);
  z-index: 9999;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  padding: 20px;
  box-sizing: border-box;
  max-height: 350px;
  overflow-y: auto;
  margin-left: 55%;
  line-height: 1.2;
  transition: background-color 0.3s, color 0.3s;
}

.guest-field {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 12px 0;
  padding: 10px;
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
}

.guest-subtitle {
  font-size: 10px;
  color: var(--text-color);
}


.guest-controls {
  display: flex;
  align-items: center;
  gap: 8px;
}

.control-btn {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: var(--search-background-color);
  border: 1px solid var(--border-color);
  cursor: pointer;
  font-size: 12px;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-color);
  transition: background-color 0.3s ease, color 0.3s ease;
}

.control-btn:disabled {
  cursor: not-allowed;
  opacity: 0.5;
  color: var(--text-color);
}

.guest-count {
  width: 24px;
  text-align: center;
  font-weight: bold;
  color: var(--text-color);
}

@media (max-width: 1030px) {
  .options-menu {
    width: 20%;
    left: 5%;
    top: 50px;
    padding: 10px;
    max-height: 600px;
  }

  .guest-field {
    flex-direction: column;
    align-items: flex-start;
    padding: 8px;
    margin: 8px 0;
  }

  .guest-title {
    font-size: 12px;
  }

  .guest-subtitle {
    font-size: 9px;
  }

  .guest-controls {
    gap: 6px;
  }

  .control-btn {
    width: 28px;
    height: 28px;
    font-size: 10px;
  }

  .guest-count {
    width: 20px;
    font-size: 12px;
  }
}
@media (max-width: 1030px) {
    .field-text {
        display: none;
    }
    .icon-img {
        width: 30px;
        height: 30px;
    }
    .guest-field {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 5px;
        margin: 5px 0;
        gap: 5px;
    }
    .guest-info {
        flex: 1;
    }
    .guest-controls {
        flex: 1;
        justify-content: flex-end;
        gap: 4px;
    }
    .control-btn {
        width: 24px;
        height: 24px;
        font-size: 10px;
    }
    .guest-count {
        width: 18px;
        font-size: 10px;
    }
}

@media (max-width: 635px) {
  .options-menu {
    width: 35%;
    margin-left: 20%;
  }
}

@media (max-width: 350px) {
  .options-menu {
    width: 50%;
    margin-left: 20%;
  }
}

@media (max-width: 250px) {
  .options-menu {
    width: 70%;
    margin-left: 20%;
  }
}
</style>
