<template>
  <div>
    <h3 class="text-center">Create Product</h3>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="addCompany">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="company.name">
            <div v-for="error in this.errors.name">
              <p class="text-danger">{{ error }}</p>
            </div>
          </div>
          <div class="form-group">
            <label>Website</label>
            <input type="text" class="form-control" v-model="company.website">
            <div v-for="error in this.errors.website">
              <p class="text-danger">{{ error }}</p>
            </div>
          </div>
          <div class="form-group">
            <label>Logo</label>
            <input type="file" id="file" ref="file" accept="image/*"  v-on:change="handleFileUpload()">
            <div v-for="error in this.errors.logo_url">
              <p class="text-danger">{{ error }}</p>
            </div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" v-model="company.email">
            <div v-for="error in this.errors.email">
              <p class="text-danger">{{ error }}</p>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      company: {
        name: '',
        email: '',
        logo: '',
        logo_url: '',
        website: ''
      },
      file: '',
      errors: {},
    }
  },
  methods: {
    addCompany () {
      let formData = new FormData();
      formData.append('logo', this.file);
      formData.append('email', this.company.email);
      formData.append('name', this.company.name);
      formData.append('website', this.company.website);

      this.axios
          .post('http://localhost/api/v1/company', formData,{
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(response => (
              this.$router.push({ name: 'home' })
          ))
          .catch(e => {
            this.errors = e.response.data.errors
          })
          .finally(() => this.loading = false)
    },
    handleFileUpload(){
      this.file = this.$refs.file.files[0];
    }
  }
}
</script>