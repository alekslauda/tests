export class Validator {

    constructor(values) {
        this.isValidName = (str) => {
                var pattern = /^[a-zA-Z\s]*$/;
                return pattern.test(str);
            },

            this.isEmail = (txt) => {
                var re = /\S+@\S+\.\S+/;
                return re.test(txt);
            }

        this.isNumber = (str) => {
                var pattern = /^\d+$/;
                return pattern.test(str);
            },

            this.values = values;
        this.errors = [];
    }

    validateRequired(contact, index) {
        this.errors[index] = {}
        this.errors[index]['names.' + index] = [];
        this.errors[index]['emails.' + index] = [];
        this.errors[index]['phones.' + index] = [];
        if (!contact.name) {
            this.errors[index]['names.' + index].push('FE VALIDATION: Name is required.');
        }

        if (!contact.email) {
            this.errors[index]['emails.' + index].push('FE VALIDATION: Email is required.');
        }

        if (!contact.phone) {
            this.errors[index]['phones.' + index].push('FE VALIDATION: Phone Number is required.');
        }
    }

    validateIsValidName(name, index) {
        if (!this.isValidName(name)) {
            this.errors[index]['names.' + index].push('FE VALIDATION: Name is invalid. Should contains only letters and spaces.')
        }
    }

    validateIsValidEmail(email, index) {
        if (!this.isEmail(email)) {
            this.errors[index]['emails.' + index].push('FE VALIDATION: Email is invalid.')
        }
    }

    validateIsValidPhoneNumber(phone, index) {
        if (!this.isNumber(phone)) {
            this.errors[index]['phones.' + index].push('FE VALIDATION: Phone Number is invalid. Should contains only numbers.')
        }
    }

    validate() {

        for (let index in this.values) {
            let contact = this.values[index];
            this.validateRequired(contact, index);
            this.validateIsValidName(contact.name, index);
            this.validateIsValidEmail(contact.email, index);
            this.validateIsValidPhoneNumber(contact.phone, index);
        }

    }

    isValid() {
        return !Object.keys(this.errors).length
    }

    getErrors() {
        return this.errors;
    }

    getMatchingBEerrors() {
        let errors = [...this.getErrors()];
        let reOrder = errors.map((err, index) => {
            let newObj = Object.values(err);

            return {
                ['names.' + index]: newObj[0] ? newObj[0] : [],
                ['emails.' + index]: newObj[1] ? newObj[1] : [],
                ['phones.' + index]: newObj[2] ? newObj[2] : [],
            }
        })
        return reOrder;
    }

    capitalizeField(field) {
        return field.charAt(0).toUpperCase() + field.slice(1);
    }
}