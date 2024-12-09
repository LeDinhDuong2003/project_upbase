// resources/js/components/UserCrud.vue
<template>
  <div>
    <h1>User CRUD</h1>
    <button @click="showAddForm = !showAddForm">Add New User</button>
    <div v-if="showAddForm">
      <input v-model="newUser.name" placeholder="Name" />
      <input v-model="newUser.email" placeholder="Email" />
      <button @click="addUser">Add User</button>
    </div>
    <ul>
      <li v-for="user in users" :key="user.id">
        {{ user.name }} - {{ user.email }}
        <button @click="editUser(user)">Edit</button>
        <button @click="deleteUser(user.id)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      showAddForm: false,
      newUser: { name: '', email: '' }
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      axios.get('/api/users').then(response => {
        this.users = response.data;
      });
    },
    addUser() {
      axios.post('/api/users', this.newUser).then(response => {
        this.users.push(response.data);
        this.showAddForm = false;
      });
    },
    deleteUser(id) {
      axios.delete(`/api/users/${id}`).then(() => {
        this.users = this.users.filter(user => user.id !== id);
      });
    },
    editUser(user) {
      // Implement edit user logic here
    }
  }
};
</script>
