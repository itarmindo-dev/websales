const fs = require('fs');
const path = 'C:\\Users\\aplap\\.gemini\\antigravity-ide\\brain\\b2984082-f28e-472e-ac4d-77d86579f60f\\.system_generated\\logs\\transcript_full.jsonl';
const lines = fs.readFileSync(path, 'utf-8').split('\n');

let lastUserInput = "";
for (const line of lines) {
    if (!line) continue;
    try {
        const obj = JSON.parse(line);
        if (obj.type === 'USER_INPUT') {
            lastUserInput = obj.content;
        }
    } catch (e) {}
}

fs.writeFileSync('original_index.txt', lastUserInput);
console.log('Saved to original_index.txt');
