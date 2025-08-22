<script setup>
defineProps(['message']);
</script>

<template>
  <div
    v-show="message"
    class="ant-form-item-explain ant-form-item-explain-connected tw-mt-1"
  >
    <div role="alert" class="ant-form-item-explain-error">
      {{ message }}
    </div>
  </div>
</template>

<style scoped>
.ant-form-item-explain-connected {
  min-height: 24px;
  line-height: 1.5;
  color: #ff4d4f;
  transition: color 0.3s cubic-bezier(0.215, 0.61, 0.355, 1);
  margin-top: 4px;
}

.ant-form-item-explain-error {
  font-size: 14px;
}
</style>
