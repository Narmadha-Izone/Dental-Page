// Mobile Menu Toggle
const menuToggle = document.getElementById('menuToggle');
const navLinks = document.getElementById('navLinks');

menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

// Close mobile menu when clicking on a link
const navLinkItems = document.querySelectorAll('.nav-links a');
navLinkItems.forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('active');
    });
});


// ===== PROGRAM NAVIGATION LOGIC =====

// ----- Fellowships -----
const fellowshipLink = document.getElementById('fellowshipsLink');
const fellowshipSection = document.getElementById('fellowships');

// ----- Masterships -----
const mastershipLink = document.getElementById('mastershipsLink');
const mastershipSection = document.getElementById('masterships');

// ----- Exam Courses -----
const examcourseLink = document.getElementById('examcourseLink');
const examcourseSection = document.getElementById('examcourse');

// ----- Short Courses -----
const shortcourseLink = document.getElementById('shortcourseLink');
const shortcourseSection = document.getElementById('shortcourse');


// All main sections EXCEPT fellowship, mastership, examcourse, and shortcourse
const mainSections = document.querySelectorAll(
    'section:not(#fellowships):not(#masterships):not(#examcourse):not(#shortcourse)'
);

// Function to show a section and hide others
function showSection(sectionToShow) {
    mainSections.forEach(section => {
        section.style.display = 'none';
    });

    // Hide all special sections
    fellowshipSection.style.display = 'none';
    mastershipSection.style.display = 'none';
    
    const examSection = document.getElementById('examcourse');
    const shortSection = document.getElementById('shortcourse');
    if (examSection) examSection.style.display = 'none';
    if (shortSection) shortSection.style.display = 'none';

    // Show the requested section
    if (sectionToShow) {
        sectionToShow.style.display = 'block';
    }

    // Smooth scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Show Fellowship page
fellowshipLink.addEventListener('click', (e) => {
    e.preventDefault();
    showSection(fellowshipSection);
});

// Show Mastership page
mastershipLink.addEventListener('click', (e) => {
    e.preventDefault();
    showSection(mastershipSection);
});

// Show Exam Courses page
examcourseLink.addEventListener('click', (e) => {
    e.preventDefault();
    showSection(examcourseSection);
});

// Show Short Courses page
shortcourseLink.addEventListener('click', (e) => {
    e.preventDefault();
    showSection(shortcourseSection);
});


// Restore homepage when clicking other nav links
/*
const normalNavLinks = document.querySelectorAll(
    '.nav-links a:not(#fellowshipsLink):not(#mastershipsLink)'
);
*/

const normalNavLinks = document.querySelectorAll(
    '.nav-links a:not(#fellowshipsLink):not(#mastershipsLink):not(#examcourseLink):not(#shortcourseLink)'
);


normalNavLinks.forEach(link => {
    link.addEventListener('click', () => {
        // Hide special sections
        fellowshipSection.style.display = 'none';
        mastershipSection.style.display = 'none';
        
        const examSection = document.getElementById('examcourse');
        const shortSection = document.getElementById('shortcourse');
        if (examSection) examSection.style.display = 'none';
        if (shortSection) shortSection.style.display = 'none';

        // Show all main sections
        mainSections.forEach(section => {
          section.style.display = 'block';
          section.style.display = section.id === 'home' ? 'flex' : 'block';
        });
    });
});


// Contact Form Submission
const contactForm = document.getElementById('contactForm');

contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = {
        name: document.getElementById('name').value.trim(),
        email: document.getElementById('email').value.trim(),
        phone: document.getElementById('phone').value.trim(),
        course: document.getElementById('course').value.trim(),
        message: document.getElementById('message').value.trim()
    };

    try {
        const response = await fetch('contactSubmit.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });

        console.log('HTTP status:', response.status);
        if (!response.ok) {
            throw new Error('Server returned ' + response.status);
        }

        const result = await response.json();
        if (result.success) {
            alert(result.message);
            contactForm.reset();
        } else {
            alert(result.message || 'Something went wrong.');
        }

    } catch (error) {
        console.error('Fetch error:', error);
        alert('Network error. Please try later.');
    }
});


