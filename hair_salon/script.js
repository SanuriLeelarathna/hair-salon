// ========================
// Glamour Salon Website JS
// ========================

// ====== 1. Smooth Scroll Navigation ======
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const targetId = this.getAttribute('href');
    if (targetId.startsWith('#')) {
      e.preventDefault();
      document.querySelector(targetId).scrollIntoView({
        behavior: 'smooth'
      });
    }
  });
});


/* ====== 2. Mobile Menu Toggle ======
const menuToggle = document.querySelector('.menu-toggle');
const navMenu = document.querySelector('nav ul');

if (menuToggle) {
  menuToggle.addEventListener('click', () => {
    navMenu.classList.toggle('active');
  });
}*/


// ====== 3. Auto-Sliding Gallery ======
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const next = document.querySelector('.next');
const prev = document.querySelector('.prev');

function showSlide(n) {
  slides.forEach(slide => slide.classList.remove('active'));
  slides[n].classList.add('active');
}

function nextSlide() {
  slideIndex = (slideIndex + 1) % slides.length;
  showSlide(slideIndex);
}

function prevSlideFunc() {
  slideIndex = (slideIndex - 1 + slides.length) % slides.length;
  showSlide(slideIndex);
}

if (next && prev) {
  next.addEventListener('click', nextSlide);
  prev.addEventListener('click', prevSlideFunc);
  setInterval(nextSlide, 3000); // Auto move every 3 seconds
}


// ====== 4. Back to Top Button ======
const backToTop = document.createElement('button');
backToTop.textContent = "↑";
backToTop.id = "backToTop";
document.body.appendChild(backToTop);

const btn = document.getElementById("backToTop");
btn.style.position = "fixed";
btn.style.bottom = "30px";
btn.style.right = "30px";
btn.style.padding = "10px 15px";
btn.style.border = "none";
btn.style.background = "#3e053dff";
btn.style.color = "white";
btn.style.fontSize = "1.2rem";
btn.style.borderRadius = "50%";
btn.style.cursor = "pointer";
btn.style.display = "none";
btn.style.zIndex = "1000";

window.addEventListener("scroll", () => {
  if (window.scrollY > 300) {
    btn.style.display = "block";
  } else {
    btn.style.display = "none";
  }
});

btn.addEventListener("click", () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
});


// ====== 5. Optional Booking Alert ======
const bookingBtn = document.querySelector('#bookNow');
if (bookingBtn) {
  bookingBtn.addEventListener('click', () => {
    alert("Redirecting to booking form...");
    window.location.href = "booking.php";
  });
}
/* price tab 
document.addEventListener("DOMContentLoaded", () => {
  const tabs = document.querySelectorAll(".pricing-tabs .tab");
  const contents = document.querySelectorAll(".pricing-content");

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      // Remove "active" from all tabs
      tabs.forEach(t => t.classList.remove("active"));
      // Hide all content
      contents.forEach(c => c.classList.remove("active"));

      // Add "active" to clicked tab
      tab.classList.add("active");

      // Show corresponding content
      const target = document.getElementById(tab.dataset.tab);
      target.classList.add("active");
    });
  });
});*/
