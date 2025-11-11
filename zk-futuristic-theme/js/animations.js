/**
 * ZK Futuristic Theme - Animations and Interactions
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {

        // Particle Animation
        initParticles();

        // Navbar Scroll Effect
        initNavbarScroll();

        // Smooth Scrolling
        initSmoothScroll();

        // Intersection Observer for Fade-in Animations
        initScrollAnimations();

        // Mobile Menu
        initMobileMenu();

        // Mouse Parallax Effect
        initParallax();
    });

    /**
     * Particle Animation System
     */
    function initParticles() {
        const canvas = document.getElementById('particles-canvas');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        const particleCount = 100;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;
                this.size = Math.random() * 2 + 1;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
            }

            draw() {
                ctx.fillStyle = 'rgba(0, 245, 255, 0.5)';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }

        function animateParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });

            // Draw connections
            particles.forEach((p1, i) => {
                particles.slice(i + 1).forEach(p2 => {
                    const dx = p1.x - p2.x;
                    const dy = p1.y - p2.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < 150) {
                        ctx.strokeStyle = `rgba(0, 245, 255, ${0.2 * (1 - distance / 150)})`;
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(p1.x, p1.y);
                        ctx.lineTo(p2.x, p2.y);
                        ctx.stroke();
                    }
                });
            });

            requestAnimationFrame(animateParticles);
        }

        animateParticles();

        // Resize canvas on window resize
        window.addEventListener('resize', function() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    }

    /**
     * Navbar Scroll Effect
     */
    function initNavbarScroll() {
        const navbar = document.getElementById('site-navigation');
        if (!navbar) return;

        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    /**
     * Smooth Scrolling for Anchor Links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#' || targetId === '') return;

                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    // Close mobile menu if open
                    const navMenu = document.querySelector('.nav-menu');
                    if (navMenu && navMenu.classList.contains('active')) {
                        navMenu.classList.remove('active');
                    }
                }
            });
        });
    }

    /**
     * Intersection Observer for Scroll Animations
     */
    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    }

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('.nav-menu');

        if (!hamburger || !navMenu) return;

        // Close menu on outside click
        document.addEventListener('click', function(e) {
            if (navMenu.classList.contains('active') &&
                !navMenu.contains(e.target) &&
                !hamburger.contains(e.target)) {
                navMenu.classList.remove('active');
            }
        });

        // Handle keyboard navigation
        hamburger.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                window.toggleMenu();
            }
        });
    }

    /**
     * Mouse Parallax Effect
     */
    function initParallax() {
        const shapes = document.querySelectorAll('.shape, .floating-shapes .shape');
        if (shapes.length === 0) return;

        document.addEventListener('mousemove', function(e) {
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;

            shapes.forEach((shape, index) => {
                const speed = (index + 1) * 20;
                const x = (mouseX - 0.5) * speed;
                const y = (mouseY - 0.5) * speed;
                shape.style.transform = `translate(${x}px, ${y}px)`;
            });
        });
    }

})();

/**
 * Toggle mobile menu (global function)
 */
function toggleMenu() {
    const navMenu = document.querySelector('.nav-menu');
    if (navMenu) {
        navMenu.classList.toggle('active');
    }
}

/**
 * Close mobile menu (global function)
 */
function closeMenu() {
    const navMenu = document.querySelector('.nav-menu');
    if (navMenu) {
        navMenu.classList.remove('active');
    }
}