// Scroll animations for sections
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all sections
const sections = document.querySelectorAll('section');
sections.forEach(section => {
    section.style.opacity = '0';
    section.style.transform = 'translateY(30px)';
    section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(section);
});

// Header scroll effect
let lastScroll = 0;
window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    const header = document.querySelector('header');
    
    if (currentScroll > 100) {
        header.style.padding = '0.5rem 0';
        header.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.2)';
    } else {
        header.style.padding = '1rem 0';
        header.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
    }
    
    lastScroll = currentScroll;
});

// Keyboard navigation for slider
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
        if (typeof prevSlide === 'function') prevSlide();
    } else if (e.key === 'ArrowRight') {
        if (typeof nextSlide === 'function') nextSlide();
    }
});

// Play Video on hover
const videoElements = document.querySelectorAll('.video-element');

videoElements.forEach(video => {
    video.addEventListener('mouseenter', () => {
        video.muted = true;
        video.play();
    });
    video.addEventListener('mouseleave', () => {
        video.pause();
        video.currentTime = 0;
    });
});

// ===== ACHIEVEMENTS INFINITE SLIDER =====
const achSlider = document.getElementById('achievementsSlider');
const achSlides = document.querySelectorAll('.achievement-slide');
const achPrev = document.getElementById('achPrev');
const achNext = document.getElementById('achNext');

let achIndex = 0;
let slideWidth = achSlides[0].offsetWidth + 32;

// Clone first & last for infinite effect
const firstClone = achSlides[0].cloneNode(true);
const lastClone = achSlides[achSlides.length - 1].cloneNode(true);

achSlider.appendChild(firstClone);
achSlider.insertBefore(lastClone, achSlides[0]);

achIndex = 1;
achSlider.style.transform = `translateX(-${slideWidth * achIndex}px)`;

// Update slide width on resize
window.addEventListener('resize', () => {
    slideWidth = achSlides[0].offsetWidth + 32;
    achSlider.style.transition = 'none';
    achSlider.style.transform = `translateX(-${slideWidth * achIndex}px)`;
});

// Move slider
function moveAchievements() {
    achSlider.style.transition = 'transform 0.6s ease';
    achSlider.style.transform = `translateX(-${slideWidth * achIndex}px)`;
}

// Next
function nextAchievement() {
    achIndex++;
    moveAchievements();

    if (achIndex === achSlides.length + 1) {
        setTimeout(() => {
            achSlider.style.transition = 'none';
            achIndex = 1;
            achSlider.style.transform = `translateX(-${slideWidth}px)`;
        }, 600);
    }
}

// Prev
function prevAchievement() {
    achIndex--;
    moveAchievements();

    if (achIndex === 0) {
        setTimeout(() => {
            achSlider.style.transition = 'none';
            achIndex = achSlides.length;
            achSlider.style.transform =
                `translateX(-${slideWidth * achIndex}px)`;
        }, 600);
    }
}

// Auto slide
let achInterval = setInterval(nextAchievement, 3000);

// Pause on hover
achSlider.addEventListener('mouseenter', () => clearInterval(achInterval));
achSlider.addEventListener('mouseleave', () => {
    achInterval = setInterval(nextAchievement, 3000);
});

// Arrow controls
achNext.addEventListener('click', nextAchievement);
achPrev.addEventListener('click', prevAchievement);


