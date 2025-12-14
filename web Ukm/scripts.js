// scripts.js — simple interactivity for the value cards

document.addEventListener('DOMContentLoaded', function () {
  const toggles = document.querySelectorAll('.value-card .toggle-btn');

  toggles.forEach(btn => {
    const more = btn.nextElementSibling;

    // Click handler
    btn.addEventListener('click', () => {
      const isOpen = more.classList.toggle('open');
      btn.setAttribute('aria-expanded', String(isOpen));
      more.setAttribute('aria-hidden', String(!isOpen));
      btn.textContent = isOpen ? 'Tutup' : 'Selengkapnya';
    });

    // Keyboard: allow Enter or Space to activate when focused
    btn.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        btn.click();
      }
    });
  });
});

// Gallery touch support: toggle caption on click for touch devices
document.addEventListener('DOMContentLoaded', function () {
  const galleryItems = document.querySelectorAll('.gallery-item');

  galleryItems.forEach(item => {
    // Update ARIA on hover/focus
    item.addEventListener('mouseenter', () => {
      const cap = item.querySelector('.gallery-caption');
      if (cap) cap.setAttribute('aria-hidden', 'false');
    });
    item.addEventListener('mouseleave', () => {
      const cap = item.querySelector('.gallery-caption');
      if (cap) cap.setAttribute('aria-hidden', 'true');
    });
    item.addEventListener('focusin', () => {
      const cap = item.querySelector('.gallery-caption');
      if (cap) cap.setAttribute('aria-hidden', 'false');
    });
    item.addEventListener('focusout', () => {
      const cap = item.querySelector('.gallery-caption');
      if (cap) cap.setAttribute('aria-hidden', 'true');
    });

    item.addEventListener('click', (e) => {
      const target = e.target;
      // If image is clicked, open lightbox (preferred behavior)
      if (target && target.tagName === 'IMG') {
        openLightbox(target);
        return;
      }

      // Otherwise toggle caption for touch users
      item.classList.toggle('is-open');
      const caption = item.querySelector('.gallery-caption');
      if (caption) {
        const opened = item.classList.contains('is-open');
        caption.setAttribute('aria-hidden', String(!opened));
      }
    });
  });
});

/* --------- Automatic gallery image orientation detection --------- */
document.addEventListener('DOMContentLoaded', function () {
  const items = document.querySelectorAll('.gallery-item');

  items.forEach(item => {
    const img = item.querySelector('img');
    if (!img) return;

    // If image already loaded, detect; otherwise wait for load
    const detect = () => {
      // use naturalWidth / naturalHeight for true dimensions
      const w = img.naturalWidth;
      const h = img.naturalHeight;
      if (!w || !h) return;
      item.classList.remove('is-landscape', 'is-portrait');
      if (w >= h) {
        item.classList.add('is-landscape');
      } else {
        item.classList.add('is-portrait');
      }
    };

    if (img.complete) detect();
    else img.addEventListener('load', detect);
  });
});

/* --------- Lightbox functionality --------- */
function createLightbox() {
  const lb = document.createElement('div');
  lb.id = 'lightbox';
  lb.className = 'lightbox';
  lb.setAttribute('aria-hidden', 'true');
  lb.innerHTML = `
    <div class="lightbox-inner" role="dialog" aria-modal="true" aria-label="Gambar galeri">
      <button class="lightbox-close" aria-label="Tutup">✕</button>
      <img class="lightbox-img" src="" alt="">
      <div class="lightbox-caption" aria-hidden="true"><h4></h4><p></p></div>
    </div>
  `;
  document.body.appendChild(lb);
  return lb;
}

/* --------- Nav active link highlighting --------- */
document.addEventListener('DOMContentLoaded', function () {
  const navLinks = document.querySelectorAll('.nav-right a');
  const path = (window.location.pathname || '').split('/').pop();
  navLinks.forEach(a => {
    const href = a.getAttribute('href') || '';
    // Normalize index pages and empty path
    if ((href === path) || (href === 'index.html' && (path === '' || path === 'index.html')) ) {
      a.classList.add('active');
    }
  });
});

