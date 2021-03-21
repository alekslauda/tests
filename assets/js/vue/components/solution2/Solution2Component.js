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
        <button :disabled="loading" type="submit" form="contact-form" class="btn btn-primary">Save</button>
      </li>
    </ul>


    <form id="contact-form" ref="contactForm" @submit.prevent="submitForm()" class="mt-5" v-if="contactForms.length" method="post" action="/tests/solution2">
    
      <div v-for="(contact, index) in contactForms">
        <div class="form-group row">
          <label for="colFormLabel" class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-7">
            <input type="text" name="names[]" v-model="contactForms[index].name" :class="{ 'form-control': true,  'is-invalid': errors['names.' + index] && errors['names.' + index].length }" id="colFormLabel" placeholder="Enter your name...">
          </div>
          <div v-if="errors['names.' + index]" class="col-sm-3">
            <small id="nameHelp" class="text-danger">
              {{ errors['names.' + index][0] }}
            </small>      
          </div>
        </div>
      
        <div class="form-group row">
          <label for="colFormLabel" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-7">
            <input type="text" name="emails[]" v-model="contactForms[index].email" :class="{ 'form-control': true,  'is-invalid': errors['emails.' + index] && errors['emails.' + index].length }" id="colFormLabel" placeholder="Enter your email address...">
          </div>
          <div v-if="errors['emails.' + index]" class="col-sm-3">
            <small id="emailsHelp" class="text-danger">
              {{ errors['emails.' + index][0] }}
            </small>      
          </div>
        </div>

        <div class="form-group row">
          <label for="colFormLabel" class="col-sm-2 col-form-label">Phone Number</label>
          <div class="col-sm-7">
            <input type="text" name="phones[]" v-model="contactForms[index].phone" :class="{ 'form-control': true,  'is-invalid': errors['phones.' + index] && errors['phones.' + index].length }" id="colFormLabel" placeholder="Enter your phone number...">
          </div>
          <div v-if="errors['phones.' + index]" class="col-sm-3">
            <small id="phonesHelp" class="text-danger">
              {{ errors['phones.' + index][0] }}
            </small>      
          </div>
        </div>

        <input type="hidden" name="forms_submitted" v-model="contactForms.length" />
        <button @click="removeForm(index)" v-if="index > 0" type="button" class="btn btn-warning">Remove Contact From - {{ index }} </button>

        <hr class="mt-5 mb-5" v-show="contactForms.length > 1">

      </div>
      
    </form>

    <hr class="mt-5 mb-5" v-show="contactsList.length">

    <div class="container mt-5" v-if="contactsList.length">
      <h2>Contacts List</h2>
      <p>See all contacts and remove a contact if you want :) </p>            
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(contact, index) in contactsList">
            <td>{{ contact['id'] }}</td>
            <td>{{ contact['name'] }}</td>
            <td>{{ contact['email'] }}</td>
            <td>{{ contact['phone'] }}</td>
            <td>
            <span class="glyphicon glyphicon-name"></span>
              <button :disabled="loading" @click="removeContact(index)" type="button" class="btn btn-secondary btn-sm">Remove Contact</button>
            </td>
          </tr>
          
        </tbody>
      </table>
    </div>
    
    
  </div>
`
import { Contact } from './Contact.js';
import { Validator } from './Validator.js';


export default {
    template,

    props: {
        contacts: { type: String, default: '' }
    },

    data() {
        return {
            contactForms: [],
            validator: {},
            errors: {},
            loading: false,
            contactsList: [],
        }
    },

    mounted() {
        this.contactForms.push(new Contact());
        this.contactsList = JSON.parse(this.contacts);
        console.log("contacts", this.contactsList);
        this.validator = new Validator(this.contactForms);
    },

    methods: {

        addContact() {
            this.contactForms.push(new Contact());
        },

        validate() {
            this.errors = {};
            this.validator.validate();
            if (!this.validator.isValid()) {
                this.mapVlidatorErrors();
            }
        },

        mapVlidatorErrors() {
            let errors = {};
            let validationErrors = [...this.validator.getMatchingBEerrors()];
            for (let err in validationErrors) {
                errors = {
                    ...errors,
                    ...validationErrors[err]
                };
            }
            this.errors = errors;
        },

        submitForm() {
            const formData = new FormData(this.$refs.contactForm);
            this.errors = {};
            this.loading = true;

            axios.post('/tests/solution2', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
                baseURL: 'http://localhost:8000',
            }).then(response => {
                this.loading = false;
                window.location.href = response.data.success.redirectTo;
            }).catch(error => {
                this.loading = false;
                if (error.response && error.response.status === 422 && error.response.data.errors) {
                    console.log(error.response.data);
                    this.errors = error.response.data.errors;

                }
            })
        },

        removeForm(index) {
            this.contactForms.splice(index, 1);
            this.validator.getErrors().splice(index, 1);
            this.mapVlidatorErrors();
        },

        removeContact(index) {
            this.loading = true;
            axios.delete('/tests/solution2', {
                data: {
                    contactId: index
                }
            }).then(res => {
                this.loading = false;
                window.location.href = res.data.success.redirectTo;
            }).catch(err => {
                this.loading = false;
                console.log("Err", err);
            })
        }
    }
}