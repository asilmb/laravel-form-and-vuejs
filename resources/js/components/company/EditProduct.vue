<template>
  <div>
    <h3 class="text-center">Edit Company</h3>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="updateCompany">
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

<!--  //todo:change logo       -->
<!--        <div class="form-group">-->
<!--            <label>Logo</label>-->
<!--            <input type="text" class="form-control" v-model="company.logo_url">-->
<!--            <div v-for="error in this.errors.logo_url">-->
<!--              <p class="text-danger">{{ error }}</p>-->
<!--            </div>-->
<!--          </div>-->
          <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" v-model="company.email">
            <div v-for="error in this.errors.email">
              <p class="text-danger">{{ error }}</p>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
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
        logo_url: '',
        website: ''
      },
      errors: {},
    }
  },
  created () {
    this.axios
        .get(`http://localhost/api/v1/company/${this.$route.params.id}`)
        .then((res) => {
          this.company = res.data
        }).catch(e => {
          this.errors = e.response.data.errors;
        })
  },
  methods: {
    updateCompany () {
      this.axios
          .put(`http://localhost/api/v1/company/${this.$route.params.id}`, this.company)
          .then((res) => {
            this.$router.push({ name: 'home' })
          }).catch(e => {
        this.errors = e.response.data.errors
      })
    }
  }
}
</script>