export function initForms() {
  selectCheckboxes();
}

function selectCheckboxes() {
  const selects = document.querySelectorAll('[data-type="dropdown"]');

  if (!selects.length) {
    return;
  }

  selects.forEach((select) => {
    const btn = select.querySelector('[data-type="dropdown-btn"]');

    btn?.addEventListener('click', (e) => {
      e.preventDefault();
      const bottomPosition = window.innerHeight - select.getBoundingClientRect().bottom;
      const dropdown = select.querySelector('[data-type="dropdown-content"]');

      bottomPosition < 220
        ? dropdown?.classList.add('pos-top')
        : dropdown?.classList.remove('pos-top');
      select.classList.toggle('is-active');
    });
  });

  document.addEventListener('click', (e) => {
    if (e && e.target) {
      const target = e.target as HTMLElement;

      selects.forEach((select) => {
        select.classList.remove('is-active');
      });

      if (target.closest('[data-type="dropdown"]')) {
        const currentSelect = target.closest('[data-type="dropdown"]');
        currentSelect?.classList.add('is-active');
      }
    }
  });
}
