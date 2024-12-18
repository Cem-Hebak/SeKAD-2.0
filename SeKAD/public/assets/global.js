document.addEventListener('DOMContentLoaded', () => {
    // Apply saved font size when the page loads
    const savedFontSize = localStorage.getItem('fontSize') || 'medium';
    applyFontSize(savedFontSize);

    // Apply saved display mode (light or dark)
    const savedMode = localStorage.getItem('theme') || 'light';
    applyDisplayMode(savedMode);

    // Set the font size dropdown to the saved value
    const fontSizeSelector = document.getElementById('fontSizeSelector');
    if (fontSizeSelector) {
        fontSizeSelector.value = savedFontSize;
        fontSizeSelector.addEventListener('change', (event) => {
            const fontSize = event.target.value;
            applyFontSize(fontSize);
            localStorage.setItem('fontSize', fontSize);
        });
    }

    // Set the display mode dropdown to the saved value
    const displayModeSelector = document.getElementById('displayModeSelector');
    if (displayModeSelector) {
        displayModeSelector.value = savedMode;
        displayModeSelector.addEventListener('change', (event) => {
            const mode = event.target.value;
            applyDisplayMode(mode);
            localStorage.setItem('theme', mode);
        });
    }
});

// Function to apply font size to the body
function applyFontSize(fontSize) {
    document.body.classList.remove('font-small', 'font-medium', 'font-large');
    switch (fontSize) {
        case 'small':
            document.body.classList.add('font-small');
            break;
        case 'medium':
            document.body.classList.add('font-medium');
            break;
        case 'large':
            document.body.classList.add('font-large');
            break;
    }
}

// Function to toggle between light and dark modes
function applyDisplayMode(mode) {
    const lightMode = document.getElementById('light-mode');
    const darkMode = document.getElementById('dark-mode');

    if (mode === 'dark') {
        lightMode.disabled = true;
        darkMode.disabled = false;
    } else {
        lightMode.disabled = false;
        darkMode.disabled = true;
    }

    // Add corresponding class to the body
    document.body.classList.remove('light', 'dark');
    document.body.classList.add(mode);
}
