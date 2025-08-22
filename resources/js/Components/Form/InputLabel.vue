<script setup>
defineProps(["value"]);
</script>

<template>
    <label class="tw-block tw-font-medium tw-text-sm tw-text-default-700 tw-mb-1">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>

<style scoped>
.tw-text-default-700 {
    color: rgba(0, 0, 0, 0.88);
}

.dark .tw-text-default-700 {
    color: rgba(255, 255, 255, 0.85);
}
</style>
