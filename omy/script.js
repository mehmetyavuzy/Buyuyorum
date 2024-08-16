const colors = ["#e6194b", "#3cb44b", "#ffe119", "#4363d8", "#f58231", "#911eb4", "#42d4f4", "#f032e6", "#bfef45", "#fabebe", "#469990", "#e6beff", "#9a6324", "#fffac8", "#800000", "#aaffc3", "#808000", "#ffd8b1", "#000075", "#a9a9a9"];

const maleNames = ["Agah", "Emirhan", "Melih", "Berkay", "Gökşu", "Selim", "Efe", "Yasır", "Yiğithan", "Çınar", "Emir Osman"];
const femaleNames = ["Zehra", "Öykü", "Begüm", "Berrin", "Sude", "Asya", "Liva", "Zeynep", "Betül"];

function drawWheel(canvasId, names) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = Math.min(centerX, centerY);

    const segmentAngle = 2 * Math.PI / names.length;

    for (let i = 0; i < names.length; i++) {
        const startAngle = i * segmentAngle;
        const endAngle = startAngle + segmentAngle;
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, startAngle, endAngle);
        ctx.closePath();
        ctx.fillStyle = colors[i % colors.length];
        ctx.fill();
        ctx.stroke();

        ctx.save();
        ctx.translate(centerX, centerY);
        ctx.rotate(startAngle + segmentAngle / 2);
        ctx.textAlign = "right";
        ctx.fillStyle = "#000";
        ctx.font = "bold 16px Arial";
        ctx.fillText(names[i], radius - 10, 0);
        ctx.restore();
    }
}

let spinning = false;
let rotation = 0;

function spinWheel(canvasId, names, resultId) {
    if (spinning) return;
    spinning = true;
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = Math.min(centerX, centerY);

    const spinAngleStart = Math.random() * 10 + 10;
    const spinTimeTotal = Math.random() * 3 + 4 * 1000;

    let spinTime = 0;

    function rotateWheel() {
        spinTime += 30;
        if (spinTime >= spinTimeTotal) {
            spinning = false;
            const angle = rotation % (2 * Math.PI);
            const segmentAngle = 2 * Math.PI / names.length;
            const index = Math.floor((angle + Math.PI / 2) / segmentAngle) % names.length;
            document.getElementById(resultId).innerText = `Sonuç: ${names[index]}`;
            return;
        }
        const spinAngle = easeOut(spinTime, 0, spinAngleStart, spinTimeTotal);
        rotation += (spinAngle * Math.PI / 180);
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.save();
        ctx.translate(centerX, centerY);
        ctx.rotate(rotation);
        ctx.translate(-centerX, -centerY);
        drawWheel(canvasId, names);
        ctx.restore();
        requestAnimationFrame(rotateWheel);
    }

    rotateWheel();
}

function easeOut(t, b, c, d) {
    const ts = (t /= d) * t;
    const tc = ts * t;
    return b + c * (tc + -3 * ts + 3 * t);
}

drawWheel('maleWheel', maleNames);
drawWheel('femaleWheel', femaleNames);
