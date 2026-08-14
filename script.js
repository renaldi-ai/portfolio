// Portfolio Website - Renaldi Yoga Pratama

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functions
    initEnhancedLoadingScreen(); // Use enhanced loading screen
    initNavigation();
    initTypingEffect();
    initBackToTop();
    initPortfolioFilter();
    initContactForm();
    initNewsletterForm();
    initCurrentYear();
    initAOS();
    initSkillAnimation();
});

// ========================================
// ENHANCED LOADING SCREEN FUNCTIONALITY
// ========================================
function initEnhancedLoadingScreen() {
    const loadingScreen = document.getElementById('loadingScreen');
    
    if (!loadingScreen) {
        console.warn('Loading screen element not found');
        return;
    }

    // Handle progress bar (current HTML uses loadingProgressBar)
    const progressBar = document.getElementById('loadingProgressBar');
    const loadingStatus = document.getElementById('loadingStatus');
    
    // If the page load event fires before this runs, hide immediately
    if (document.readyState === 'complete') {
        setTimeout(() => {
            loadingScreen.style.opacity = '0';
            loadingScreen.style.visibility = 'hidden';
        }, 500);
        return;
    }
    
    // Fallback: Hide loading screen when page is fully loaded
    window.addEventListener('load', function() {
        setTimeout(() => {
            loadingScreen.style.opacity = '0';
            loadingScreen.style.visibility = 'hidden';
            setTimeout(() => {
                loadingScreen.style.display = 'none';
            }, 800);
        }, 500);
    });
    
    // Absolute fallback: Hide after 4.5 seconds if load event doesn't fire
    setTimeout(() => {
        if (loadingScreen.style.visibility !== 'hidden') {
            loadingScreen.style.opacity = '0';
            loadingScreen.style.visibility = 'hidden';
            setTimeout(() => {
                loadingScreen.style.display = 'none';
            }, 800);
        }
    }, 4500);
}

// Navigation
function initNavigation() {
    const header = document.getElementById('header');
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Header scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        // Update active nav link
        updateActiveNavLink();
    });
    
    // Hamburger menu toggle
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
            document.body.classList.toggle('nav-open');
        });
    }
    
    // Close menu when clicking a link
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (hamburger) {
                hamburger.classList.remove('active');
            }
            if (navMenu) {
                navMenu.classList.remove('active');
            }
            document.body.classList.remove('nav-open');
        });
    });

    // Close menu when clicking outside of it
    document.addEventListener('click', function(e) {
        if (!navMenu || !navMenu.classList.contains('active')) return;
        const clickedInsideMenu = navMenu.contains(e.target);
        const clickedHamburger = hamburger && hamburger.contains(e.target);
        if (!clickedInsideMenu && !clickedHamburger) {
            navMenu.classList.remove('active');
            if (hamburger) hamburger.classList.remove('active');
            document.body.classList.remove('nav-open');
        }
    });
    
    // Update active nav link on scroll
    function updateActiveNavLink() {
        const sections = document.querySelectorAll('section[id]');
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (scrollY >= (sectionTop - 200)) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    }
}

// Typing Effect
function initTypingEffect() {
    const typingText = document.getElementById('typingText');
    if (!typingText) return;
    
    const texts = [
        "Web Developer PHP",
        "Computer Technician",
        "Software Installer",
        "Office Word Expert",
        "IT Consultant",
        "IoT Specialist"
    ];
    
    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let typingSpeed = 100;
    
    function type() {
        const currentText = texts[textIndex];
        
        if (isDeleting) {
            typingText.textContent = currentText.substring(0, charIndex - 1);
            charIndex--;
            typingSpeed = 50;
        } else {
            typingText.textContent = currentText.substring(0, charIndex + 1);
            charIndex++;
            typingSpeed = 100;
        }
        
        if (!isDeleting && charIndex === currentText.length) {
            isDeleting = true;
            typingSpeed = 2000; // Pause at end
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            textIndex = (textIndex + 1) % texts.length;
            typingSpeed = 500; // Pause before typing next
        }
        
        setTimeout(type, typingSpeed);
    }
    
    // Start typing after 1 second
    setTimeout(type, 1000);
}

// Back to Top Button
function initBackToTop() {
    const backToTop = document.getElementById('backToTop');
    
    if (!backToTop) return;
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });
    
    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Portfolio Filter
function initPortfolioFilter() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    
    if (filterBtns.length === 0 || portfolioItems.length === 0) return;
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            // Filter portfolio items
            portfolioItems.forEach(item => {
                const category = item.getAttribute('data-category');
                
                if (filterValue === 'all' || category === filterValue) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 100);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
}

