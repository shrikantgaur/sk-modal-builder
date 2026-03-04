(() => {
  'use strict';

  const body = document.body;

  const closeAll = () => {
    document.querySelectorAll('.skmb-overlay.skmb-active').forEach(o => {
      o.classList.remove('skmb-active');
      o.querySelector('.skmb-modal')?.setAttribute('aria-hidden', 'true');
    });
    body.classList.remove('skmb-open');
  };

  const openModal = overlay => {
    closeAll();
    overlay.classList.add('skmb-active');
    overlay.querySelector('.skmb-modal')?.setAttribute('aria-hidden', 'false');
    body.classList.add('skmb-open');
  };

  document.querySelectorAll('.skmb-overlay').forEach(overlay => {
    const modal = overlay.querySelector('.skmb-modal');
    if (!modal) return;

    let opened = false;
    const safeOpen = () => {
      if (opened) return;
      opened = true;
      openModal(overlay);
    };

    const trigger = modal.dataset.trigger || 'load'; // load, scroll, exit, click
    const delay = Number(modal.dataset.delay || 0);
    const scroll = Number(modal.dataset.scroll || 0);
    const clickSelector = modal.dataset.clickTarget || null;

    // ---------- Trigger Logic ----------
    if (trigger === 'load') {
      setTimeout(safeOpen, delay * 1000);
    }

    if (trigger === 'scroll' && scroll > 0) {
      const onScroll = () => {
        const percent = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
        if (percent >= scroll) {
          safeOpen();
          window.removeEventListener('scroll', onScroll);
        }
      };
      window.addEventListener('scroll', onScroll, { passive: true });
    }

    if (trigger === 'exit') {
      const onExit = e => {
        if (e.clientY <= 0) safeOpen();
      };
      document.addEventListener('mouseleave', onExit);
    }

    if (trigger === 'click' && clickSelector) {
      document.querySelectorAll(clickSelector).forEach(el => {
        el.addEventListener('click', e => {
          e.preventDefault();
          safeOpen();
        });
      });
    }

    // ---------- Close Buttons ----------
    modal.querySelector('.skmb-close')?.addEventListener('click', () => closeAll());

    overlay.addEventListener('click', e => {
      if (e.target === overlay && overlay.dataset.overlayClose !== "0") closeAll();
    });
  });

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeAll();
  });
})();
