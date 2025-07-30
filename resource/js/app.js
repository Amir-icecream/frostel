document.addEventListener('DOMContentLoaded', () => {

  console.log('Welcome to Frostel ❄️');
});

// falling snow animation
const container = document.getElementById("snow-container");
function createSnowflake() {
    const flake = document.createElement("div");
    flake.classList.add("snowflake");
    
    // Random size
    const size = Math.random() * 0.6 + 0.2; // 2px to 8px
    flake.style.width = `${size}vh`;
    flake.style.height = `${size}vh`;
    
    // Random position
    flake.style.left = `${Math.random() * 100}%`;
    
    // Random duration & delay
    const duration = Math.random() * 5 + 5; // 5s to 10s
    flake.style.animation = `fall ${duration}s linear`;
    flake.style.animationDelay = `${Math.random() * 5}s`;
    
    // Optional slight horizontal movement
    flake.style.transform = `translateX(${Math.random() * 20 - 10}px)`;
    
    container.appendChild(flake);
    
    // Remove after animation ends
    setTimeout(() => {
        flake.style.opacity = 0; // fade out
        setTimeout(() => flake.remove(), 1000); // remove after fade
    }, duration * 1000);
}
// Generate snowflakes continuously
let int_id = null;

let frostel_img = document.getElementById('frostel-img');
frostel_img.addEventListener("click",function(){
    int_id = setInterval(createSnowflake, 100); // every 100ms
});
frostel_img.addEventListener("touchstart",function(){
    int_id = setInterval(createSnowflake, 100); // every 100ms
});

