<template>
  <div>
    <el-form ref="generalForm" :disabled="formDisable" :model="basicInfo" :rules="ruleFormInfo" size="mini" label-position="top">
      <el-row>
        <el-divider content-position="left">Basic infomation</el-divider>
        <el-col :span="12">
          <el-form-item label="First name" prop="firstName" class="form-input">
            <el-input v-model="basicInfo.firstName" placeholder="First name" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Last name" prop="lastName" class="form-input">
            <el-input v-model="basicInfo.lastName" placeholder="Last name" />
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="12">
          <el-form-item label="Birth Day" prop="birthday" class="form-input">
            <el-date-picker v-model="basicInfo.birthDay" type="date" placeholder="Birth day" style="width: 100%;" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Phone Number" prop="phoneNumber" class="form-input">
            <el-input v-model="basicInfo.phoneNumber" />
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="12">
          <el-form-item label="Email" prop="email" class="form-input">
            <el-input v-model="basicInfo.email" />
          </el-form-item>
        </el-col>
      </el-row>
      <br>
      <el-divider content-position="left">Messenger infomation</el-divider>
      <el-row>
        <el-col :span="12">
          <el-form-item label="Skype" prop="skype" class="form-input">
            <el-input v-model="basicInfo.skype" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Icq" prop="icq" class="form-input">
            <el-input v-model="basicInfo.icq" />
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="12">
          <el-form-item label="Qq" prop="qq" class="form-input">
            <el-input v-model="basicInfo.qq" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Gtalk" prop="gtalk" class="form-input">
            <el-input v-model="basicInfo.gtalk" />
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="12">
          <el-form-item label="Wechat" prop="wechat" class="form-input">
            <el-input v-model="basicInfo.wechat" />
          </el-form-item>
        </el-col>
      </el-row>
      <br>
      <el-divider content-position="left">Address infomation</el-divider>
      <el-row>
        <el-col :span="12">
          <el-form-item label="Street" prop="street" class="form-input">
            <el-input v-model="basicInfo.street" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="State" prop="state" class="form-input">
            <el-input v-model="basicInfo.state" />
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="12">
          <el-form-item label="City" prop="city" class="form-input">
            <el-input v-model="basicInfo.city" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Country" prop="country" class="form-input">
            <el-input v-model="basicInfo.country" />
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="12">
          <el-form-item label="Street Number" prop="streetNumber" class="form-input">
            <el-input v-model="basicInfo.streetNumber" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Postcode" prop="postcode" class="form-input">
            <el-input v-model="basicInfo.postcode" />
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="12">
          <el-form-item label="Latitude" prop="latitude" class="form-input">
            <el-input v-model="basicInfo.latitude" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Longitude" prop="longitude" class="form-input">
            <el-input v-model="basicInfo.longitude" />
          </el-form-item>
        </el-col>
      </el-row>
      <br>
      <el-divider content-position="left">About</el-divider>
      <el-row>
        <el-col :span="12">
          <el-form-item label="Website URL" prop="websiteUrl" class="form-input">
            <el-input v-model="basicInfo.websiteUrl" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="About" prop="about" class="form-input">
            <el-input v-model="basicInfo.about" type="textarea" />
          </el-form-item>
        </el-col>
      </el-row>
      <br>
    </el-form>
  </div>
</template>
<script>
export default {
  name: 'GeneralInformation',
  props: {
    basicInfo: {
      type: Object,
      default() {
        return null
      }
    }
  },
  data() {
    return {
      formDisable: true,
      ruleFormInfo: {
        firstName: [
          { required: true, message: 'Please input First name', trigger: 'blur' }
        ],
        lastName: [
          { required: true, message: 'Please input Last name', trigger: 'blur' }
        ],
        email: [
          { required: true, message: 'Please input Email', trigger: 'blur' }
        ],
        street: [
          { required: true, message: 'Please input Street', trigger: 'blur' }
        ],
        state: [
          { required: true, message: 'Please input Street', trigger: 'blur' }
        ],
        city: [
          { required: true, message: 'Please input Street', trigger: 'blur' }
        ],
        country: [
          { required: true, message: 'Please input Street', trigger: 'blur' }
        ]
      }
    }
  },
  created() {
    if (this.$route.name === 'Create') {
      this.formDisable = false
    }
  }
}
</script>
