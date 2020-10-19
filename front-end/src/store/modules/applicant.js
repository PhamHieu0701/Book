import {
  updateGeneralInfo,
  updateAboutInfo,
  updateExperienceInfo,
  createNewApplicant,
  deleteApplicant,
  uploadResume
} from '@/api/applicant'

const initialState = {
  id: '',
  basicInfo: {
    firstName: '',
    lastName: '',
    birthDay: '',
    phoneNumber: '',
    email: '',
    street: '',
    state: '',
    city: '',
    country: '',
    streetNumber: '',
    postcode: '',
    latitude: '',
    longitude: '',
    skype: '',
    icq: '',
    gtalk: '',
    qq: '',
    wechat: '',
    websiteUrl: '',
    about: ''
  },
  aboutInfo: {
    photoUrl: '',
    resumeUrl: []
  },
  experienceInfo: {
    experience: [],
    skills: []
  }
}

const mutations = {
  SET_DATA: (state, data) => {
    state.id = data.id
    state.basicInfo = data.basicInfo
    state.aboutInfo = data.aboutInfo
    state.experienceInfo = data.experienceInfo
  },
  SET_BASIC_DATA: (state, data) => {
    state.basicInfo = data
  },
  SET_ABOUT_DATA: (state, data) => {
    state.basicInfo = data
  },
  SET_EXPERIENCE_DATA: (state, data) => {
    state.experienceInfo = data
  },
  RESET_STATE: (state) => {
    state.id = initialState.id
    state.aboutInfo = initialState.basicInfo
    state.basicInfo = initialState.basicInfo
    state.experience = initialState.experienceInfo
  }
}

const actions = {
  setData({ commit }, data) {
    return new Promise((resolve, reject) => {
      commit('SET_DATA', data)
      resolve(data)
    })
  },
  updateGeneralInfo({ commit }, data) {
    return new Promise((resolve, reject) => {
      updateGeneralInfo(data).then(response => {
        if (response.status === 200) {
          commit('SET_BASIC_DATA', data.data)
        }
        resolve(response.status)
      }).catch(err => {
        console.log(err)
        reject(err)
      })
    })
  },
  updateAboutInfo({ commit }, data) {
    return new Promise((resolve, reject) => {
      updateAboutInfo(data).then(response => {
        if (response.status === 200) {
          commit('SET_ABOUT_DATA', data.data)
        }
        resolve(response.status)
      }).catch(err => {
        console.log(err)
        reject(err)
      })
    })
  },
  updateExperienceInfo({ commit }, data) {
    return new Promise((resolve, reject) => {
      updateExperienceInfo(data).then(response => {
        if (response.status === 200) {
          commit('SET_EXPERIENCE_DATA', data.data)
        }
        resolve(response.status)
      }).catch(err => {
        console.log(err)
        reject(err)
      })
    })
  },
  resetState({ commit }) {
    commit('RESET_STATE')
  },
  createNewApplicant({ commit }, data) {
    return new Promise((resolve, reject) => {
      createNewApplicant(data).then(response => {
        console.log(response)
        resolve(response)
      }).catch(err => {
        reject(err)
      })
    })
  },
  deleteApplicant({ commit }, id) {
    return new Promise((resolve, reject) => {
      deleteApplicant(id).then(response => {
        resolve(response.status)
      })
    })
  },
  uploadResume({ commit }, data) {
    return new Promise((resolve, reject) => {
      uploadResume(data.formData).then(response => {
        console.log(response)
        if (response.status === 200) {
          resolve(response)
        }
      })
    })
  }
}

export default {
  namespaced: true,
  state: Object.assign({}, initialState),
  mutations,
  actions
}
