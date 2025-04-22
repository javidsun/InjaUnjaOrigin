import axios from 'axios';

const getPerformanceStats = async () => {
  try {
    const response = await axios.get('/api/functional/performance-stats');
    return response.data.performanceStats;
  } catch (error) {
    console.error('Error fetching performance stats:', error);
    return [
      { title: "functional.todayReservations", stats: '35', icon: 'mdi-calendar-check', color: 'primary' },
      { title: "functional.dailyRevenue", stats: '1.5M', icon: 'mdi-cash', color: 'success' },
      { title: "functional.newUsers", stats: '45', icon: 'mdi-account-plus', color: 'warning' }
    ];
  }
};

export default {
  getPerformanceStats
};
