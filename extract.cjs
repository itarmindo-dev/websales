const fs = require('fs');
const path = 'C:\\Users\\aplap\\.gemini\\antigravity-ide\\brain\\b2984082-f28e-472e-ac4d-77d86579f60f\\.system_generated\\logs\\transcript_full.jsonl';
const lines = fs.readFileSync(path, 'utf-8').split('\n');

let found = false;
for (const line of lines) {
    if (!line) continue;
    try {
        const obj = JSON.parse(line);
        if (obj.content && obj.content.includes('File Path: `file:///c:/xampp/htdocs/LaravelProject/Sales/WebSales/resources/views/index.blade.php`')) {
            fs.appendFileSync('old_index_dump.txt', obj.content + '\n\n-----------------\n\n');
            found = true;
        }
    } catch (e) {}
}

if (!found) console.log('Not found');
else console.log('Dumped to old_index_dump.txt');
