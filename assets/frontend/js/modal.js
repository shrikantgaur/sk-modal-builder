(function () {

  function openModal(modal) {
    modal.classList.add('skmb-active');
  }

  function closeModal(modal) {
    modal.classList.remove('skmb-active');
  }

  document.querySelectorAll('.skmb-modal').forEach(modal => {

    // Delay trigger
    const delay = modal.dataset.delay;
    if (delay) {
      setTimeout(() => openModal(modal), delay * 1000);
    }

    // Scroll trigger
    const scroll = modal.dataset.scroll;
    if (scroll) {
      window.addEventListener('scroll', () => {
        const scrolled = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
        if (scrolled >= scroll) openModal(modal);
      });
    }

    modal.querySelector('.skmb-close')?.addEventListener('click', () => {
      closeModal(modal);
    });
  });

})();
