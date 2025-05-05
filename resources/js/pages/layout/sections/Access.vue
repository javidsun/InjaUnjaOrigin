<template>
    <div
        class="access-container"
        @mouseenter="handleMouseEnter"
        @mouseleave="handleMouseLeave"
    >
        <v-btn icon class="hand-icon">
            <v-icon>mdi-hand-extended</v-icon>
        </v-btn>

        <v-row v-if="isHovered" class="access-list">
            <v-col
                v-for="(image, index) in accessImages"
                :key="index"
                cols="12"
                class="access-item"
            >
                <v-img :src="image" class="access-image" @error="handleImageError(index)" />
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    name: 'Access',
    props: {
        accessImages: {
            type: Array,
            required: true,
            validator: value => {
                return value.every(item => typeof item === 'string')
            }
        }
    },
    data() {
        return {
            isHovered: false,
            failedImages: []
        }
    },
    methods: {
        handleMouseEnter() {
            try {
                this.isHovered = true
            } catch (error) {
                this.logError('Error in mouse enter', error)
            }
        },
        handleMouseLeave() {
            try {
                this.isHovered = false
            } catch (error) {
                this.logError('Error in mouse leave', error)
            }
        },
        handleImageError(index) {
            try {
                this.failedImages.push(index)
                this.$emit('image-load-error', {
                    index,
                    imageUrl: this.accessImages[index]
                })

                this.$notify({
                    title: 'Image Error',
                    text: `Failed to load image ${index + 1}`,
                    type: 'error',
                    duration: 3000
                })
            } catch (error) {
                this.logError('Error handling image error', error)
            }
        },
        logError(message, error) {
            console.error(message, error)
        }
    }
}
</script>

<style scoped>
.access-container {
    position: fixed;
    top: 20%;
    left: 10px;
    z-index: 1000;
}

.hand-icon {
    background-color: var(--search-background-color);
    border: 1px solid #ddd;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.hand-icon:hover {
    transform: scale(1.1);
}

.access-list {
    background-color: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 8px;
    padding: 10px;
    animation: fadeIn 0.3s ease-out;
}

.access-item {
    margin-bottom: 10px;
    transition: transform 0.2s ease;
}

.access-item:hover {
    transform: translateX(5px);
}

.access-image {
    width: 50px;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.access-image:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