// ===== MODAL AND COURSE DATA LOGIC =====
document.addEventListener('DOMContentLoaded', () => {

    /* ================= MODAL ELEMENTS ================= */
    const modal = document.getElementById('fellowshipModal');
    const closeBtn = document.getElementById('closeFellowship');
    const modalTitle = document.getElementById('modalTitle');
    const modalSubtitle = document.getElementById('modalSubtitle');
    const modalDescription = document.getElementById('modalDescription');
    const modalDuration = document.getElementById("modalDuration");
    const modalPrice = document.getElementById("modalPrice");
    const enquiryBtn = document.getElementById("enquiryBtn");
    const modalFormBox = document.getElementById("modalEnquiryForm");
    const enqCourse = document.getElementById("enqCourse");
    const enqDuration = document.getElementById("enqDuration");


    /* ================= FELLOWSHIP DATA ================= */
    const fellowshipData = {
        orthodontics: {
            title: "Fellowship in Fixed Orthodontics",
            subtitle: "The Orthodontic Fellowship Program",
            description: "In-depth clinical training in fixed orthodontics with hands-on case management.",
            duration: "3 months",
            price: "5999"
        },
        generaldentistry: {
            title: "Fellowship in General Dentistry",
            subtitle: "Advanced General Dental Practice",
            description: "Comprehensive exposure to diagnostics, restorative dentistry, and patient care.",
            duration: "2 months",
            price: "12000"
        },
        restorativedentistry: {
            title: "Fellowship in Restorative Dentistry",
            subtitle: "Modern Restorative Techniques",
            description: "Crowns, veneers, composites, and aesthetic restorations.",
            duration: "5 months",
            price: "11000"
        },
        endodontics: {
            title: "Fellowship in Clinical Endodontics",
            subtitle: "Advanced Root Canal Training",
            description: "Rotary endodontics, retreatments, and modern protocols.",
            duration: "1 month",
            price: "10000"
        },
        dentalimplantology: {
            title: "Fellowship in Dental Implantology",
            subtitle: "Surgical & Prosthetic Implant Training",
            description: "Implant planning, placement, and prosthetics.",
            duration: "8 months",
            price: "9999"
        },
        cosmeticdentistry: {
            title: "Fellowship in Cosmetic Dentistry",
            subtitle: "Smile Design & Aesthetics",
            description: "Smile design, veneers, whitening, and cosmetic procedures.",
            duration: "6 months",
            price: "6999"
        }
    };

    /* ================= MASTERSHIP DATA ================= */
    const masteryData = {
        fixedortho: {
            title: "Fixed Orthodontics",
            subtitle: "Advanced Mastery Program",
            description: "Advanced biomechanics, bracket systems, and real-world orthodontic case planning.",
            duration: "6 months",
            price: "49999"
        },
        cosmetic: {
            title: "Cosmetic Dentistry Course",
            subtitle: "Smile Design Mastery",
            description: "Aesthetic dentistry techniques including veneers and smile makeovers.",
            duration: "6 months",
            price: "19999"
        },
        crownbridge: {
            title: "Crown and Bridge Course",
            subtitle: "Prosthodontic Mastery",
            description: "Tooth preparation, impressions, occlusion, and fixed prosthetics.",
            duration: "6 months",
            price: "12000"
        },
        implantology: {
            title: "Dental Implantology Course",
            subtitle: "Advanced Implant Practice",
            description: "Hands-on implant placement and prosthetic restoration.",
            duration: "6 months",
            price: "12050"
        },
        labtech: {
            title: "Dental Lab Technician Course",
            subtitle: "Laboratory Workflow Training",
            description: "Crown fabrication, ceramics, and CAD/CAM basics.",
            duration: "6 months",
            price: "12200"
        },
        facialaesthetics: {
            title: "Facial Aesthetics Course",
            subtitle: "Aesthetic Medicine Training",
            description: "Botox, fillers, facial anatomy, and cosmetic procedures.",
            duration: "6 months",
            price: "12030"
        },
        oralsurgery: {
            title: "Basic Oral Surgery Clinical Course",
            subtitle: "Clinical Surgical Training",
            description: "Extractions, suturing, and patient management.",
            duration: "6 months",
            price: "45000"
        },
        laserdentistry: {
            title: "Laser Dentistry Course",
            subtitle: "Advanced Laser Applications",
            description: "Soft tissue lasers and modern dental protocols.",
            duration: "6 months",
            price: "32000"
        },
        periodontics: {
            title: "Periodontics Clinical Course",
            subtitle: "Advanced Periodontal Care",
            description: "Flap surgeries, grafting, and maintenance therapy.",
            duration: "6 months",
            price: "62000"
        },
        rotaryendo: {
            title: "Rotary Endodontics Course",
            subtitle: "Modern Endodontic Techniques",
            description: "Rotary instrumentation and obturation.",
            duration: "6 months",
            price: "72000"
        },
        orthoassistant: {
            title: "Orthodontist Assistant Course",
            subtitle: "Chairside Assistance Training",
            description: "Bracket bonding, wire changes, and patient care.",
            duration: "6 months",
            price: "52000"
        }
    };

    /* ================= EXAM COURSE DATA ================= */
    const examData = {
        nbde: {
            title: "NBDE Preparation Course",
            subtitle: "National Board Dental Examination",
            description: "Comprehensive preparation for NBDE Part I and Part II with practice tests and study materials.",
            duration: "6 months",
            price: "29999"
        },
        ndeb: {
            title: "NDEB Preparation Course",
            subtitle: "National Dental Examining Board of Canada",
            description: "Complete preparation for NDEB written and practical examinations.",
            duration: "6 months",
            price: "29999"
        },
        ore: {
            title: "ORE Preparation Course",
            subtitle: "Overseas Registration Examination",
            description: "Focused training for ORE Part 1 and Part 2 examinations for UK dental registration.",
            duration: "6 months",
            price: "29999"
        },
        adc: {
            title: "ADC Preparation Course",
            subtitle: "Australian Dental Council Examination",
            description: "Comprehensive preparation for ADC written and practical examinations.",
            duration: "6 months",
            price: "29999"
        },
        nzdrex: {
            title: "NZDREX Preparation Course",
            subtitle: "New Zealand Dentists Registration Examination",
            description: "Dentists need to pass the NZDREX to practice in New Zealand. The exam includes both written and clinical components..",
            duration: "5 months",
            price: "19999"
        }
    };

    /* ================= SHORT COURSE DATA ================= */
    const shortData = {
        materials: {
            title: "Latest Trends in Dental Materials",
            subtitle: "Modern Materials in Dentistry",
            description: "Explore the latest innovations in dental materials including ceramics, composites, and biomaterials.",
            duration: "2 weeks",
            price: "10999"
        },
        communication: {
            title: "Effective Communication with Dental Patients",
            subtitle: " ",
            description: "Strategies for improving patient communication and building rapport.",
            duration: "2 weeks",
            price: "19999"
        },
        digital: {
            title: "Introduction to Digital Dentistry",
            subtitle: "Digital Workflow Training",
            description: "Learn CAD/CAM systems, digital impressions, and 3D printing in dentistry.",
            duration: "3 weeks",
            price: "10999"
        },
        emergency: {
            title: "Emergency Procedures in Dentistry",
            subtitle: "Emergency Management Training",
            description: "Handle dental emergencies including trauma, infections, and medical emergencies in dental settings.",
            duration: "1 week",
            price: "10999"
        },
        infection: {
            title: "Infection Control in Dental Practice",
            subtitle: "",
            description: "Review of current infection control protocols and best practices.",
            duration: "1 week",
            price: "9999"
        },
        pediatric: {
            title: "Overview of Pediatric Dentistry",
            subtitle: "Child Dental Care Fundamentals",
            description: "Comprehensive introduction to pediatric dentistry techniques and behavior management.",
            duration: "2 weeks",
            price: "10999"
        },
        periodontal: {
            title: "Periodontal Health and Maintenance",
            subtitle: " ",
            description: "Updates on periodontal disease management and maintenance.",
            duration: "2-3 hours",
            price: "10999"
        },
        implant: {
            title: "Introduction to Implant Dentistry",
            subtitle: " ",
            description: "Basics of dental implantology, including planning and placement.",
            duration: "6 hours",
            price: "6999"
        },
        cosmetic: {
            title: "Introduction to Cosmetic Dentistry",
            subtitle: " ",
            description: "Overview of aesthetic considerations and basic cosmetic procedures.",
            duration: "2 hours",
            price: "1999"
        }
    };

    /* ================= OPEN MODAL ================= */
    function openModal(data) {
        modalTitle.textContent = data.title;
        modalSubtitle.textContent = data.subtitle;
        modalDescription.textContent = data.description;
        modalDuration.innerHTML = `<strong>Duration: </strong> ${data.duration}`;
        modalPrice.innerHTML = `<strong>Price:</strong> ₹ ${data.price}`;
        modalFormBox.style.display = "none"; 
        modal.style.display = 'flex';
    }

    /* ===== FELLOWSHIP CLICK ===== */
    document.querySelectorAll('.fellowship-learn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const fellowshipKey = btn.dataset.fellowship;
            if (fellowshipData[fellowshipKey]) {
                openModal(fellowshipData[fellowshipKey]);
            }
        });
    });

    /* ===== MASTERSHIP CLICK ===== */
    document.querySelectorAll('.mastery-learn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const masteryKey = btn.dataset.mastery;
            if (masteryData[masteryKey]) {
                openModal(masteryData[masteryKey]);
            }
        });
    });

    /* ===== EXAM COURSE CLICK ===== */
    document.querySelectorAll('.exam-learn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const examKey = btn.dataset.exam;
            if (examData[examKey]) {
                openModal(examData[examKey]);
            }
        });
    });

    /* ===== SHORT COURSE CLICK ===== */
    document.querySelectorAll('.short-learn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const shortKey = btn.dataset.short;
            if (shortData[shortKey]) {
                openModal(shortData[shortKey]);
            }
        });
    });

    // Show enquiry form on button click
    if (enquiryBtn) {
        enquiryBtn.addEventListener("click", () => {
            modalFormBox.style.display = "block";

            // Auto-fill values from modal content
            enqCourse.value = modalTitle.textContent;
            enqDuration.value = modalDuration.textContent.replace("Duration:", "").trim();
        });
    }

    /* ================= CLOSE MODAL ================= */
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }

    if (modal) {
        modal.addEventListener('click', e => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

  /* // Modal form submission
    const modalForm = document.getElementById("modalForm");
    if (modalForm) {
        modalForm.addEventListener("submit", e => {
            e.preventDefault();
            alert("Thank you! We will contact you shortly.");
            modalForm.reset();
            modalFormBox.style.display = "none";
        });
    }
*/
});


