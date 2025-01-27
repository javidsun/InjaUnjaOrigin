<template>
  <v-col class="field-wrapper" position="relative">
    <div class="field-content" @click="toggleMenu">
      <img
          src="/assets/images/calendar-icon.png"
          alt="Calendar Icon"
          class="icon-img"
      />
      <span class="field-text" v-show="!isMobile">{{ t('Anyweek.anyweek') }}</span>
    </div>
    <div v-if="isActive" class="options-menu" :class="{ active: isActive }">
      <div class="top-buttons">
        <v-btn class="toggle-btn" :class="{ active: isFlexible === false }" @click="setFlexible(false)">{{ t('Anyweek.date') }}</v-btn>
        <v-btn class="toggle-btn" :class="{ active: isFlexible === true }" @click="setFlexible(true)">{{ t('Anyweek.flexible') }}</v-btn>
      </div>

      <div class="calendar-container">
        <div class="calendar">
          <h3>{{ t(currentMonthName) }}</h3>
          <div class="weekdays">
            <span v-for="day in weekdays" :key="day">{{ t(day) }}</span>
          </div>
          <div class="days">
            <span v-for="day in currentMonthDays" :key="day" class="day">{{ t(day) }}</span>
          </div>
        </div>

        <div class="calendar">
          <h3>{{ nextMonthName }}</h3>
          <div class="weekdays">
            <span v-for="day in weekdays" :key="day">{{ t(day) }}</span>
          </div>
          <div class="days">
            <span v-for="day in nextMonthDays" :key="day" class="day">{{ t(day) }}</span>
          </div>
        </div>
      </div>

      <div class="range-buttons">
        <v-btn outlined class="custom-btn">{{ t('Anyweek.exact_date') }}</v-btn>
        <v-btn outlined class="custom-btn">{{ t('Anyweek.oneDay') }}</v-btn>
        <v-btn outlined class="custom-btn">{{ t('Anyweek.twoDay') }}</v-btn>
        <v-btn outlined class="custom-btn">{{ t('Anyweek.threeDay') }}</v-btn>
        <v-btn outlined class="custom-btn">{{ t('Anyweek.sevenDay') }}</v-btn>
        <v-btn outlined class="custom-btn">{{ t('Anyweek.fourteenDay') }}</v-btn>
      </div>
    </div>
  </v-col>
</template>

<script>
import { t } from '../../../../store/languageStore';

export default {
  setup() {
    return { t };
  },
  props: {
    activeMenu: String,
  },
  data() {
    return {
      selectedOption: null,
      isMobile: false,
      isFlexible: false,
      currentMonth: new Date(),
    };
  },
  computed: {
    isActive() {
      return this.activeMenu === "Anyweek";
    },
    currentMonthName() {
      const options = { month: 'long', year: 'numeric' };
      return this.currentMonth.toLocaleDateString('en-US', options);
    },
    nextMonthName() {
      const nextMonth = new Date(this.currentMonth);
      nextMonth.setMonth(nextMonth.getMonth() + 1);
      return nextMonth.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
    },
    weekdays() {
      return [
        t('Anyweek.sunday'),
        t('Anyweek.monday'),
        t('Anyweek.tuesday'),
        t('Anyweek.wednesday'),
        t('Anyweek.thursday'),
        t('Anyweek.friday'),
        t('Anyweek.saturday'),
      ];
    },
    currentMonthDays() {
      return this.getMonthDays(this.currentMonth);
    },
    nextMonthDays() {
      const nextMonth = new Date(this.currentMonth);
      nextMonth.setMonth(nextMonth.getMonth() + 1);
      return this.getMonthDays(nextMonth);
    },
  },
  methods: {
    toggleMenu() {
      this.$emit("update-active-menu", this.isActive ? null : "Anyweek");
    },
    setFlexible(value) {
      this.isFlexible = value;
    },
    getMonthDays(date) {
      const year = date.getFullYear();
      const month = date.getMonth();
      const lastDay = new Date(year, month + 1, 0).getDate();
      return Array.from({ length: lastDay }, (_, i) => i + 1);
    },
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
  transition: background-color 0.3s, color 0.3s;
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
  width: 50%;
  background: var(--search-background-color);
  color: var(--text-color);
  z-index: 9999;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  padding: 8px;
  max-height: 400px;
  overflow-y: auto;
  margin-left: 45%;
  transition: all 0.3s ease;
}

.calendar-container {
  display: flex;
  justify-content: space-between;
  gap: 12px;
  margin-bottom: 16px;
}

.calendar {
  width: 48%;
  background-color: var(--background-color--groups);
  padding: 10px;
  border: 1px solid var(--border-color);
  border-radius: 8px;
}

.calendar h3 {
  text-align: center;
  font-size: 16px;
  margin-bottom: 8px;
  color: var(--text-color);
}

.weekdays {
  display: flex;
  justify-content: space-between;
  font-size: 12px;
  font-weight: bold;
  margin-bottom: 8px;
  color: var(--text-color);
}

.days {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  justify-content: space-between;
}

.days .day {
  width: 12%;
  text-align: center;
  padding: 4px;
  font-size: 12px;
  background-color: var(--search-background-color);
  color: var(--text-color);
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.days .day:hover {
  background-color: var(--background-color--groups);
  color: var(--text-color);
}


.range-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.custom-btn {
  flex: 1;
  padding: 8px;
  font-size: 12px;
  background-color: var(--search-background-color);
  color: var(--text-color);
  border: 1px solid var(--border-color);
  border-radius: 4px;
  text-align: center;
}

.custom-btn:hover {
  background-color: var(--background-color--groups);
  color: var(--text-color);
}
@media (max-width: 1030px) {
    .field-text {
        display: none;
    }
    .icon-img {
        width: 30px;
        height: 30px;
    }
    .calendar-container {
        flex-direction: column;
        gap: 8px;
    }

    .calendar {
        width: 100%;
        padding: 6px;
    }

    .range-buttons {
        gap: 4px;
    }

    .custom-btn {
        padding: 6px;
        font-size: 10px;
    }

    .days {
        gap: 4px;
    }

    .days .day {
        width: calc(100% / 7 - 4px);
        padding: 2px;
        font-size: 10px;
    }
}

@media (max-width: 500px) {
    .options-menu {
        width: 80%;
        margin-left: 10%;
    }

    .calendar-container {
        flex-direction: column;
        gap: 6px;
    }

    .range-buttons {
        flex-wrap: wrap;
        gap: 4px;
    }

    .custom-btn {
        flex: 1 1 48%;
    }
}

</style>
