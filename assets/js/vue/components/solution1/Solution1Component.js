const template = `
  <div class="solutions">
    {{ text }}
    <button @click="clicked()">Click me</button>
  </div>
`

export default {
  template,

  props: {
    // bgColor: {
    //   type: String,
    //   default: '#dde1f3'
    // }
  },

  data () {
    return {
      text: '1'
    }
  },

  mounted () {
    console.log('1 component mounted.')
  },

  methods: {
    clicked() {
      alert("Hey!");
    }
  }
}
