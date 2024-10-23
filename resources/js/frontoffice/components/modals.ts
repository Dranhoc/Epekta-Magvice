/**
 * Toggles modal elements on and off based on button clicks and Escape key presses.
 * 
 * It adds click handlers to all buttons with the data-modal-btn attribute. 
 * When clicked, it toggles the visibility of the modal with the corresponding data-modal ID.
 * 
 * It also adds a keydown handler to close any open modals when the Escape key is pressed.
 */
export function toggleModals() {
  const modalBtns = document.querySelectorAll('[data-modal-btn]') as NodeListOf<HTMLElement>;

  modalBtns.forEach((btn: HTMLElement) => {
    btn.addEventListener('click', e => {
      e.preventDefault();
      const modal = document.querySelector(`.modal[data-modal="${btn.dataset.modalBtn}"]`);

      if (!modal) { return; }

      modal?.classList.toggle('is-active');
      document.body.classList.toggle('no-scroll');
    });
  });

  // close modal when user press 'escape' key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      const activeModal = document.querySelector('.modal.is-active');

      if (activeModal) {
        activeModal.classList.remove('is-active');
        document.body.classList.remove('no-scroll');
      }
    }
  });
}
