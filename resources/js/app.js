import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// =============================================
// PRELOADER
// =============================================
window.addEventListener('load', function() {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        setTimeout(() => {
            preloader.classList.add('hide');
        }, 600);
    }
});

// =============================================
// SCROLL PROGRESS BAR
// =============================================
window.addEventListener('scroll', function() {
    const progress = document.getElementById('scroll-progress');
    if (progress) {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progressPercent = (scrollTop / docHeight) * 100;
        progress.style.width = progressPercent + '%';
    }
});

// =============================================
// COUNTER ANIMATION
// =============================================
function animateCounters() {
    document.querySelectorAll('.number[data-count]').forEach(el => {
        const target = parseInt(el.getAttribute('data-count'));
        if (isNaN(target)) return;
        let current = 0;
        const increment = Math.ceil(target / 80);
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                el.textContent = target;
                clearInterval(timer);
            } else {
                el.textContent = current;
            }
        }, 20);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.disconnect();
            }
        });
    }, { threshold: 0.5 });

    const statsSection = document.querySelector('.hero-dashboard');
    if (statsSection) {
        observer.observe(statsSection);
    } else {
        setTimeout(animateCounters, 1000);
    }
});

// =============================================
// LIGHTBOX
// =============================================
document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightbox = document.createElement('div');
    lightbox.id = 'lightbox';
    lightbox.style.cssText = `
        position: fixed; inset: 0; background: rgba(0,0,0,0.85);
        display: none; align-items: center; justify-content: center;
        z-index: 99999; cursor: pointer;
    `;
    const img = document.createElement('img');
    img.style.cssText = 'max-width: 90%; max-height: 90%; border-radius: 12px;';
    lightbox.appendChild(img);
    document.body.appendChild(lightbox);

    galleryItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const src = this.querySelector('img')?.getAttribute('src');
            if (src) {
                img.src = src;
                lightbox.style.display = 'flex';
            }
        });
    });

    lightbox.addEventListener('click', function() {
        this.style.display = 'none';
    });
});

// =============================================
// NAVBAR TOGGLE
// =============================================
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.querySelector('.navbar-toggle');
    const navMenu = document.querySelector('.navbar-menu');
    if (toggle && navMenu) {
        toggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }
});

console.log('✅ HEAN app.js loaded (cursor-free)');