/* --------- Pengumuman carousel --------- */
(function () {
  function initCarousel(containerSelector, opts = {}) {
    const root = document.querySelector(containerSelector);
    if (!root) return;
    const slidesEl = root.querySelector('.slides');
    const slides = Array.from(root.querySelectorAll('.slide'));
    const prevBtn = root.querySelector('.slider-arrow.prev');
    const nextBtn = root.querySelector('.slider-arrow.next');
    const dotsEl = root.querySelector('.slider-dots');
    const total = slides.length;
    let index = 0;
    let intervalId = null;
    const delay = opts.delay || 5000;

    // build dots
    slides.forEach((s, i) => {
      const btn = document.createElement('button');
      btn.setAttribute('aria-label', `Slide ${i+1}`);
      btn.dataset.index = String(i);
      btn.addEventListener('click', () => goTo(i));
      dotsEl.appendChild(btn);
    });

    const dots = Array.from(dotsEl.children);

    function update() {
      slidesEl.style.transform = `translateX(-${index * 100}%)`;
      dots.forEach((d, i) => d.classList.toggle('active', i === index));
      slides.forEach((s, i) => {
        s.setAttribute('aria-hidden', String(i !== index));
      });
    }

    function goTo(i) {
      index = (i + total) % total;
      update();
    }

    function next() { goTo(index + 1); }
    function prev() { goTo(index - 1); }

    function start() {
      if (intervalId) return;
      intervalId = setInterval(next, delay);
    }

    function stop() {
      if (!intervalId) return;
      clearInterval(intervalId);
      intervalId = null;
    }

    // interactions
    if (nextBtn) nextBtn.addEventListener('click', () => { next(); stop(); setTimeout(start, delay); });
    if (prevBtn) prevBtn.addEventListener('click', () => { prev(); stop(); setTimeout(start, delay); });

    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);
    root.addEventListener('focusin', stop);
    root.addEventListener('focusout', start);

    // swipe support
    let startX = 0;
    let isDown = false;
    slidesEl.addEventListener('pointerdown', (e) => { isDown = true; startX = e.clientX; slidesEl.setPointerCapture(e.pointerId); });
    slidesEl.addEventListener('pointerup', (e) => { if (!isDown) return; isDown = false; const dx = e.clientX - startX; if (Math.abs(dx) > 40) { if (dx < 0) next(); else prev(); } });

    // init
    goTo(0);
    start();
  }

  // initialize the pengumuman carousel
  document.addEventListener('DOMContentLoaded', function () { initCarousel('.pengumuman-slider', { delay: 5000 }); });
})();

const lightboxEl = createLightbox();

function openLightbox(imgElement) {
  if (!imgElement) return;
  const lb = lightboxEl;
  const lbImg = lb.querySelector('.lightbox-img');
  const lbCaption = lb.querySelector('.lightbox-caption');
  const lbClose = lb.querySelector('.lightbox-close');

  // Set image and caption from clicked figure
  lbImg.src = imgElement.src;
  lbImg.alt = imgElement.alt || '';
  const fig = imgElement.closest('figure');
  if (fig) {
    const cap = fig.querySelector('.gallery-caption');
    if (cap) {
      const title = cap.querySelector('h4')?.textContent || '';
      const text = cap.querySelector('p')?.textContent || '';
      lbCaption.querySelector('h4').textContent = title;
      lbCaption.querySelector('p').textContent = text;
      lbCaption.setAttribute('aria-hidden', 'false');
    }
  }

  // Show
  lb.setAttribute('aria-hidden', 'false');
  lb.classList.add('open');

  // Save ref to last focused element to restore focus on close
  lb._lastFocus = document.activeElement;
  lbClose.focus();

  // Event handlers
  const onKey = (e) => {
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') nextLightbox();
    if (e.key === 'ArrowLeft') prevLightbox();
  };
  const onClickOutside = (e) => {
    if (e.target === lb) closeLightbox();
  };

  lb.addEventListener('click', onClickOutside);
  document.addEventListener('keydown', onKey);

  // Close button
  lbClose.onclick = closeLightbox;

  // attach cleanup to element for later removal
  lb._cleanup = () => {
    lb.removeEventListener('click', onClickOutside);
    document.removeEventListener('keydown', onKey);
    lbClose.onclick = null;
  };
}

function closeLightbox() {
  const lb = lightboxEl;
  if (!lb.classList.contains('open')) return;
  lb.classList.remove('open');
  lb.setAttribute('aria-hidden', 'true');
  const lbCaption = lb.querySelector('.lightbox-caption');
  lbCaption.setAttribute('aria-hidden', 'true');
  // cleanup
  if (lb._cleanup) lb._cleanup();
  // restore focus
  if (lb._lastFocus) lb._lastFocus.focus();
}

/* Lightbox navigation helpers (previous/next) */
function _galleryItemsArray() {
  return Array.from(document.querySelectorAll('.gallery-item img'));
}

function nextLightbox() {
  const lb = lightboxEl;
  const currentSrc = lb.querySelector('.lightbox-img').src;
  const arr = _galleryItemsArray();
  const idx = arr.findIndex(i => i.src === currentSrc);
  const next = arr[(idx + 1) % arr.length];
  if (next) openLightbox(next);
}

function prevLightbox() {
  const lb = lightboxEl;
  const currentSrc = lb.querySelector('.lightbox-img').src;
  const arr = _galleryItemsArray();
  const idx = arr.findIndex(i => i.src === currentSrc);
  const prev = arr[(idx - 1 + arr.length) % arr.length];
  if (prev) openLightbox(prev);
}
