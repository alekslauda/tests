const template = `
  <div class="solutions">
    <form class="form-inline" method="GET" action="/tests/solution1">
      <div class="form-group mb-2" v-show="!items.length && term">
        <label for="staticEmail2" class="sr-only">Email</label>
        <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="No Results Found.">
      </div>
      <div class="form-group mx-sm-3 mb-2">
        <input type="text" name="term" class="form-control" id="inputPassword2" placeholder="Search for resource..." :value="term">
      </div>
      <button type="submit" class="btn btn-primary mb-2">Search</button>
    </form>

    <ul v-show="items.length" class="list-group list-group-flush mt-5">
      <li v-for="item in items" class="list-group-item">{{ item['fullpath'] }}</li>
    </ul>

  </div>
`

export default {
    template,

    props: {
        data: { type: String, default: '' }
    },

    data() {
        return {
            items: [],
            term: '',
        }
    },

    mounted() {
        this.items = JSON.parse(this.data);

        let params = new URLSearchParams(window.location.search);
        let term = params.get('term')
        this.term = term || term;
    },

    methods: {

    }
}