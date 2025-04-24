<template>
    <v-container class="home-container pa-0" fluid>
        <div class="menu-container" ref="menuContainer" @mousemove="handleMouseMove">
            <!-- Main Half-Circle -->
            <div class="main-circle">
                <v-img
                    src="https://images.unsplash.com/photo-1449034446853-66c86144b0ad?ixlib=rb-4.0.3"
                    gradient="to right, rgba(0,0,0,.7), rgba(0,0,0,.3)"
                    cover
                    class="main-circle-image"
                >
                    <div class="city-info">
                        <h2 class="text-h3 font-weight-bold text-white mb-2">ALISO VIEJO</h2>
                        <div class="weather-info">
                            <v-icon color="white" size="x-large">mdi-weather-partly-cloudy</v-icon>
                            <span class="text-h4 text-white ml-2">50°</span>
                        </div>
                    </div>
                </v-img>
            </div>

            <!-- 3D Menu Items -->
            <div class="menu-items">
                <div
                    v-for="(item, index) in menuItems"
                    :key="item.title"
                    class="menu-item"
                    :style="getMenuItemStyle(index)"
                    @mouseover="handleMenuHover(index)"
                    @mouseleave="handleMenuLeave"
                >
                    <div class="menu-item-3d" :class="{ 'hovered': hoveredIndex === index }">
                        <v-icon size="x-large" color="white">{{ item.icon }}</v-icon>
                    </div>
                    <span class="menu-item-text" :class="{ 'visible': hoveredIndex === index }">
            {{ item.title }}
          </span>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Add your main content here -->
            <h1 class="text-h2 font-weight-bold text-white mb-4">Welcome to Aliso Viejo</h1>
            <!-- Add more content as needed -->
        </div>
    </v-container>
</template>

<script setup>
// TODO : composition --> option & const
import { ref, onMounted, onUnmounted } from 'vue'

const menuContainer = ref(null)
const hoveredIndex = ref(null)
const mousePosition = ref({ x: 0, y: 0 })

const menuItems = [
    { title: 'CITY HALL', icon: 'mdi-office-building-marker' },
    { title: 'BUSINESSES', icon: 'mdi-store' },
    { title: 'PLACES', icon: 'mdi-map-marker' },
    { title: 'NEWS', icon: 'mdi-newspaper' },
    { title: 'FOOD', icon: 'mdi-food' },
    { title: 'REPORTS', icon: 'mdi-file-document' },
    { title: 'CITY HALL', icon: 'mdi-office-building-marker' },
    { title: 'BUSINESSES', icon: 'mdi-store' },
    { title: 'PLACES', icon: 'mdi-map-marker' },

]

const handleMouseMove = (event) => {
    if (!menuContainer.value) return

    const rect = menuContainer.value.getBoundingClientRect()
    mousePosition.value = {
        x: event.clientX - rect.left,
        y: event.clientY - rect.top
    }
}

const handleMenuHover = (index) => {
    hoveredIndex.value = index
}

const handleMenuLeave = () => {
    hoveredIndex.value = null
}

const getMenuItemStyle = (index) => {
    const totalItems = menuItems.length
    const angleRange = Math.PI // Half circle (π radians)
    const baseAngle = (index / (totalItems - 1)) * angleRange - Math.PI / 2
    const radius = 250 // Distance from center

    // Calculate position based on mouse movement
    const maxOffset = 20 // Maximum offset for mouse movement
    const offsetX = (mousePosition.value.x / (menuContainer.value?.clientWidth ?? 1)) * maxOffset
    const offsetY = (mousePosition.value.y / (menuContainer.value?.clientHeight ?? 1)) * maxOffset

    const x = Math.cos(baseAngle) * radius + offsetX
    const y = Math.sin(baseAngle) * radius + offsetY

    return {
        transform: `translate(${x}px, ${y}px)`,
        transition: 'transform 0.3s ease-out'
    }
}

onMounted(() => {
    window.addEventListener('mousemove', handleMouseMove)
})

onUnmounted(() => {
    window.removeEventListener('mousemove', handleMouseMove)
})
</script>

<style scoped>
.home-container {
    height: 100vh;
    background-color: #121212;
    overflow: hidden;
    display: flex;
}

.menu-container {
    position: relative;
    width: 50vw;
    height: 100vh;
    overflow: hidden;
}

.main-circle {
    width: 100vw;
    height: 100vw;
    border-radius: 50%;
    overflow: hidden;
    position: absolute;
    left: -50vw;
    top: 50%;
    transform: translateY(-50%);
    box-shadow: 0 0 50px rgba(255,255,255,0.1);
}

.main-circle-image {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-right: 5%;
}

.city-info {
    text-align: right;
    padding: 2rem;
}

.weather-info {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.menu-items {
    position: absolute;
    width: 50vw;
    height: 100vh;
    left: 0;
    top: 0;
}

.menu-item {
    position: absolute;
    left: 50%;
    top: 50%;
    transform-origin: center;
    transition: all 0.3s ease-out;
}

.menu-item-3d {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: all 0.3s ease;
    transform: translateZ(20px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.menu-item-3d:hover {
    transform: translateZ(30px) scale(1.1);
    background: rgba(255,255,255,0.2);
}

.menu-item-3d.hovered {
    transform: translateZ(40px) scale(1.2);
    background: rgba(255,255,255,0.3);
}

.menu-item-text {
    position: absolute;
    white-space: nowrap;
    color: white;
    font-size: 1rem;
    font-weight: 500;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    margin-left: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.menu-item-text.visible {
    opacity: 1;
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotateX(0) rotateY(0); }
    25% { transform: translateY(-10px) rotateX(5deg) rotateY(5deg); }
    50% { transform: translateY(0) rotateX(0) rotateY(0); }
    75% { transform: translateY(10px) rotateX(-5deg) rotateY(-5deg); }
}

.menu-item-3d {
    animation: float 6s ease-in-out infinite;
}

.menu-item:nth-child(odd) .menu-item-3d {
    animation-delay: -3s;
}

.content-area {
    flex: 1;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
</style>
