<template>
  <div>
    <h2 class="text-center">Company List</h2>

    <table class="table">
      <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Detail</th>
        <th>logo</th>
        <th>website</th>
         <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="company in companies" :key="company.id">
        <td>{{ company.id }}</td>
        <td>{{ company.name }}</td>
        <td>{{ company.email }}</td>
        <td><img v-if="company.logoUrl.length" class="company-image" :src="'storage/images/' + company.logoUrl" alt="" title="" /></td>
        <td>{{ company.website }}</td>
        <td>
          <div class="btn-group" role="group">
            <router-link :to="{name: 'edit', params: { id: company.id }}" class="btn btn-success">Edit</router-link>
            <button class="btn btn-danger" @click="deleteCompany(company.id)">Delete</button>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data () {
    return {
      companies: [],
      errors: {},
    }
  },
  created () {
    this.axios
        .get('http://localhost/api/v1/company/')
        .then(response => {
          this.companies = response.data
        })
  },
  methods: {
    deleteCompany (id) {
      this.axios
          .delete(`http://localhost/api/v1/company/${id}`)
          .then(response => {
            let i = this.companies.map(data => data.id).indexOf(id)
            this.companies.splice(i, 1)
          }).catch(e => {
             this.errors = e.response.data.errors;
          })
    }
  }
}
</script>