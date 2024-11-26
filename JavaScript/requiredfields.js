function validateEnrollmentForm(postData) {
    // Get empty required fields
    let emptyFields = [];

    // Helper function to check if a field is empty
    function isFieldEmpty(fieldId) {
        const field = document.getElementById(fieldId);
        if (!field) return false; // Skip if field doesn't exist

        const value = field.value;
        return !value || value.trim() === '' || 
               value === 'null' || value === 'undefined' || 
               value === '0' || value === 'Select' || 
               value === '-- Select --';
    }

    // Check basic required fields
    ['last-name', 'first-name', 'birthdate', 'gender', 
     'mother-tongue', 'place-of-birth'].forEach(fieldId => {
        if (isFieldEmpty(fieldId)) {
            emptyFields.push(fieldId);
        }
    });

    // Check IP fields
    const ipSelect = document.getElementById('ip');
    if (ipSelect && ipSelect.value === 'Yes') {
        if (isFieldEmpty('ip-specify')) {
            emptyFields.push('ip-specify');
        }
        const ipSpecifyField = document.getElementById('ip-specify');
        if (ipSpecifyField && ipSpecifyField.value === 'Others' && isFieldEmpty('ip-other')) {
            emptyFields.push('ip-other');
        }
    }

    // Check Disability fields
    const disabilitySelect = document.getElementById('disability');
    if (disabilitySelect && disabilitySelect.value === 'Yes') {
        if (isFieldEmpty('disability-specify')) {
            emptyFields.push('disability-specify');
        }
        const disabilitySpecifyField = document.getElementById('disability-specify');
        if (disabilitySpecifyField && disabilitySpecifyField.value === 'Others' && isFieldEmpty('disability-other')) {
            emptyFields.push('disability-other');
        }
    }

    // Check 4Ps Beneficiary fields
    const beneficiarySelect = document.getElementById('beneficiary');
    if (beneficiarySelect && beneficiarySelect.value === 'Yes' && isFieldEmpty('beneficiary-specify')) {
        emptyFields.push('beneficiary-specify');
    }

    // Check address fields
    const sameAddressCheckbox = document.getElementById('same-address');
    if (!sameAddressCheckbox || !sameAddressCheckbox.checked) {
        ['house-number', 'street-name', 'barangay', 'city', 'province', 'zip-code'].forEach(field => {
            if (isFieldEmpty(field)) {
                emptyFields.push(field);
            }
            if (isFieldEmpty(field + '-permanent')) {
                emptyFields.push(field + '-permanent');
            }
        });
    }

    // Check Parent's Information
    ['father-last-name', 'father-first-name', 
     'mother-last-name', 'mother-first-name',
     'guardian-last-name', 'guardian-first-name'].forEach(field => {
        if (isFieldEmpty(field)) {
            emptyFields.push(field);
        }
    });

    // Check student type fields
    const studentType = document.getElementById('student-type');
    if (studentType && ['Transferee', 'Returnee'].includes(studentType.value)) {
        ['last-grade', 'last-school-year', 'last-school'].forEach(field => {
            if (isFieldEmpty(field)) {
                emptyFields.push(field);
            }
        });
    }

    // Show modal only if there are empty fields
    if (emptyFields.length > 0) {
        const fieldNames = {
            'last-name': 'Last Name',
            'first-name': 'First Name',
            'birthdate': 'Birthdate',
            'gender': 'Gender',
            'mother-tongue': 'Mother Tongue',
            'place-of-birth': 'Place of Birth',
            'ip-specify': 'IP Specify',
            'ip-other': 'IP Other',
            'disability-specify': 'Disability Specify',
            'disability-other': 'Disability Other',
            'beneficiary-specify': 'Beneficiary Specify',
            'house-number': 'Current House Number',
            'street-name': 'Current Street Name',
            'barangay': 'Current Barangay',
            'city': 'Current City',
            'province': 'Current Province',
            'zip-code': 'Current Zip Code',
            'house-number-permanent': 'Permanent House Number',
            'street-name-permanent': 'Permanent Street Name',
            'barangay-permanent': 'Permanent Barangay',
            'city-permanent': 'Permanent City',
            'province-permanent': 'Permanent Province',
            'zip-code-permanent': 'Permanent Zip Code',
            'father-last-name': 'Father\'s Last Name',
            'father-first-name': 'Father\'s First Name',
            'mother-last-name': 'Mother\'s Last Name',
            'mother-first-name': 'Mother\'s First Name',
            'guardian-last-name': 'Guardian\'s Last Name',
            'guardian-first-name': 'Guardian\'s First Name',
            'last-grade': 'Last Grade',
            'last-school-year': 'Last School Year',
            'last-school': 'Last School'
        };

        let errorMessage = 'Please fill in the following required fields:<ul>';
        emptyFields.forEach(field => {
            errorMessage += `<li>${fieldNames[field]}</li>`;
        });
        errorMessage += '</ul>';
        
        document.getElementById("modalMessage").innerHTML = errorMessage;
        $("#warningModal").modal("show");
        return false;
    }

    return true;
}