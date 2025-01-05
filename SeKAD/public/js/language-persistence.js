document.addEventListener('DOMContentLoaded', function () {
    const languageSelector = document.querySelector('#google_translate_element select');
    if (languageSelector) {
        languageSelector.addEventListener('change', function () {
            const selectedLanguage = this.value;
            localStorage.setItem('selectedLanguage', selectedLanguage);
        });
    }

    // Apply saved language on page load
    const savedLanguage = localStorage.getItem('selectedLanguage');
    if (savedLanguage) {
        const iframe = document.querySelector('iframe.goog-te-menu-frame');
        if (iframe) {
            const translateDoc = iframe.contentDocument || iframe.contentWindow.document;
            const option = translateDoc.querySelector(`[value="${savedLanguage}"]`);
            if (option) {
                option.click();
            }
        }
    }
});
