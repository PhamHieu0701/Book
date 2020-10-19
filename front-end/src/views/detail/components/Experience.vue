<template>
  <div>
    <el-form ref="experienceForm" :disabled="formDisable" :model="experienceInfo" label-width="120px" size="mini" class="form-info" label-position="top">
      <el-row>
        <el-divider content-position="left">Experience infomation</el-divider>
        <el-col>
          <el-table
            :key="tableKey"
            :data="experienceInfo.experience"
            style="width: 100%; margin-bottom:15px"
            size="small"
          >
            <el-table-column label="Title" min-width="100">
              <template slot-scope="{row}">
                <el-input v-model="row.title" size="small" style="text-align:center" controls-position="right" />
              </template>
            </el-table-column>
            <el-table-column label="Type" width="100">
              <template slot-scope="{row}">
                <el-input v-model="row.type" size="small" style="text-align:center" controls-position="right" />
              </template>
            </el-table-column>
            <el-table-column label="Company Name" width="200">
              <template slot-scope="{row}">
                <el-input v-model="row.companyName" size="small" style="text-align:center" controls-position="right" />
              </template>
            </el-table-column>
            <el-table-column label="GeoLocation Name" min-width="100">
              <template slot-scope="{row}">
                <el-input v-model="row.geoLocation" size="small" style="text-align:center" controls-position="right" />
              </template>
            </el-table-column>
            <el-table-column label="Start Time" width="150">
              <template slot-scope="{row}">
                <el-date-picker v-model="row.startTime" type="date" placeholder="Start Time" style="width: 100%;" />
              </template>
            </el-table-column>
            <el-table-column label="End Time" width="150">
              <template slot-scope="{row}">
                <el-date-picker v-model="row.endTime" type="date" placeholder="End Time" style="width: 100%;" @input="onInput" />
              </template>
            </el-table-column>
            <el-table-column label="Head Line" width="150">
              <template slot-scope="{row}">
                <el-input v-model="row.headLine" size="small" style="text-align:center" controls-position="right" />
              </template>
            </el-table-column>
            <el-table-column label="Currently Work Here" width="150">
              <template slot-scope="{row}">
                <el-input v-model="row.currentlyWorkHere" size="small" style="text-align:center" controls-position="right" />
              </template>
            </el-table-column>
            <el-table-column label="Description" min-width="150">
              <template slot-scope="{row}">
                <el-input v-model="row.description" size="small" style="text-align:center" controls-position="right" />
              </template>
            </el-table-column>
          </el-table>
        </el-col>
      </el-row>
      <el-row>
        <el-divider content-position="left">Skills infomation</el-divider>
        <el-col>
          <el-table
            :key="tableKey"
            :data="experienceInfo.skills"
            style="width: 100%;"
            size="small"
          >
            <el-table-column label="Name" min-width="200">
              <template slot-scope="{row}">
                <el-input v-model="row.name" size="small" style="text-align:center" controls-position="right" />
              </template>
            </el-table-column>
            <el-table-column label="Not Use" min-width="100">
              <template slot-scope="{row}">
                <el-input v-model="row.notUse" size="small" style="text-align:center" controls-position="right" />
              </template>
            </el-table-column>
          </el-table>
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>
<script>
export default {
  name: 'ExperinenceInformation',
  props: {
    experienceInfo: {
      type: [Object],
      default() {
        return null
      }
    }
  },
  data() {
    return {
      tableKey: 0,
      formDisable: true
    }
  },
  methods: {
    onInput() {
      console.log(this.experienceInfo)
    }
  }
}
</script>>
