const template = `
  <div class="solutions">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item mr-3">
        <button @click="addContact()" class="btn btn-primary">Add Contact</button>
      </li>
      <li class="nav-item mr-3">
        <button @click="validate()" class="btn btn-primary">Validate</button>
      </li>
      <li class="nav-item mr-3">
        <button @click="save()" class="btn btn-primary" :disabled="!contactForms.length">Save</button>
      </li>
    </ul>


    <form ref="contactForm" class="mt-5" v-if="contactForms.length" method="post" action="/tests/solution2">

      <div v-for="(contact, index) in contactForms">
      
        <div class="form-group row">
          <label for="colFormLabel" class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">
            <input type="text" name="names[]" v-model="contactForms[index].name" class="form-control" id="colFormLabel" placeholder="Enter your name...">
          </div>
        </div>
      
        <div class="form-group row">
          <label for="colFormLabel" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="text" name="emails[]" v-model="contactForms[index].email" class="form-control" id="colFormLabel" placeholder="Enter your email address...">
          </div>
        </div>

        <div class="form-group row">
          <label for="colFormLabel" class="col-sm-2 col-form-label">Phone Number</label>
          <div class="col-sm-10">
            <input type="text" name="phones[]" v-model="contactForms[index].phone" class="form-control" id="colFormLabel" placeholder="Enter your phone number...">
          </div>
        </div>

        <hr class="mt-5 mb-5" v-show="contactForms.length > 1">


      </div>

      
  
    </form>
    
    
  </div>
`
import { Contact } from './Contact.js';

{ /* <button ref="submit" type="submit" class="btn btn-primary">Submit</button> */ }

export default {
    template,

    props: {
        // bgColor: {
        //   type: String,
        //   default: '#dde1f3'
        // }
    },

    data() {
        return {
            contactForms: []
        }
    },

    mounted() {
        console.log('2 component mounted.')
    },

    methods: {
        addContact() {
            this.contactForms.push(new Contact());
            console.log(this.contactForms)
        },

        validate() {
            alert("validate")
        },

        save() {
            this.$refs.contactForm.submit();
        }
    }
}