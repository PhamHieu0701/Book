import axios from 'axios'
import dateFormat from 'dateformat'

export function getListApplicant() {
  return axios.get('http://localhost:8000/api/v1/applicant', {
    transformResponse: [
      (data) => {
        const result = JSON.parse(data, true)
        const convert_data = {
          total: result.data.total,
          items: []
        }
        result.data.items.forEach(item => {
          const convert_item = {
            id: item.Id,
            name: item.FirstName + ' ' + item.LastName,
            birthday: item.Birthday.Day + '/' + item.Birthday.Month + '/' + item.Birthday.Year,
            email: item.EmailAddress,
            phone: item.PhoneNumber,
            address: item.Address.Street + ' ' + item.Address.State + ' ' + item.Address.City + ' ' + item.Address.Country,
            photo: item.PhotoUrl
          }
          convert_data.items.push(convert_item)
        })
        return convert_data
      }
    ]
  })
}
export function getDetailApplicant(id) {
  return axios.get('http://localhost:8000/api/v1/applicant/' + id, {
    transformResponse: [
      (data) => {
        const result = JSON.parse(data, true)
        const convert_data = {
          id: result.data.Id,
          basicInfo: {
            firstName: result.data.FirstName,
            lastName: result.data.LastName,
            birthDay: dateFormat(new Date(result.data.Birthday.Year + '-' + result.data.Birthday.Month + '-' + result.data.Birthday.Day), 'isoDate'),
            phoneNumber: result.data.PhoneNumber,
            email: result.data.EmailAddress,
            street: result.data.Address.Street,
            state: result.data.Address.State,
            city: result.data.Address.City,
            country: result.data.Address.Country,
            streetNumber: result.data.Address.StreetNumber,
            postcode: result.data.Address.Postcode,
            latitude: result.data.Address.Latitude,
            longitude: result.data.Address.Longitude,
            skype: result.data.InstantMessenger.Skype,
            icq: result.data.InstantMessenger.Icq,
            gtalk: result.data.InstantMessenger.Gtalk,
            qq: result.data.InstantMessenger.Qq,
            wechat: result.data.InstantMessenger.Wechat,
            websiteUrl: result.data.WebsiteUrl,
            about: result.data.About
          },
          aboutInfo: {
            photoUrl: result.data.PhotoUrl,
            resumeUrl: result.data.Resumes
          },
          experienceInfo: {
            experience: [],
            skills: []
          }
        }
        result.data.Experience.forEach(item => {
          const start = dateFormat((!item.StartYear || !item.StartMonth) ? null : item.StartYear + '-' + item.StartMonth, 'isoDate')
          const end = dateFormat((!item.EndYear || !item.EndMonth) ? null : item.EndYear + '-' + item.EndMonth, 'isoDate')
          const convert_item = {
            id: item.Id,
            title: item.Title,
            type: item.EmploymentType,
            companyName: item.CompanyName,
            geoLocation: item.GeoLocationName,
            startTime: start,
            endTime: end,
            currentlyWorkHere: !item.CurrentlyWorksHere ? 'No' : 'Yes',
            description: item.Description,
            headline: item.HeadLine
          }
          convert_data.experienceInfo.experience.push(convert_item)
        })
        result.data.Skills.forEach(item => {
          const convert_item = {
            id: item.Id,
            name: item.Name,
            notUse: !item.NotUse ? 'No' : 'Yes'
          }
          convert_data.experienceInfo.skills.push(convert_item)
        })
        return convert_data
      }
    ]
  })
}
export function updateGeneralInfo(data) {
  return axios.put('http://localhost:8000/api/v1/applicant/' + data.id, {
    Id: data.id,
    FirstName: data.data.firstName,
    LastName: data.data.lastName,
    EmailAddress: data.data.email,
    PhoneNumber: data.data.phoneNumber,
    Birthday: {
      Year: dateFormat(new Date(data.data.birthDay), 'yyyy'),
      Month: dateFormat(new Date(data.data.birthDay), 'mm'),
      Day: dateFormat(new Date(data.data.birthDay), 'dd')
    },
    Address: {
      Street: data.data.street,
      State: data.data.state,
      City: data.data.city,
      Country: data.data.country,
      StreetNumber: data.data.streetNumber,
      Postcode: data.data.postcode,
      Latitude: data.data.latitude,
      Longitude: data.data.longitude
    },
    InstantMessenger: {
      Skype: data.data.skype,
      Icq: data.data.icq,
      Gtalk: data.data.gtalk,
      Qq: data.data.qq,
      Wechat: data.data.wechat
    },
    WebsiteUrl: data.data.websiteUrl,
    About: data.data.about
  })
}
export function updateAboutInfo(data) {
  return axios.put('http://localhost:8000/api/v1/applicant/' + data.id, {
    PhotoUrl: data.data.photoUrl,
    Resumes: data.data.resumeUrl
  })
}
export function updateExperienceInfo(data) {
  const Experience = []
  const Skills = []
  data.data.experience.forEach(item => {
    const convert_item = {
      Id: item.id,
      Title: item.title,
      EmploymentType: item.type,
      CompanyName: item.companyName,
      GeoLocationName: item.geoLocation,
      StartYear: dateFormat(new Date(item.startTime), 'yyyy'),
      StartMonth: dateFormat(new Date(item.startTime), 'mm'),
      EndYear: !item.endTime ? '' : dateFormat(new Date(item.endTime), 'yyyy'),
      EndMonth: !item.endTime ? '' : dateFormat(new Date(item.endTime), 'mm'),
      CurrentlyWorkHere: item.currentlyWorksHere === 'No' ? 0 : 1,
      Description: item.description,
      HeadLine: item.headline
    }
    Experience.push(convert_item)
  })
  data.data.skills.forEach(item => {
    const convert_item = {
      Id: item.id,
      Name: item.name,
      NotUse: item.notUse === 'No' ? 0 : 1
    }
    Skills.push(convert_item)
  })
  return axios.put('http://localhost:8000/api/v1/applicant/' + data.id, {
    Experience: Experience,
    Skills: Skills
  })
}
export function createNewApplicant(data) {
  return axios.post('http://localhost:8000/api/v1/applicant', {
    FirstName: data.firstName,
    LastName: data.lastName,
    EmailAddress: data.email,
    PhoneNumber: data.phoneNumber,
    Birthday: {
      Year: dateFormat(new Date(data.birthDay), 'yyyy'),
      Month: dateFormat(new Date(data.birthDay), 'mm'),
      Day: dateFormat(new Date(data.birthDay), 'dd')
    },
    Address: {
      Street: data.street,
      State: data.state,
      City: data.city,
      Country: data.country,
      StreetNumber: data.streetNumber,
      Postcode: data.postcode,
      Latitude: data.latitude,
      Longitude: data.longitude
    },
    InstantMessenger: {
      Skype: data.skype,
      Icq: data.icq,
      Gtalk: data.gtalk,
      Qq: data.qq,
      Wechat: data.wechat
    },
    WebsiteUrl: data.websiteUrl,
    About: data.about
  })
}
export function deleteApplicant(id) {
  return axios.delete('http://localhost:8000/api/v1/applicant/' + id)
}
export function uploadResume(formData) {
  return axios.post('http://localhost:8000/api/v1/applicant/resume', formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
}
export function updateResumes(id, data) {
  const resumes = {
    Id: 0,
    ResumeUrl: data
  }
  // console.log(data)
  // data.forEach(item => [
  //   resumes.push(item)
  // ])
  return axios.put('http://localhost:8000/api/v1/applicant/' + id, {
    Resumes: resumes
  })
}
