<template>
  <div>
    <transition name="fade" appear>
      <div v-if="!tactic.name.length && !techniques.length">
        <tile loading="loading"></tile>
      </div>
      <div v-else>
        <h2 class="mt-4">{{ tactic.name }}</h2>
        <p v-html="tactic.description" style="white-space: pre-line"></p>
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Technique name</th>
            </tr>
          </thead>
          <tbody v-for="technique in techniques" v-bind:key="technique.id">
            <tr @click="goToTechnique(technique.id)" class="data-row">
              <td scope="row">{{ technique.id }}</td>
              <td>{{ technique.name }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tactic: {
        id: "",
        name: "",
        decription: "",
      },
      techniques: [],
    };
  },

  async mounted() {
    this.fetchTactic();
    this.fetchTechniques();
    
  },

  watch: {
    $route() {
      this.fetchTactic();
      this.fetchTechniques();
    },
  },

  methods: {
    async fetchTechniques() {
      try {
        await axios
          .get("/api/getTechniques/" + this.$route.params.id)
          .then((response) => {
            this.techniques = response.data;
          });
      } catch (err) {
        console.error(err);
      }
    },
    async fetchTactic() {
      try {
        await axios
          .get("/api/getTactic/" + this.$route.params.id)
          .then((response) => {
            if (response.data[0].name.length == 0) {
              this.$router.push({ name: "404" });
            } else {
              this.tactic = response.data[0];
            }
          });
      } catch (err) {
        console.error(err);
        this.$router.push({ name: "404" });
      }
    },
    goToTechnique(id) {
      this.$router.push({ name: "technique", params: { id: id } });
    },
  },
};
</script>