// Contact Form
function initContactForm() {
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');
    
    if (!contactForm) return;
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        if (!validateForm()) {
            return;
        }
        
        // Get form data
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        submitBtn.disabled = true;
        
        // Send form data
        fetch('send-email.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, 'success');
                contactForm.reset();
                
                // Log form data for debugging
                console.log('Form submitted:', {
                    name: formData.get('name'),
                    email: formData.get('email'),
                    subject: formData.get('subject'),
                    service: formData.get('service'),
                    message: formData.get('message')
                });
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Koneksi terputus. Silakan hubungi via WhatsApp: 0895-4063-98540', 'error');
        })
        .finally(() => {
            // Reset button state
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        });
    });
    
    // Form validation
    function validateForm() {
        const name = contactForm.querySelector('input[name="name"]');
        const email = contactForm.querySelector('input[name="email"]');
        const subject = contactForm.querySelector('input[name="subject"]');
        const message = contactForm.querySelector('textarea[name="message"]');
        
        let isValid = true;
        let errorMessage = '';
        
        // Reset error states
        [name, email, subject, message].forEach(input => {
            input.style.borderColor = '';
        });
        
        // Validate name
        if (!name.value.trim()) {
            name.style.borderColor = '#ef4444';
            errorMessage += 'Nama wajib diisi. ';
            isValid = false;
        }
        
        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim()) {
            email.style.borderColor = '#ef4444';
            errorMessage += 'Email wajib diisi. ';
            isValid = false;
        } else if (!emailRegex.test(email.value)) {
            email.style.borderColor = '#ef4444';
            errorMessage += 'Format email tidak valid. ';
            isValid = false;
        }
        
        // Validate subject
        if (!subject.value.trim()) {
            subject.style.borderColor = '#ef4444';
            errorMessage += 'Subjek wajib diisi. ';
            isValid = false;
        }
        
        // Validate message
        if (!message.value.trim()) {
            message.style.borderColor = '#ef4444';
            errorMessage += 'Pesan wajib diisi. ';
            isValid = false;
        }
        
        if (!isValid) {
            showMessage(errorMessage, 'error');
        }
        
        return isValid;
    }
    
    // Show message function
    function showMessage(message, type) {
        if (!formMessage) return;
        
        formMessage.textContent = message;
        formMessage.className = type;
        formMessage.style.display = 'block';
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            formMessage.style.display = 'none';
        }, 5000);
    }
}

// Newsletter Form
function initNewsletterForm() {
    const newsletterForm = document.getElementById('newsletterForm');
    
    if (!newsletterForm) return;
    
    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const emailInput = this.querySelector('input[type="email"]');
        const email = emailInput.value;
        
        if (!email) {
            alert('Silakan masukkan email Anda');
            return;
        }
        
        // Simulate newsletter subscription
        alert(`Terima kasih! Email ${email} telah berhasil terdaftar untuk newsletter.`);
        this.reset();
    });
}

// Current Year in Footer
function initCurrentYear() {
    const yearElement = document.getElementById('currentYear');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }
}

// AOS Animation
function initAOS() {
    // AOS is initialized via script tag in HTML
    // This function can be used for custom AOS configurations
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            disable: window.innerWidth < 768
        });
    }
}

// Skill Animation
function initSkillAnimation() {
    const skillCards = document.querySelectorAll('.skill-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target.querySelector('.level-progress');
                if (progressBar) {
                    const width = progressBar.style.width;
                    progressBar.style.width = '0';
                    setTimeout(() => {
                        progressBar.style.width = width;
                    }, 300);
                }
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    skillCards.forEach(card => observer.observe(card));
}

// Smooth Scroll for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        if (href === '#' || href === '#!') {
            e.preventDefault();
            return;
        }
        
        const targetElement = document.querySelector(href);
        if (targetElement) {
            e.preventDefault();
            
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
        }
    });
});

// Service Card Hover Effect
document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        if (this.classList.contains('featured')) {
            this.style.transform = 'scale(1.08)';
        } else {
            this.style.transform = 'translateY(-15px)';
        }
    });
    
    card.addEventListener('mouseleave', function() {
        if (this.classList.contains('featured')) {
            this.style.transform = 'scale(1.05)';
        } else {
            this.style.transform = 'translateY(0)';
        }
    });
});

// Download CV Alert
document.querySelectorAll('a[download]').forEach(link => {
    link.addEventListener('click', function(e) {
        if (!this.getAttribute('href') || this.getAttribute('href') === '#') {
            e.preventDefault();
            alert('CV sedang diperbarui. Silakan hubungi saya langsung untuk mendapatkan CV terbaru.');
        }
    });
});

// WhatsApp Click Tracking
document.querySelectorAll('a[href*="whatsapp"]').forEach(link => {
    link.addEventListener('click', function() {
        console.log('WhatsApp clicked - Ready to chat!');
    });
});
