<template>
  <div class="bg-light border-right" id="sidebar-wrapper">
    <router-link to="/">
      <div class="sidebar-heading text-center bg-light">
        Recruitment Task<br />
        <small class="text-secondary">Arkadiusz Gaj</small>
      </div>
    </router-link>
    <div v-if="this.loading">
      <tile loading="loading"></tile>
    </div>
    <div v-else>
      <div v-if="tactics.length">
        <div
          class="list-group list-group-flush"
          v-for="tactic in tactics"
          v-bind:key="tactic.id"
        >
          <router-link :to="{ name: 'tactic', params: { id: tactic.id } }">
            <a href="#" class="list-group-item list-group-item-action bg-light">
              {{ tactic.name }}
            </a>
          </router-link>
        </div>
      </div>
      <div v-else>No tactics in database</div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      loading: true,
      tactics: [],
      tactic: {
        id: "",
        name: "",
        description: "",
      },
      tactic_id: "",
    };
  },

  created() {
    this.fetchTactics();
  },

  methods: {
    async fetchTactics() {
      try {
        await axios.get("/api/getTactic/0").then((response) => {
          this.tactics = response.data;
          this.loading = false;
        });
      } catch (err) {
        console.error(err);
      }
    },
  },
};
</script>