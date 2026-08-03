const fs = require('fs');
const path = require('path');

function copyDir(src, dest) {
    if (!fs.existsSync(dest)) fs.mkdirSync(dest, { recursive: true });
    const entries = fs.readdirSync(src, { withFileTypes: true });
    for (let entry of entries) {
        const srcPath = path.join(src, entry.name);
        const destPath = path.join(dest, entry.name);
        if (entry.isDirectory()) {
            copyDir(srcPath, destPath);
        } else {
            fs.copyFileSync(srcPath, destPath);
        }
    }
}

// Copy resources/css to public/css
if (fs.existsSync('resources/css')) {
    copyDir('resources/css', 'public/css');
}

// Copy resources/js to public/js
if (fs.existsSync('resources/js')) {
    copyDir('resources/js', 'public/js');
}

// Ensure public/vendor exists
if (!fs.existsSync('public/vendor')) fs.mkdirSync('public/vendor', { recursive: true });

// List of node_modules paths to copy
const vendorDirs = [
    'bootstrap/dist/css',
    'bootstrap/dist/js',
    'magnific-popup/dist',
    'slick-slider/slick',
    'aos/dist'
];

vendorDirs.forEach(dir => {
    const src = path.join('node_modules', dir);
    if (fs.existsSync(src)) {
        const dest = path.join('public/vendor', dir);
        copyDir(src, dest);
        console.log(`Copied ${dir}`);
    } else {
        console.log(`Missing ${dir}`);
    }
});

console.log('Asset copying complete.');