// Navigate to fellowship, mastership, exam, or short course when "View Program" is clicked
document.querySelectorAll('.view-program').forEach(btn => {
    btn.addEventListener('click', () => {
        const targetId = btn.dataset.target;
        console.log('View Program clicked, target:', targetId); // Debug log

        const fellowshipSection = document.getElementById('fellowships');
        const mastershipSection = document.getElementById('masterships');
        const examSection = document.getElementById('examcourse');
        const shortSection = document.getElementById('shortcourse');
        const mainSections = document.querySelectorAll('section:not(#fellowships):not(#masterships):not(#examcourse):not(#shortcourse)');

        // Hide all sections first
        mainSections.forEach(sec => sec.style.display = 'none');
        if (fellowshipSection) fellowshipSection.style.display = 'none';
        if (mastershipSection) mastershipSection.style.display = 'none';
        if (examSection) examSection.style.display = 'none';
        if (shortSection) shortSection.style.display = 'none';

        // Show the target section
        if (targetId === 'fellowships' && fellowshipSection) {
            fellowshipSection.style.display = 'block';
            console.log('Showing fellowships section');
        } else if (targetId === 'masterships' && mastershipSection) {
            mastershipSection.style.display = 'block';
            console.log('Showing masterships section');
        } else if (targetId === 'examcourse' && examSection) {
            examSection.style.display = 'block';
            console.log('Showing exam course section');
        } else if (targetId === 'shortcourse' && shortSection) {
            shortSection.style.display = 'block';
            console.log('Showing short course section');
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});

/* focus area animation */
const focusLists = document.querySelectorAll('.focus-areas');

const focusObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const items = entry.target.querySelectorAll('li');
            items.forEach((li, index) => {
                setTimeout(() => {
                    li.classList.add('animate');
                }, index * 200);
            });
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.2 });

focusLists.forEach(list => focusObserver.observe(list));


// Dropdown toggle for mobile
const dropdownBtn = document.querySelector('.dropdown-btn');
const dropdownContent = document.querySelector('.dropdown-content');

if (dropdownBtn && dropdownContent) {
    dropdownBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (dropdownContent.style.display === 'block') {
            dropdownContent.style.display = 'none';
        } else {
            dropdownContent.style.display = 'block';
        }
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.dropdown')) {
            dropdownContent.style.display = 'none';
        }
    });
}