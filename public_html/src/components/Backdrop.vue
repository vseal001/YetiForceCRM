<!--
/**
 * Backdrop component
 *
 * @description Global component
 * @license YetiForce Public License 3.0
 * @author Tomasz Poradzewski <t.poradzewski@yetiforce.com>
 */
-->
<template>
  <div class="backdrop"></div>
</template>

<script>
export default {
  name: 'Backdrop'
}
</script>
<style scoped>
.backdrop {
  background-color: rgba(0, 0, 0, 0.4);
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  position: absolute;
  z-index: 2999 !important;
}
</style>
