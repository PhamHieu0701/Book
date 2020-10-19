<template>
  <div>
    <el-row>
      <el-col :span="12">
        <el-upload
          ref="upload"
          drag
          name="file"
          :on-preview="handlePreview"
          :on-remove="handleRemove"
          action=""
          :http-request="UploadImage"
          multiple
          :file-list="fileList"
          :on-change="key_path_file"
          :auto-upload="false"
          :disabled="formDisable"
        >
          <i class="el-icon-upload" />
          <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
        </el-upload>
        <el-button v-if="showButton" type="success" size="mini" style="margin-top:10px;" @click="onUpload">
          <i class="el-icon-upload" />
          Upload
        </el-button>
      </el-col>
    </el-row>
    <el-form ref="aboutForm" :disabled="formDisable" :model="aboutInfo" label-width="120px" size="mini" class="form-info" label-position="top">
      <el-row>
        <el-divider content-position="left">Resumes infomation</el-divider>
        <el-col :span="12">
          <el-form-item label="Resumes" prop="resumeUrl" class="form-input">
            <el-input v-for="url in aboutInfo.resumeUrl" :key="url.Id" v-model="url.ResumeUrl" class="resume-item" />
          </el-form-item>
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
export default {
  name: 'AboutInformation',
  props: {
    aboutInfo: {
      type: Object,
      default() {
        return null
      }
    }
  },
  data() {
    return {
      formDisable: true,
      fileList: [],
      key_path: [],
      showButton: false,
      fileUpload: []
    }
  },
  methods: {
    handlePreview() {
      console.log()
    },
    handleRemove() {
      console.log(456)
    },
    handleUpload() {
      //
    },
    UploadImage(param) { },
    key_path_file(file, fileList) {
      this.key_path = fileList
      this.showButton = true
    },
    onUpload() {
      const formData = new FormData()
      if (this.key_path) {
        this.fileUpload = this.key_path[0].raw
      }
      formData.append('file', this.fileUpload)
      const loading = this.$loading({
        lock: this.loading,
        text: 'Uploading Data',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      })
      const data = {
        formData: formData,
        id: this.$route.query.id
      }
      this.$store.dispatch('applicant/uploadResume', data).then(response => {
        if (response.status === 200) {
          this.$notify({
            title: 'Success',
            message: 'Upload Successfully',
            type: 'success',
            duration: 2000
          })
        } else {
          this.$notify.error({
            title: 'Failed',
            message: 'Upload Failed',
            duration: 2000
          })
        }
        loading.close()
      })
    }
  }
}
</script>
