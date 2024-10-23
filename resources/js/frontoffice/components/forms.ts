export function initForms() {
  selectCheckboxes();
  initFilesUpload();
}

/**
 * Initializes form functionality like dropdowns and checkbox toggling.
 * Finds all dropdown elements and adds click handlers to toggle them open/closed.
 * Also adds a global click handler to close open dropdowns when clicking outside.
 */

function selectCheckboxes() {
  const selects = document.querySelectorAll('[data-type="dropdown"]');

  if (!selects.length) {
    return;
  }

  selects.forEach(select => {
    const btn = select.querySelector('[data-type="dropdown-btn"]');

    btn?.addEventListener('click', e => {
      e.preventDefault();
      const bottomPosition = window.innerHeight - select.getBoundingClientRect().bottom;
      const dropdown = select.querySelector('[data-type="dropdown-content"]');

      bottomPosition < 220 ? dropdown?.classList.add('pos-top') : dropdown?.classList.remove('pos-top');
      select.classList.toggle('is-active');
    });
  });


  document.addEventListener('click', e => {
    if (e && e.target) {
      const target = e.target as HTMLElement;

      selects.forEach(select => {
        select.classList.remove('is-active');
      });

      if (target.closest('[data-type="dropdown"]')) {
        const currentSelect = target.closest('[data-type="dropdown"]');
        currentSelect?.classList.add('is-active');
      }
    }
  });
}

function initFilesUpload() {
  document.querySelectorAll('.input-file').forEach((el) => {
    const input = el.querySelector('input[type="file"]');
    const fileNameElement = el.querySelector(".input-file__name");

    input?.addEventListener("change", (e) => {
      if (e && e.target) {
        const target = e.target as HTMLInputElement;
        const file = target.files?.[0]; // Added null check with "?"
        if (file) {
          const fileName = file.name;
          fileNameElement && (fileNameElement.innerHTML = fileName); // Added null check with "&&"
        }
      }
    });
  });
}



