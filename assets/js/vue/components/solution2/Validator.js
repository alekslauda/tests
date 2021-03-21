export class Validator {

    constructor(values) {
        this.constraints = {
            name: {
                required: true,
                isValidName: (str) => {
                    var pattern = /^[a-zA-Z\s]*$/;
                    return pattern.test(str);
                },
            },
            email: {
                required: true,
                email: (txt) => {
                    var re = /\S+@\S+\.\S+/;
                    return re.test(txt);
                }
            },
            phone: {
                required: true,
                isNumber: (str) => {
                    var pattern = /^\d+$/;
                    return pattern.test(str);
                },
            }

        }
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
        this.errors = {

        };
        this.errors2 = [];
    }

    validateRequired(contact, index) {
        this.errors2[index] = {}
        this.errors2[index]['names.' + index] = [];
        this.errors2[index]['emails.' + index] = [];
        this.errors2[index]['phones.' + index] = [];
        if (!contact.name) {
            this.errors2[index]['names.' + index].push('FE VALIDATION: Name is required.');
        }

        if (!contact.email) {
            this.errors2[index]['emails.' + index].push('FE VALIDATION: Email is required.');
        }

        if (!contact.phone) {
            this.errors2[index]['phones.' + index].push('FE VALIDATION: Phone Number is required.');
        }
    }

    validateIsValidName(name, index) {
        if (!this.isValidName(name)) {
            this.errors2[index]['names.' + index].push('FE VALIDATION: Name is invalid. Should contains only letters and spaces.')
        }
    }

    validateIsValidEmail(email, index) {
        if (!this.isEmail(email)) {
            this.errors2[index]['emails.' + index].push('FE VALIDATION: Email is invalid.')
        }
    }

    validateIsValidPhoneNumber(phone, index) {
        if (!this.isNumber(phone)) {
            this.errors2[index]['phones.' + index].push('FE VALIDATION: Name is invalid. Should contains only numbers.')
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
        return !Object.keys(this.errors2).length
    }

    getErrors() {
        return this.errors2;
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
        console.log("reorder", reOrder);
        return reOrder;
    }

    capitalizeField(field) {
        return field.charAt(0).toUpperCase() + field.slice(1);
    }
}