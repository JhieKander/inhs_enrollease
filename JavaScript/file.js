// Add these functions at the start of your file.js
function showVerificationError(errors) {
    const modal = document.getElementById('verificationErrorModal');
    const errorList = document.getElementById('verificationErrorList');
    
    // Clear previous errors
    errorList.innerHTML = '';
    
    // Add each error to the list
    errors.forEach(error => {
        const li = document.createElement('li');
        li.textContent = error;
        errorList.appendChild(li);
    });
    
    modal.style.display = 'block';
}

function closeVerificationModal() {
    const modal = document.getElementById('verificationErrorModal');
    modal.style.display = 'none';
}

// Add this function to convert PDF to image
async function convertPDFtoImage(pdfBlob) {
    const pdf = await pdfjsLib.getDocument({data: pdfBlob}).promise;
    const canvas = document.createElement('canvas');
    const page = await pdf.getPage(1);
    const viewport = page.getViewport({scale: 1.5}); // Adjust scale as needed
    
    canvas.width = viewport.width;
    canvas.height = viewport.height;
    
    await page.render({
        canvasContext: canvas.getContext('2d'),
        viewport: viewport
    }).promise;
    
    return canvas.toDataURL('image/png');
}

document.addEventListener('DOMContentLoaded', function () {
    const warningModal = document.getElementById('warningModal');
    const previewModal = document.getElementById('previewModal');
    const previewImage = document.getElementById('previewImage');
    const previewPdf = document.getElementById('previewPdf');
    const submitButton = document.querySelector(".button-container button");

    // Add specific class to preview modal for styling
    previewModal.classList.add('preview-modal');

    // File input handlers
    const fileInputs = [
        { input: document.getElementById('sf9-input'), name: 'SF9' },
        { input: document.getElementById('file-input-1'), name: 'Birth Certificate' },
        { input: document.getElementById('file-input-2'), name: 'Recomputed Grade Certificate' }
    ];

    // Add change event listeners to all file inputs
    fileInputs.forEach(({input}) => {
        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                previewFile(file);
                
                // Update file name display
                const uploadBox = this.closest('.upload-box');
                let fileNameDisplay = uploadBox.querySelector('.selected-file');
                
                // Create file name display if it doesn't exist
                if (!fileNameDisplay) {
                    fileNameDisplay = document.createElement('div');
                    fileNameDisplay.className = 'selected-file';
                    uploadBox.appendChild(fileNameDisplay);
                }
                
                // Update and show the file name
                fileNameDisplay.textContent = `Selected: ${file.name}`;
                fileNameDisplay.style.display = 'block';
            }
        });
    });

    // Close modal buttons
    document.querySelectorAll('.close-button, .preview-close-btn').forEach(button => {
        button.addEventListener('click', function() {
            warningModal.style.display = 'none';
            previewModal.style.display = 'none';
        });
    });

    // Preview file function
    function previewFile(file) {
        const fileType = file.type;
        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        // Update modal title with file name
        const modalTitle = previewModal.querySelector('h2');
        modalTitle.textContent = `File Preview: ${file.name}`;
        
        // Clear previous preview content
        const previewContent = document.getElementById('previewContent');
        previewContent.innerHTML = '';
        
        if (validImageTypes.includes(fileType)) {
            // Handle image files
            const img = document.createElement('img');
            img.id = 'previewImage';
            img.style.maxWidth = '100%';
            img.style.maxHeight = '100%';
            previewContent.appendChild(img);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else if (fileType === 'application/pdf') {
            const pagesContainer = document.createElement('div');
            pagesContainer.style.cssText = 'width: 100%; display: flex; flex-direction: column; align-items: center; gap: 20px;';
            previewContent.appendChild(pagesContainer);

            const loadingDiv = document.createElement('div');
            loadingDiv.textContent = 'Loading PDF pages...';
            loadingDiv.style.cssText = 'text-align: center; padding: 20px;';
            pagesContainer.appendChild(loadingDiv);
            
            const fileReader = new FileReader();
            fileReader.onload = async function() {
                const typedarray = new Uint8Array(this.result);

                try {
                    const pdf = await pdfjsLib.getDocument(typedarray).promise;
                    loadingDiv.remove();
                    
                    const numPages = pdf.numPages;
                    
                    for (let pageNum = 1; pageNum <= numPages; pageNum++) {
                        const pageContainer = document.createElement('div');
                        pageContainer.style.cssText = `
                            width: 100%;
                            max-width: 800px;
                            margin: 0 auto 20px;
                            background-color: white;
                            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                        `;
                        
                        const pageLabel = document.createElement('div');
                        pageLabel.textContent = `Page ${pageNum} of ${numPages}`;
                        pageLabel.style.cssText = 'text-align: center; padding: 10px; background-color: #f5f5f5; border-bottom: 1px solid #ddd;';
                        pageContainer.appendChild(pageLabel);

                        try {
                            const page = await pdf.getPage(pageNum);
                            
                            // Calculate scale based on viewport width
                            const viewportWidth = window.innerWidth;
                            let desiredWidth;
                            
                            if (viewportWidth >= 1200) {
                                desiredWidth = 600; // Large screens
                            } else if (viewportWidth >= 768) {
                                desiredWidth = 500; // Medium screens
                            } else if (viewportWidth >= 480) {
                                desiredWidth = 400; // Small screens
                            } else {
                                desiredWidth = 300; // Extra small screens
                            }
                            
                            const viewport = page.getViewport({ scale: 1.0 });
                            const scale = desiredWidth / viewport.width;
                            const scaledViewport = page.getViewport({ scale });

                            const canvasContainer = document.createElement('div');
                            canvasContainer.style.cssText = `
                                width: 100%;
                                display: flex;
                                justify-content: center;
                                padding: 10px;
                                box-sizing: border-box;
                            `;

                            const canvas = document.createElement('canvas');
                            const context = canvas.getContext('2d');
                            canvas.height = scaledViewport.height;
                            canvas.width = scaledViewport.width;
                            canvas.style.cssText = `
                                width: 100%;
                                max-width: ${desiredWidth}px;
                                height: auto;
                                display: block;
                                margin: 0 auto;
                            `;
                            
                            canvasContainer.appendChild(canvas);
                            pageContainer.appendChild(canvasContainer);
                            pagesContainer.appendChild(pageContainer);

                            await page.render({
                                canvasContext: context,
                                viewport: scaledViewport
                            }).promise;

                            // Add resize listener for each page
                            const resizeObserver = new ResizeObserver(() => {
                                const newViewportWidth = window.innerWidth;
                                let newDesiredWidth;
                                
                                if (newViewportWidth >= 1200) {
                                    newDesiredWidth = 600;
                                } else if (newViewportWidth >= 768) {
                                    newDesiredWidth = 500;
                                } else if (newViewportWidth >= 480) {
                                    newDesiredWidth = 400;
                                } else {
                                    newDesiredWidth = 300;
                                }
                                
                                const newScale = newDesiredWidth / viewport.width;
                                const newScaledViewport = page.getViewport({ scale: newScale });
                                
                                canvas.height = newScaledViewport.height;
                                canvas.width = newScaledViewport.width;
                                canvas.style.maxWidth = `${newDesiredWidth}px`;
                                
                                page.render({
                                    canvasContext: context,
                                    viewport: newScaledViewport
                                });
                            });

                            resizeObserver.observe(pageContainer);

                        } catch (error) {
                            console.error(`Error rendering page ${pageNum}:`, error);
                            pageContainer.innerHTML += `<div style="color: red; padding: 10px;">Error loading page ${pageNum}</div>`;
                        }
                    }
                } catch (error) {
                    console.error('Error loading PDF:', error);
                    pagesContainer.innerHTML = '<div style="color: red; padding: 20px;">Error loading PDF preview</div>';
                }
            };
            fileReader.readAsArrayBuffer(file);
        } else {
            alert('Unsupported file type. Please upload an image or PDF file.');
            return;
        }
        
        previewModal.style.display = 'block';
    }

    // Form submission validation
    const form = document.getElementById('upload-form');
    form.addEventListener('submit', function(event) {
        const sf9 = document.getElementById("sf9-input").files.length > 0;
        const birthCert = document.getElementById("file-input-1").files.length > 0;

        if (!sf9 || !birthCert) {
            event.preventDefault();
            showWarningModal();
        }
    });

    function showWarningModal() {
        warningModal.style.display = 'block';
    }

    // Add modal OK button functionality
    const modalOkButton = document.getElementById('modalOkButton');
    if (modalOkButton) {
        modalOkButton.addEventListener('click', function() {
            warningModal.style.display = 'none';
        });
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === warningModal) {
            warningModal.style.display = 'none';
        }
        if (event.target === previewModal) {
            previewModal.style.display = 'none';
        }
    });

    // Close modals with escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            warningModal.style.display = 'none';
            previewModal.style.display = 'none';
        }
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('verificationErrorModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
});