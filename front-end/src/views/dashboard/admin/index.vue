<template>
  <div class="dashboard-editor-container">
    DashboardAdmin
  </div>
</template>

<script>

export default {
  name: 'DashboardAdmin'
}
</script>

<style lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  background-color: rgb(240, 242, 245);
  position: relative;

}

@media (max-width:1024px) {
  .chart-wrapper {
    padding: 8px;
  }
}
</style>
