function toggleIPOptions() {
    const ipYesElement = document.getElementById('ip-yes');
    if (!ipYesElement) {
        console.error("Element with ID 'ip-yes' not found.");
        return;
    }
    const ipYes = ipYesElement.checked; 
    const ipOptionsDiv = document.getElementById('ip-options');

    if (ipYes) {
        ipOptionsDiv.classList.remove('hidden');
        toggleIOtherTextInput();
    } else {
        ipOptionsDiv.classList.add('hidden');
        document.getElementById('ip-other-options').classList.add('hidden');
    }
}

function toggleIOtherTextInput() {
    const ipSpecifyElement = document.getElementById('ip-specify');
    if (!ipSpecifyElement) {
        console.error("Element with ID 'ip-specify' not found.");
        return;
    }
    const selectedValue = ipSpecifyElement.value;
    const ipOtherOptionsDiv = document.getElementById('ip-other-options');

    if (selectedValue === 'Others') {
        ipOtherOptionsDiv.classList.remove('hidden');
    } else {
        ipOtherOptionsDiv.classList.add('hidden');
    }
}

// Similar checks should be added for other functions

function toggleDisabilityOptions() {
    const disabilityYes = document.getElementById('disability-yes').checked;
    const options = document.getElementById('disability-options');
    const otherOptions = document.getElementById('disability-other-options');

    if (disabilityYes) {
        options.classList.remove('hidden');
        toggleDisabilityTextInput(); // Evaluate dropdown's current state
    } else {
        options.classList.add('hidden');
        otherOptions.classList.add('hidden'); // Ensure other options are hidden
    }
}

function toggleDisabilityTextInput() {
    const specify = document.getElementById('disability-specify');
    const otherOptions = document.getElementById('disability-other-options');

    // Show "disability-other-options" only if "Others" is selected
    if (specify.value === 'Others') {
        otherOptions.classList.remove('hidden');
    } else {
        otherOptions.classList.add('hidden');
    }
}

        function toggleBeneficiaryOptions() {
            var yesRadio = document.getElementById('beneficiary-yes');
            var beneficiaryOptions = document.getElementById('beneficiary-options');
            if (yesRadio.checked) {
                beneficiaryOptions.classList.remove('hidden');
            } else {
                beneficiaryOptions.classList.add('hidden');
            }
        }

        // Function to toggle the visibility of the Permanent Address fields
        function toggleAddressFields() {
            var checkBox = document.getElementById("same-address");
            var inputRows = document.querySelectorAll(".input-row-permanent");
        
            // If the checkbox is checked, copy the current address to the permanent address fields
            if (checkBox.checked) {
                // Get current address values
                const province = document.getElementById("province").value;
                document.getElementById("province-permanent").value = province;
                updateCitiesPermanent();

                const city = document.getElementById("city").value;
                document.getElementById("city-permanent").value = city;
                updateBarangaysPermanent();

                const currentAddress = {
                    houseNumber: document.getElementById("house-number").value,
                    streetName: document.getElementById("street-name").value,
                    barangay: document.getElementById("barangay").value,
                    city: city,
                    province: province,
                    country: document.getElementById("country").value,
                    zipCode: document.getElementById("zip-code").value
                };
        
                // Populate permanent address fields with current address values
                document.getElementById("house-number-permanent").value = currentAddress.houseNumber;
                document.getElementById("street-name-permanent").value = currentAddress.streetName;
                document.getElementById("barangay-permanent").value = currentAddress.barangay;
                document.getElementById("city-permanent").value = currentAddress.city;
                document.getElementById("province-permanent").value = currentAddress.province;
                document.getElementById("country-permanent").value = currentAddress.country;
                document.getElementById("zip-code-permanent").value = currentAddress.zipCode;
        
                // Hide the permanent address input rows
                inputRows.forEach(function(row) {
                    row.style.display = "none";
                });
            } else {
                // Show the permanent address input rows
                inputRows.forEach(function(row) {
                    row.style.display = "flex";
                });
            }
        }