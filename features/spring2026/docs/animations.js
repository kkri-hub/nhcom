/**
 * Fade-in animations using Intersection Observer
 * Lightweight, no dependencies
 */

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', () => {
  // Configuration
  const observerOptions = {
    root: null, // viewport
    rootMargin: '0px 0px -100px 0px', // trigger slightly before element enters viewport
    threshold: 0.15 // trigger when 15% of element is visible
  };

  // Callback function for intersection
  const handleIntersection = (entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // Add visible class to trigger animation
        entry.target.classList.add('is-visible');

        // Optional: Stop observing after animation (performance optimization)
        // observer.unobserve(entry.target);
      }
    });
  };

  // Create observer
  const observer = new IntersectionObserver(handleIntersection, observerOptions);

  // Observe all sections with fade-in class
  const fadeInSections = document.querySelectorAll('.fade-in');
  fadeInSections.forEach(section => {
    observer.observe(section);
  });

  // Observe cards separately for staggered animation
  const cards = document.querySelectorAll('.scene-card, .price-card');
  cards.forEach(card => {
    observer.observe(card);
  });

  // Smooth scroll enhancement with custom easing
  function smoothScrollTo(target, duration = 1000, offset = 80) {
    const start = window.pageYOffset;
    const distance = target.offsetTop - start - offset;
    const startTime = performance.now();

    function easeInOutCubic(t) {
      return t < 0.5
        ? 4 * t * t * t
        : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
    }

    function scroll(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      window.scrollTo(0, start + distance * easeInOutCubic(progress));

      if (progress < 1) requestAnimationFrame(scroll);
    }

    requestAnimationFrame(scroll);
  }

  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');

      // Don't prevent default for #top (let native scroll work)
      if (href === '#top') {
        e.preventDefault();
        smoothScrollTo({ offsetTop: 0 }, 800);
        return;
      }

      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        const isHeroCTA = this.closest('.hub-hero') !== null;
        smoothScrollTo(target, 1000, isHeroCTA ? 20 : 80);
      }
    });
  });

  // Add subtle parallax effect to hero (optional, lightweight)
  const hero = document.querySelector('.hub-hero');
  if (hero) {
    let ticking = false;

    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          const scrolled = window.pageYOffset;
          const rate = scrolled * 0.3; // parallax speed

          // Only apply if user hasn't disabled motion
          const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
          if (!prefersReducedMotion && scrolled < hero.offsetHeight) {
            hero.style.transform = `translateY(${rate}px)`;
          }

          ticking = false;
        });
        ticking = true;
      }
    });
  }

  // Back to top button visibility
  const backToTop = document.querySelector('.back-to-top');
  if (backToTop) {
    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 400) {
        backToTop.classList.add('is-visible');
      } else {
        backToTop.classList.remove('is-visible');
      }
    });
  }

  // Price card: hover on sub-product to swap featured image (PC only)
  const isTouch = window.matchMedia('(hover: none)').matches;
  if (!isTouch) {
    document.querySelectorAll('.price-card').forEach(card => {
      const featuredImg = card.querySelector('.price-featured img');
      const featuredName = card.querySelector('.price-featured-name');
      const featuredLink = card.querySelector('.price-featured');
      if (!featuredImg || !featuredName || !featuredLink) return;

      const originalSrc = featuredImg.src;
      const originalAlt = featuredImg.alt;
      const originalName = featuredName.innerHTML;
      const originalHref = featuredLink.href;

      card.querySelectorAll('.scene-product').forEach(product => {
        const prodImg = product.querySelector('.scene-product-img');
        const prodName = product.querySelector('.scene-product-name');
        const prodPrice = product.querySelector('.scene-product-price');
        if (!prodImg || !prodName || !prodPrice) return;

        product.addEventListener('mouseenter', () => {
          featuredImg.style.opacity = '0';
          setTimeout(() => {
            featuredImg.src = prodImg.src;
            featuredImg.alt = prodImg.alt;
            featuredName.innerHTML = prodName.textContent + '<span class="price-featured-price">' + prodPrice.textContent + '</span>';
            featuredLink.href = product.href;
            featuredImg.style.opacity = '1';
          }, 150);
        });
      });

      card.addEventListener('mouseleave', () => {
        featuredImg.src = originalSrc;
        featuredImg.alt = originalAlt;
        featuredName.innerHTML = originalName;
        featuredLink.href = originalHref;
      });
    });
  }

  // SP Price accordion toggle
  const isSP = window.matchMedia('(max-width: 768px)');

  function setupPriceAccordion() {
    document.querySelectorAll('.price-card .scene-products').forEach(products => {
      const title = products.querySelector('.scene-products-title');
      if (!title) return;

      // Avoid duplicate listeners
      if (title.dataset.accordionBound) return;
      title.dataset.accordionBound = 'true';

      title.addEventListener('click', () => {
        if (!isSP.matches) return;
        products.classList.toggle('is-open');
      });
    });
  }

  setupPriceAccordion();

  // Add fade-in to hero on page load
  setTimeout(() => {
    hero?.classList.add('is-visible');
  }, 100);
});
