<template>
  <div class="container">
    <div class="table">
      <el-table
        :key="tableKey"
        v-loading="listLoading"
        :data="list"
        fit
        stripe
        highlight-current-row
        style="width: 100%;"
        size="small"
        :cell-style="{padding: '1px'}"
      >
        <el-table-column align="center" width="300">
          <template>
            <el-popover
              placement="right"
              trigger="hover"
            >
              <el-button slot="reference" type="primary" style="background-color:white;border-color:white">
                <img src="https://picsum.photos/640/480" height="150" width="250">
              </el-button>
              <div>
                <img src="https://picsum.photos/640/480">
              </div>
            </el-popover>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>
<script>
export default {
  name: 'ListBook',
  data() {
    return {
      tableKey: 0,
      list: null,
      total: 0,
      listLoading: true
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = false
      this.list = [
        {
          name: 'book 1',
          seller: 'seller 1',
          auth: 'auth 1',
          price: '100$',
          content: 'text'
        }
      ]
    }
  }
}
</script>
