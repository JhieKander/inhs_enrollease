function toggleIPOptions() {
    const ipYes = document.getElementById('ip-yes').checked; 
    const ipOptionsDiv = document.getElementById('ip-options');

    // Show or hide the ipOptionsDiv based on the checked state of ipYes
    if (ipYes) {
        ipOptionsDiv.classList.remove('hidden');
        toggleIOtherTextInput(); // Call to check if the text input should be shown
    } else {
        ipOptionsDiv.classList.add('hidden');
        document.getElementById('ip-other-options').classList.add('hidden'); // Ensure other options are hidden
    }
}

function toggleIOtherTextInput() {
    const selectedValue = document.getElementById('ip-specify').value;
    const ipOtherOptionsDiv = document.getElementById('ip-other-options');

    // Show "ip-other-options" only if "Others" is selected
    if (selectedValue === 'Others') {
        ipOtherOptionsDiv.classList.remove('hidden');
    } else {
        ipOtherOptionsDiv.classList.add('hidden');
    }
}

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
        
        function openModal() {
            const modal = document.getElementById("detailsModal");
            const modalBody = document.getElementById("modal-body");
        
            // Gather data from the form
            const learnerRefNum = document.getElementById("learner-reference-number").value;
            const lastName = document.getElementById("last-name").value;
            const firstName = document.getElementById("first-name").value;
            const middleName = document.getElementById("middle-name").value;
            const extensionName = document.getElementById("extension-name").value;
            const birthdate = document.getElementById("birthdate").value;
            const gender = document.getElementById("gender").value;
            const motherTongue = document.getElementById("mother-tongue").value;
            const placeOfBirth = document.getElementById("place-of-birth").value;
            const psaBirthCertificate = document.getElementById("psa-birth-certificate").value;
            
            // Get current address
            const currentAddress = {
                houseNumber: document.getElementById("house-number").value,
                streetName: document.getElementById("street-name").value,
                barangay: document.getElementById("barangay").value,
                city: document.getElementById("city").value,
                province: document.getElementById("province").value,
                country: document.getElementById("country").value,
                zipCode: document.getElementById("zip-code").value
            };
        
            // Get permanent address
            const permanentAddress = {
                houseNumber: document.getElementById("house-number-permanent").value,
                streetName: document.getElementById("street-name-permanent").value,
                barangay: document.getElementById("barangay-permanent").value,
                city: document.getElementById("city-permanent").value,
                province: document.getElementById("province-permanent").value,
                country: document.getElementById("country-permanent").value,
                zipCode: document.getElementById("zip-code-permanent").value
            };
        
            // Gather parent information
            const fatherInfo = {
                lastName: document.getElementById("father-last-name").value,
                firstName: document.getElementById("father-first-name").value,
                middleName: document.getElementById("father-middle-name").value,
                extensionName: document.getElementById("father-extension-name").value,
                contactNumber: document.getElementById("father-contact-number").value
            };
            const motherInfo = {
                lastName: document.getElementById("mother-last-name").value,
                firstName: document.getElementById("mother-first-name").value,
                middleName: document.getElementById("mother-middle-name").value,
                extensionName: document.getElementById("mother-extension-name").value,
                contactNumber: document.getElementById("mother-contact-number").value
            };
            const guardianInfo = {
                lastName: document.getElementById("guardian-last-name").value,
                firstName: document.getElementById("guardian-first-name").value,
                middleName: document.getElementById("guardian-middle-name").value,
                extensionName: document.getElementById("guardian-extension-name").value,
                contactNumber: document.getElementById("guardian-contact-number").value
            };
        
            // Gather previous education information
            const lastGrade = document.getElementById("last-grade").value;
            const lastYear = document.getElementById("last-year").value;
            const lastSchool = document.getElementById("last-school").value;
            const schoolId = document.getElementById("school-id").value;
            const gradeLevel = document.getElementById("grade-level").value;

            // Gather disability and IP community information
            const isLearnerWithDisability = document.getElementById("disability-yes").checked ? "Yes" : "No";
            const learnerDisabilityDetails = isLearnerWithDisability === "Yes" ? document.getElementById("disability-specify").value : "N/A"; // Get details if Yes
            const belongsToIPCommunity = document.getElementById("ip-yes").checked ? "Yes" : "No";
            const ipCommunityDetails = belongsToIPCommunity === "Yes" ? document.getElementById("ip-specify").value : "N/A"; // Get details if Yes
            const beneficiary4Ps = document.getElementById("beneficiary-yes").checked ? "Yes" : "No";
            const haveBenefits = beneficiary4Ps === "Yes" ? document.getElementById("beneficiary-specify").value : "N/A"; // Get details if Yes
        
            // Populate modal body with the gathered information
            modalBody.innerHTML = `
                <h2>Personal Information:</h2>
                <p><strong>Learner Reference Number:</strong> ${learnerRefNum}</p>
                <p><strong>Last Name:</strong> ${lastName}</p>
                <p><strong>First Name:</strong> ${firstName}</p>
                <p><strong>Middle Name:</strong> ${middleName}</p>
                <p><strong>Extension Name:</strong> ${extensionName}</p>
                <p><strong>Birthdate:</strong> ${birthdate}</p>
                <p><strong>Gender:</strong> ${gender}</p>
                <p><strong>Mother Tongue:</strong> ${motherTongue}</p>
                <p><strong>Place of Birth:</strong> ${placeOfBirth}</p>
                <p><strong>PSA Birth Certificate No.:</strong> ${psaBirthCertificate}</p>

                <hr class="thin">

                    <h3>Additional Information:</h3>
                    <p><strong>Is the child a learner with disability?:</strong> ${isLearnerWithDisability} ${learnerDisabilityDetails !== "N/A" ? ` - ${learnerDisabilityDetails}` : ""}</p>
                    <p><strong>Belonging to any Indigenous People (IP) Community Indigenous Cultural Community:</strong> ${belongsToIPCommunity} ${ipCommunityDetails !== "N/A" ? ` - ${ipCommunityDetails}` : ""}</p>
                    <p><strong>Is your family a beneficiary of 4Ps?:</strong> ${beneficiary4Ps} ${haveBenefits !== "N/A" ? ` - ${haveBenefits}` : ""}</p>

                <hr class="thin">

                <h2>Current and Permanent Address:</h2>
                <div class="flex-container">
                    <div class="flex-item">
                        <h3>Current Address:</h3>
                        <p><strong>House Number:</strong> ${currentAddress.houseNumber}</p>
                        <p><strong>Street Name:</strong> ${currentAddress.streetName}</p>
                        <p><strong>Barangay:</strong> ${currentAddress.barangay}</p>
                        <p><strong>City:</strong> ${currentAddress.city}</p>
                        <p><strong>Province:</strong> ${currentAddress.province}</p>
                        <p><strong>Country:</strong> ${currentAddress.country}</p>
                        <p><strong>Zip Code:</strong> ${currentAddress.zipCode}</p>
                    </div>
                    <div class="flex-item">
                        <h3>Permanent Address:</h3>
                        <p><strong>House Number:</strong> ${permanentAddress.houseNumber}</p>
                        <p><strong>Street Name:</strong> ${permanentAddress.streetName}</p>
                        <p><strong>Barangay:</strong> ${permanentAddress.barangay}</p>
                        <p><strong>City:</strong> ${permanentAddress.city}</p>
                        <p><strong>Province:</strong> ${permanentAddress.province}</p>
                        <p><strong>Country:</strong> ${permanentAddress.country}</p>
                        <p><strong>Zip Code:</strong> ${permanentAddress.zipCode}</p>
                    </div>
                </div>

                <hr class="thin">
        
                <h2>Parent's Information:</h2>
                <div class="flex-container">
                    <div class="flex-item">
                        <h3>Father's Information:</h3>
                        <p><strong>Last Name:</strong> ${fatherInfo.lastName}</p>
                        <p><strong>First Name:</strong> ${fatherInfo.firstName}</p>
                        <p><strong>Middle Name:</strong> ${fatherInfo.middleName}</p>
                        <p><strong>Extension Name:</strong> ${fatherInfo.extensionName}</p>
                        <p><strong>Contact Number:</strong> ${fatherInfo.contactNumber}</p>
                    </div>
                    <div class="flex-item">
                        <h3>Mother's Information:</h3>
                        <p><strong>Last Name:</strong> ${motherInfo.lastName}</p>
                        <p><strong>First Name:</strong> ${motherInfo.firstName}</p>
                        <p><strong>Middle Name:</strong> ${motherInfo.middleName}</p>
                        <p><strong>Extension Name:</strong> ${motherInfo.extensionName}</p>
                        <p><strong>Contact Number:</strong> ${motherInfo.contactNumber}</p>
                    </div>

                    <hr class="thin">

                    <div class="flex-item">
                        <h3>Guardian's Information:</h3>
                        <p><strong>Last Name:</strong> ${guardianInfo.lastName}</p>
                        <p><strong>First Name:</strong> ${guardianInfo.firstName}</p>
                        <p><strong>Middle Name:</strong> ${guardianInfo.middleName}</p>
                        <p><strong>Extension Name:</strong> ${guardianInfo.extensionName}</p>
                        <p><strong>Contact Number:</strong> ${guardianInfo.contactNumber}</p>
                    </div>
                </div>

                <hr class="thin">
        
                <h2>Previous Education:</h2>
                <p><strong>Last Grade Level Completed:</strong> ${lastGrade}</p>
                <p><strong>Last School Year Attended:</strong> ${lastYear}</p>
                <p><strong>Last School Attended:</strong> ${lastSchool}</p>
                <p><strong>School ID:</strong> ${schoolId}</p>
                <p><strong>Grade Level to Enroll:</strong> ${gradeLevel}</p>
            `;
        
            // Show the modal
            modal.style.display = "block";
        }
    
        // Function to close the modal
        function closeModal() {
            const modal = document.getElementById("detailsModal");
            modal.style.display = "none";
        }
    
        // Function to submit the application (customize as needed)
        function submitApplication() {
            // Here you can add your form submission logic
            alert("Application submitted!");
            closeModal();
        }
    
        // Add event listener to the button
        document.getElementById('save-continue-button').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default button behavior
            openModal(); // Open the modal
        });