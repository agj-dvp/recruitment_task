<template>
  <div>
    <transition name="fade" appear>
      <div v-if="!technique">
        <tile loading="loading"></tile>
      </div>
      <div v-else>
        <h2 class="mt-4">{{ technique.name }}</h2>
        <p>
          <span v-html="technique.description" style="white-space: pre-line">
          </span>
        </p>
        <button
          @click="$router.go(-1)"
          class="btn btn-outline-secondary"
          id="menu-toggle"
        >
          Back
        </button>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      technique: {
        description: "",
        name: "",
      },
    };
  },

  async mounted() {
    this.fetchTechnique();
  },

  watch: {
    $route() {
      this.fetchTechnique();
    },
  },

  methods: {
    async fetchTechnique() {
      try {
        await axios
          .get("/api/getTechnique/" + this.$route.params.id)
          .then((response) => {
            if (response.data.name.length == 0) {
              this.$router.push({ name: "404" });
            } else {
              this.technique = response.data;
            }
          });
      } catch (err) {
        console.error(err);
        this.$router.push({ name: "404" });
      }
    },
  },
};
</script>