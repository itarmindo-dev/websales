const fs = require('fs');
const path = 'C:\\Users\\aplap\\.gemini\\antigravity-ide\\brain\\b2984082-f28e-472e-ac4d-77d86579f60f\\.system_generated\\logs\\transcript_full.jsonl';
const lines = fs.readFileSync(path, 'utf-8').split('\n');

let count = 0;
for (const line of lines) {
    if (!line) continue;
    try {
        const obj = JSON.parse(line);
        if (obj.type === 'USER_INPUT' && obj.content.includes('@extends')) {
            fs.writeFileSync('original_index.txt', obj.content);
            count++;
        }
    } catch (e) {}
}

console.log('Found ' + count + ' matching user inputs');
