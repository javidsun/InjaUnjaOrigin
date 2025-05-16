<template>
    <v-row class="group-row">
        <v-col
            v-for="(group, index) in groupImages"
            :key="index"
            cols="12"
            sm="6"
            md="3"
            class="group-image-container"
            @click="handleGroupSelection(index)"
        >
            <div class="image-box"
                 :class="{
                         'is-hovered': hoverIndex === index,
                         'shrunk-icon': selectedGroup !== null,
                         'expanded-state': isExpanded
                     }">
                <v-img :src="group" class="group-image" />
            </div>
            <div v-if="selectedGroup === index" class="selection-indicator">
                <v-icon color="success">mdi-check-circle</v-icon>
            </div>
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: {
        groupImages: {
            type: Array,
            required: true
        },
        selectedGroup: {
            type: Number,
            default: null
        },
        isExpanded: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            hoverIndex: null
        };
    },
    methods: {
        handleGroupSelection(index) {
            this.$emit('selectGroup', index);
        },
        setHover(index) {
            this.hoverIndex = index;
        },
        clearHover() {
            this.hoverIndex = null;
        }
    }
}
</script>

<style scoped>
.group-row {
    margin-bottom: 30px;
    margin-top: 50px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 0 60px;
    gap: 10px;
}

.group-image-container {
    position: relative;
    margin-bottom: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex: 1 1 calc(25% - 10px);
    max-width: calc(25% - 10px);
    cursor: pointer;
}

.selection-indicator {
    position: absolute;
    top: 5px;
    right: 5px;
    z-index: 2;
    background: white;
    border-radius: 50%;
}

.image-box {
    width: 80%;
    aspect-ratio: 1;
    min-width: 150px;
    min-height: 150px;
    transition: all 0.3s ease;
}
.image-box.expanded-state {
    transform: scale(0.99) !important;
    min-width: 100px !important;
    min-height: 100px !important;
}
.image-box.shrunk-icon {
    transform: scale(0.8);
}

.image-box.is-hovered,
.group-image-container:hover .image-box {
    transform: scale(1.1) translateY(-5px);
    box-shadow: 0 8px 20px rgba(255, 255, 255, 0.9),
    0 6px 12px rgba(0, 0, 0, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.9);
}

.group-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.7));
    transition: transform 0.3s ease-out;
}

.group-image-container:hover .group-image {
    transform: scale(0.96) rotate(2deg);
}

.group-image-container:active .image-box {
    transform: scale(0.98) translateY(1px);
}

.shrunk-icon {
    animation: shrinkAndMove 0.5s cubic-bezier(0.25, 0.1, 0.25, 1) forwards;
    pointer-events: none;
    opacity: 0.7;
    position: relative;
    z-index: 10;
}
@keyframes shrinkAndMove {
    0% {
        transform: scale(1) translateX(0);
    }
    100% {
        transform: scale(0.8) translateX(10%);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-5px); }
    40%, 80% { transform: translateX(5px); }
}

@media (min-width: 960px) {
    .shrunk-icon {
        animation: none;
        transform: scale(0.8) translateX(10%);
        opacity: 0.7;
    }

    .group-row {
        overflow: hidden;
        padding: 0 250px;
    }

    .image-box {
        width: 70%;
        min-width: 180px;
        min-height: 180px;
    }

    .image-box.expanded-state {
        transform: scale(0.70) !important;
        min-width: 90px !important;
        min-height: 90px !important;
    }


    .group-image-container {
        overflow: visible;
    }
}

@media (min-width: 100px) and (max-width: 200px) {
    .group-row {
        justify-content: flex-start;
    }

    .group-image-container {
        flex: 1 1 25%;
    }
    .group-image {
        max-width: 100%;
        max-height: 100%;
    }

    .image-box {
        width: 50%;
        min-width: 40px;
        min-height: 40px;
    }
}

@media (min-width: 200px) and (max-width: 370px) {
    .image-box {
        width: 50%;
        min-width: 50px;
        min-height: 50px;
        max-width: 50%;
    }
}

@media (min-width: 371px) and (max-width: 505px) {
    .image-box {
        width: 50%;
        min-width: 60px;
        min-height: 60px;
        max-width: 50%;
    }
}

@media (min-width: 506px) and (max-width: 960px) {
    .group-row {
        justify-content: flex-start;
    }
    .image-box {
        min-width: 80px;
        min-height: 80px;
    }

    .image-box.expanded-state {
        transform: scale(0.65) !important;
        min-width: 60px !important;
        min-height: 60px !important;
    }

}
</style>
