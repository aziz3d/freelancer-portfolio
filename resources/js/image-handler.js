
class ImageHandler {
    constructor() {
        this.maxFileSize = 5 * 1024 * 1024; // 5MB
        this.allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        this.init();
    }

    init() {
        this.setupImagePreviews();
        this.setupDragAndDrop();
        this.setupImageValidation();
    }

    setupImagePreviews() {
        document.querySelectorAll('input[type="file"][accept*="image"]').forEach(input => {
            input.addEventListener('change', (e) => {
                this.handleImagePreview(e.target);
            });
        });
    }

    handleImagePreview(input) {
        const files = Array.from(input.files);
        const previewContainer = input.closest('.form-group')?.querySelector('.image-preview') ||
                                input.parentElement?.querySelector('.image-preview');

        if (!previewContainer) return;

        
        previewContainer.innerHTML = '';

        files.forEach((file, index) => {
            if (this.validateFile(file)) {
                this.createImagePreview(file, previewContainer, input.name, index);
            }
        });
    }

    createImagePreview(file, container, inputName, index) {
        const reader = new FileReader();
        
        reader.onload = (e) => {
            const previewDiv = document.createElement('div');
            previewDiv.className = 'relative inline-block m-2 border rounded-lg overflow-hidden';
            
            previewDiv.innerHTML = `
                <img src="${e.target.result}" 
                     alt="Preview" 
                     class="w-32 h-32 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-200 flex items-center justify-center">
                    <button type="button" 
                            class="remove-image bg-red-500 text-white rounded-full p-1 opacity-0 hover:opacity-100 transition-opacity"
                            data-index="${index}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-75 text-white text-xs p-1 truncate">
                    ${file.name}
                </div>
            `;

           
            previewDiv.querySelector('.remove-image').addEventListener('click', () => {
                this.removeImagePreview(previewDiv, inputName, index);
            });

            container.appendChild(previewDiv);
        };

        reader.readAsDataURL(file);
    }

    removeImagePreview(previewDiv, inputName, index) {
        previewDiv.remove();
        
        
        const input = document.querySelector(`input[name="${inputName}"]`);
        if (input && input.files.length > 1) {
            console.warn('Removing individual files from multiple selection is not fully supported');
        }
    }

    setupDragAndDrop() {
        document.querySelectorAll('.image-drop-zone').forEach(dropZone => {
            const input = dropZone.querySelector('input[type="file"]');
            
            if (!input) return;

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, this.preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.add('drag-over');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.remove('drag-over');
                }, false);
            });

            dropZone.addEventListener('drop', (e) => {
                const files = e.dataTransfer.files;
                input.files = files;
                this.handleImagePreview(input);
            }, false);
        });
    }

    preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }


    setupImageValidation() {
        document.querySelectorAll('input[type="file"][accept*="image"]').forEach(input => {
            input.addEventListener('change', (e) => {
                this.validateImages(e.target);
            });
        });
    }


    validateImages(input) {
        const files = Array.from(input.files);
        const errors = [];

        files.forEach((file, index) => {
            const fileErrors = this.validateFile(file);
            if (fileErrors.length > 0) {
                errors.push(`File ${index + 1} (${file.name}): ${fileErrors.join(', ')}`);
            }
        });

        this.clearValidationErrors(input);

        if (errors.length > 0) {
            this.showValidationErrors(input, errors);
            input.value = '';
        }
    }

    validateFile(file) {
        const errors = [];

        if (!this.allowedTypes.includes(file.type)) {
            errors.push('Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.');
        }

        if (file.size > this.maxFileSize) {
            errors.push(`File size too large. Maximum size is ${this.maxFileSize / (1024 * 1024)}MB.`);
        }

        return errors;
    }

    showValidationErrors(input, errors) {
        const errorContainer = document.createElement('div');
        errorContainer.className = 'image-validation-errors mt-2 p-3 bg-red-100 border border-red-400 text-red-700 rounded';
        
        const errorList = document.createElement('ul');
        errorList.className = 'list-disc list-inside text-sm';
        
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });

        errorContainer.appendChild(errorList);
        input.parentElement.appendChild(errorContainer);
    }

    clearValidationErrors(input) {
        const existingErrors = input.parentElement.querySelectorAll('.image-validation-errors');
        existingErrors.forEach(error => error.remove());
    }

    async compressImage(file, maxWidth = 1920, maxHeight = 1080, quality = 0.8) {
        return new Promise((resolve) => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();

            img.onload = () => {
                let { width, height } = img;
                
                if (width > maxWidth || height > maxHeight) {
                    const ratio = Math.min(maxWidth / width, maxHeight / height);
                    width *= ratio;
                    height *= ratio;
                }

                canvas.width = width;
                canvas.height = height;

                ctx.drawImage(img, 0, 0, width, height);
                
                canvas.toBlob(resolve, file.type, quality);
            };

            img.src = URL.createObjectURL(file);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ImageHandler();
});

export default ImageHandler;