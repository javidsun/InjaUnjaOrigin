export default {
    /**
     * Open device gallery to select images
     * @param {number} maxImages - Maximum number of images allowed
     * @param {number} maxSize - Maximum file size in MB
     * @returns {Promise<Array<string>>} - Array of base64 encoded images
     */
    async openGallery(maxImages = 10, maxSize = 2) {
        try {
            if (navigator.permissions) {
                const permissionStatus = await navigator.permissions.query({ name: 'geolocation' });
                if (permissionStatus.state === 'denied') {
                    throw new Error('Please enable gallery access in your browser settings');
                }
            }

            return new Promise((resolve) => {
                const input = document.createElement("input");
                input.type = "file";
                input.accept = "image/*";
                input.multiple = true;

                input.onchange = (event) => {
                    const files = Array.from(event.target.files);
                    if (files.length > 0) {
                        const validFiles = files.slice(0, maxImages);
                        const promises = [];

                        validFiles.forEach(file => {
                            if (file.size > maxSize * 1024 * 1024) {
                                console.warn(`Image ${file.name} is too large (max ${maxSize}MB)`);
                                return;
                            }

                            promises.push(new Promise((resolveFile) => {
                                const reader = new FileReader();
                                reader.onload = (e) => resolveFile(e.target.result);
                                reader.onerror = () => resolveFile(null);
                                reader.readAsDataURL(file);
                            }));
                        });

                        Promise.all(promises).then(results => {
                            resolve(results.filter(Boolean));
                        });
                    } else {
                        resolve([]);
                    }
                };

                input.click();
            });
        } catch (error) {
            console.error("Error in openGallery:", error);
            throw error;
        }
    },

    /**
     * Open device camera to take a photo
     * @param {number} maxSize - Maximum file size in MB
     * @returns {Promise<string|null>} - Base64 encoded image or null
     */
    async openCamera(maxSize = 2) {
        try {
            if (!navigator.mediaDevices?.getUserMedia) {
                throw new Error("This browser doesn't support camera access.");
            }

            const stream = await navigator.mediaDevices.getUserMedia({ video: true });

            return new Promise((resolve) => {
                const video = document.createElement('video');
                video.srcObject = stream;
                video.play();

                const capturePhoto = () => {
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    const imageData = canvas.toDataURL('image/jpeg', 0.8);
                    const size = imageData.length * 0.75;

                    if (size > maxSize * 1024 * 1024) {
                        console.warn(`Captured image is too large (max ${maxSize}MB)`);
                        resolve(null);
                    } else {
                        resolve(imageData);
                    }

                    stream.getTracks().forEach(track => track.stop());
                    document.body.removeChild(video);
                    document.body.removeChild(button);
                };

                const button = document.createElement('button');
                button.textContent = 'Capture';
                button.style.position = 'fixed';
                button.style.bottom = '20px';
                button.style.left = '50%';
                button.style.transform = 'translateX(-50%)';
                button.style.zIndex = '10000';
                button.onclick = capturePhoto;

                document.body.appendChild(video);
                document.body.appendChild(button);
            });
        } catch (error) {
            console.error("Error in openCamera:", error);
            throw error;
        }
    },
  /**
     * Read file as Data URL
     * @param {File} file - File to read
     * @returns {Promise<string>} - Data URL
     */
    readFileAsDataURL(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => resolve(e.target.result);
            reader.onerror = (e) => reject(e);
            reader.readAsDataURL(file);
        });
    },

    /**
     * Validate images before upload
     * @param {Array<string>} images - Array of base64 encoded images
     * @param {number} maxCount - Maximum number of images allowed
     * @param {number} maxSize - Maximum file size in MB
     * @returns {boolean} - True if validation passes
     */
    validateImages(images, maxCount = 10, maxSize = 2) {
        if (!Array.isArray(images)) {
            return false;
        }

        if (images.length > maxCount) {
            throw new Error(`You can upload maximum ${maxCount} images`);
        }

        images.forEach(img => {
            const size = img.length * 0.75;
            if (size > maxSize * 1024 * 1024) {
                throw new Error(`One or more images exceed the maximum size of ${maxSize}MB`);
            }
        });

        return true;
    }
};
