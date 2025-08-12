
function detectWebPSupport() {
    const webP = new Image();
    webP.onload = webP.onerror = function () {
        if (webP.height === 2) {
            document.documentElement.classList.add('webp');
        } else {
            document.documentElement.classList.add('no-webp');
        }
    };
    webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
}

detectWebPSupport();

export default detectWebPSupport;