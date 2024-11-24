function toggleDisabilityOptions() {
            var yesRadio = document.getElementById('disability-yes');
            var disabilityOptions = document.getElementById('disability-options');
            if (yesRadio.checked) {
                disabilityOptions.classList.remove('hidden');
            } else {
                disabilityOptions.classList.add('hidden');
            }
        }

        function toggleIPOptions() {
            var yesRadio = document.getElementById('ip-yes');
            var ipOptions = document.getElementById('ip-options');
            if (yesRadio.checked) {
                ipOptions.classList.remove('hidden');
            } else {
                ipOptions.classList.add('hidden');
            }
        }

        

        function toggleAddressFields() {
            var checkBox = document.getElementById("same-address");
            var inputRows = document.querySelectorAll(".input-row, .input-row-full");
            inputRows.forEach(function(row) {
                row.style.display = checkBox.checked ? "none" : "flex";
            });
        }

        function toggleBeneficiaryOptions(){
            const yesRadio = document.getElementById('beneficiary-yes');
            const optionsDiv = document.getElementById('beneficiary-options');

            if (yesRadio.checked) {
            optionsDiv.classList.remove('hidden');
            } else {
                optionsDiv.classList.add('hidden');
            }
        } 

         
         
 // JavaScript to show confirmation after the modal is submitted
  function submitApplication() {
            // Here you can add your form submission logic
            document.getElementById('confirmationMessage').style.display = 'block';
            document.getElementById('application_form').style.display = 'none';
            closeModal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Your existing code goes here
            document.getElementById("closeModalButton").addEventListener("click", function() {
                // Make the form visible
                document.getElementById("application_form").style.display = "block";
            });

            const closeModalButton = document.getElementById("closeModalButton");
            if (closeModalButton) {
                closeModalButton.addEventListener("click", function() {
                    // Make the form visible
                    document.getElementById("application_form").style.display = "block";
                });
            }
        });

function closeModal() {
    const pdfModal = bootstrap.Modal.getInstance(document.getElementById('pdfModal'));
    if (pdfModal) {
        pdfModal.hide();
    }
}       