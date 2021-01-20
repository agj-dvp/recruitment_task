<template>
  <div class="searchbar">
    <div class="autosuggest-container">
      <vue-autosuggest
        v-model="query"
        :suggestions="filteredOptions"
        @focus="focusMe"
        @click="clickHandler"
        @input="onInputChange"
        @selected="onSelected"
        :get-suggestion-value="getSuggestionValue"
        :input-props="{ id: 'autosuggest__input', placeholder: 'Search...' }"
      >
        <div
          slot-scope="{ suggestion }"
          style="display: flex; align-items: center"
        >
          <p>
            <strong>{{ suggestion.item.name }}</strong
            ><br />
            <small
              ><span
                v-html="suggestion.item.description.substring(0, 80) + '...'"
              ></span
            ></small>
          </p>
        </div>
      </vue-autosuggest>
    </div>
  </div>
</template>
 
<script>
export default {
  data() {
    return {
      query: "",
      selected: "",
      suggestions: [],
      limit: 10,
    };
  },
  computed: {
    filteredOptions() {
      return [
        {
          data: this.suggestions
            .filter((option) => {
              return (
                option.name.toLowerCase().indexOf(this.query.toLowerCase()) > -1
              );
            })
            .slice(0, 4),
        },
      ];
    },
  },

  created() {
    this.fetchSuggestions();
  },

  methods: {
    async fetchSuggestions() {
      try {
        await axios.get("/api/getTechniques/0").then((response) => {
          this.suggestions = response.data;
        });
      } catch (err) {
        console.error(err);
      }
    },
    clickHandler(item) {
      // event fired when clicking on the input
    },
    onSelected(item) {
      this.selected = item.item;
      this.goToTactic(item.item.id);
    },
    onInputChange(text) {
      // event fired when the input changes
      // console.log(text)
    },
    /**
     * This is what the <input/> value is set to when you are selecting a suggestion.
     */
    getSuggestionValue(suggestion) {
      return suggestion.item.name;
    },
    focusMe(e) {
      // console.log(e) // FocusEvent
    },
    goToTactic(id) {
      this.$router.push({ name: "technique", params: { id: id } });
    },
  },
};
</script> 
