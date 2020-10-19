<template>
  <div class="detail-container">
    <el-tabs v-model="activeName">
      <el-tab-pane label="General" name="general">
        <General v-if="isMounted" ref="general" :basic-info="basicInfo" />
      </el-tab-pane>
      <el-tab-pane :disabled="create" label="Resumes" name="about">
        <About v-if="isMounted" ref="about" :about-info="aboutInfo" />
      </el-tab-pane>
      <el-tab-pane :disabled="create" label="Experience" name="experience">
        <Experience v-if="isMounted" ref="experience" :experience-info="experienceInfo" />
      </el-tab-pane>
    </el-tabs>
    <div class="fixed">
      <el-divider />
      <el-button v-if="create" type="primary" size="mini" @click="submitForm">
        <i class="el-icon-edit" />
        Submit
      </el-button>
      <el-button v-if="edit" type="primary" size="mini" @click="handleEditForm">
        <i class="el-icon-edit" />
        Edit
      </el-button>
      <el-button v-if="edit" v-loading.fullscreen.lock="loading" :disabled="disable" type="primary" size="mini" @click="handleSaveForm(activeName)">
        <i class="el-icon-success" />
        Save
      </el-button>
      <el-button v-if="edit" :disabled="disable" type="danger" size="mini" plain @click="handleCancleForm">
        <i class="el-icon-back" />
        Cancel
      </el-button>
    </div>
  </div>
</template>
<script>
import { getDetailApplicant } from '@/api/applicant'
import General from './components/General'
import About from './components/About'
import Experience from './components/Experience'
export default {
  name: 'DetailApplicant',
  components: { General, About, Experience },
  data() {
    return {
      isMounted: false,
      disable: true,
      activeName: 'general',
      basicInfo: {},
      aboutInfo: {},
      experienceInfo: {},
      loading: false,
      create: false,
      edit: false
    }
  },
  mounted() {
    this.isMounted = true
    // this.$store.dispatch('applicant/createApplicant', false)
  },

  beforeMount() {
    if (this.$route.name === 'Detail') {
      this.create = false
      this.edit = true
      this.getDetail(this.$route.query.id)
    } else {
      this.create = true
      this.edit = false
      this.$store.dispatch('applicant/resetState')
      this.getState()
    }
  },
  methods: {
    getDetail(id) {
      getDetailApplicant(id).then(response => {
        this.$store.dispatch('applicant/setData', response.data).then(() => {
          this.getState()
        })
      })
    },
    getState() {
      this.basicInfo = Object.assign({}, this.$store.getters.applicant.basicInfo)
      this.aboutInfo = Object.assign({}, this.$store.getters.applicant.aboutInfo)
      this.experienceInfo = Object.assign({}, this.$store.getters.applicant.experienceInfo)
    },
    handleEditForm() {
      this.$refs['general'].$data.formDisable = false
      this.$refs['about'].$data.formDisable = false
      this.$refs['experience'].$data.formDisable = false
      this.disable = false
    },
    handleCancleForm() {
      this.$refs['general'].$data.formDisable = true
      this.$refs['about'].$data.formDisable = true
      this.$refs['experience'].$data.formDisable = true
      this.disable = true
      this.basicInfo = Object.assign({}, this.$store.getters.applicant.basicInfo)
      this.aboutInfo = Object.assign({}, this.$store.getters.applicant.aboutInfo)
      this.experienceInfo = Object.assign({}, this.$store.getters.applicant.experienceInfo)
    },
    handleSaveForm(activeName) {
      const data = {
        id: this.$route.query.id
      }
      let dispatchAction = ''
      const loading = this.$loading({
        lock: this.loading,
        text: 'Updating Data',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      })
      switch (activeName) {
        case 'general':
          data.data = this.basicInfo
          dispatchAction = 'updateGeneralInfo'
          break
        case 'about':
          data.data = this.aboutInfo
          dispatchAction = 'updateAboutInfo'
          break
        case 'experience':
          data.data = this.experienceInfo
          dispatchAction = 'updateExperienceInfo'
          break
        default:
          break
      }
      this.$store.dispatch('applicant/' + dispatchAction, data).then(response => {
        if (response === 200) {
          this.$notify({
            title: 'Success',
            message: 'Update Successfully',
            type: 'success',
            duration: 2000
          })
        } else {
          this.$notify.error({
            title: 'Failed',
            message: 'Update Failed',
            duration: 2000
          })
        }
        loading.close()
      })
    },
    submitForm() {
      const loading = this.$loading({
        lock: this.loading,
        text: 'Creating New Applicant',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      })
      this.$store.dispatch('applicant/createNewApplicant', this.basicInfo).then(response => {
        if (response.status === 200) {
          this.$notify({
            title: 'Success',
            message: 'Create Successfully',
            type: 'success',
            duration: 2000
          })
          this.$router.push('detail?id=' + response.data.data.Id)
        } else {
          this.$notify.error({
            title: 'Failed',
            message: 'Create Failed',
            duration: 2000
          })
        }
        loading.close()
      })
    }
  }
}
</script>

