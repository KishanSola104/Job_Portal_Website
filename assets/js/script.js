document.addEventListener('DOMContentLoaded', () => {

  // ===== HERO SLIDER =====
  const slides = document.querySelectorAll('.hero-slide');
  const indicators = document.querySelectorAll('.indicator');
  let currentIndex = 0;
  const slideInterval = 5000;
  let interval;

  if (slides.length && indicators.length && slides.length === indicators.length) {

    function resetSlide(slide, indicator) {
      slide.classList.remove('active');
      indicator.classList.remove('active');
      const lines = slide.querySelector('.hero-lines');
      if (lines) {
        lines.style.top = '-100%';
        lines.style.opacity = 0;
        lines.style.transform = 'translateX(-50%)';
      }
    }

    function animateText(slide) {
      const line1 = slide.querySelector('.line1');
      const line2 = slide.querySelector('.line2');
      const parent = slide.querySelector('.hero-lines');

      if (parent && line2) {
        setTimeout(() => {
          parent.style.top = '50%';
          parent.style.opacity = 1;
          parent.style.transform = 'translate(-50%, -50%)';
        }, 1500);
      }
    }

    function showSlide(index) {
      slides.forEach((slide, i) => resetSlide(slide, indicators[i]));
      const activeSlide = slides[index];
      activeSlide.classList.add('active');
      indicators[index].classList.add('active');
      animateText(activeSlide);
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % slides.length;
      showSlide(currentIndex);
    }

    function startInterval() {
      stopInterval(); // ensure no duplicate intervals
      interval = setInterval(nextSlide, slideInterval);
    }

    function stopInterval() {
      if (interval) clearInterval(interval);
    }

    // Manual indicators click
    indicators.forEach((indicator, i) => {
      indicator.addEventListener('click', () => {
        stopInterval();
        currentIndex = i;
        showSlide(currentIndex);
        startInterval();
      });
    });

    showSlide(currentIndex);
    startInterval();
  }

  // ===== ABOUT US SCROLL ANIMATION =====
  const leftPart = document.querySelector('.left-part-about');
  const rightPart = document.querySelector('.right-part-about');

  function handleScroll() {
    const triggerPoint = window.innerHeight * 0.8;

    if (leftPart && leftPart.getBoundingClientRect().top < triggerPoint) {
      leftPart.classList.add('animate-in-left');
    }
    if (rightPart && rightPart.getBoundingClientRect().top < triggerPoint) {
      rightPart.classList.add('animate-in-right');
    }
  }
  window.addEventListener('scroll', handleScroll);
  handleScroll();

  // ===== ROW ANIMATIONS (Services + Job Roles) =====
  const animatedRows = document.querySelectorAll(
    ".first-services-row, .second-services-row, .first-job-row, .second-job-row"
  );

  const rowObserver = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const target = entry.target;
          if (target.classList.contains("first-services-row") || target.classList.contains("first-job-row")) {
            target.classList.add("slide-in-right");
          } else {
            target.classList.add("slide-in-left");
          }

          target.querySelectorAll(".service-card, .job-card").forEach((card, i) => {
            card.style.transitionDelay = `${i * 0.15}s`;
            card.classList.add("visible");
          });

          observer.unobserve(target);
        }
      });
    },
    { threshold: 0.3 }
  );

  animatedRows.forEach(row => rowObserver.observe(row));

  // ===== VIEW MORE / VIEW LESS =====
  const serviceBtn = document.querySelector(".services-section .view-more");
  const extraServicesRow = document.querySelector(".extra-services-row");
  if (serviceBtn && extraServicesRow) {
    serviceBtn.addEventListener("click", () => {
      const isVisible = extraServicesRow.classList.toggle("visible");
      serviceBtn.textContent = isVisible ? "View Less" : "View More";
    });
  }

  const jobBtn = document.querySelector(".job-section .view-more");
  const extraJobRow = document.querySelector(".extra-row");
  if (jobBtn && extraJobRow) {
    jobBtn.addEventListener("click", () => {
      const isVisible = extraJobRow.classList.toggle("visible");
      jobBtn.textContent = isVisible ? "View Less" : "View More";
    });
  }

  // ===== GENERIC FADE-IN ANIMATIONS =====
  const fadeElements = document.querySelectorAll(".animate");
  const fadeObserver = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("active");
          fadeObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 }
  );
  fadeElements.forEach(el => fadeObserver.observe(el));


  
 /* Why Choose us  */
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if(entry.isIntersecting){
      entry.target.classList.add('visible');
    }
  });
});

const slideRight = document.querySelector('.slide-from-right');
if (slideRight) {
  observer.observe(slideRight);
}


});
