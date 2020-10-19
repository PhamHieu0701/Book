<template>
  <div class="calendar-container">
    <calendar style="height: 800px;" />
  </div>
</template>
<script>
import 'tui-calendar/dist/tui-calendar.css'
import { Calendar } from '@toast-ui/vue-calendar'

export default {
  name: 'Calendar',
  components: {
    'calendar': Calendar
  }
}
</script>
<style lang="scss" scoped>
.calendar-container {
    padding: 8px;
}
</style>
