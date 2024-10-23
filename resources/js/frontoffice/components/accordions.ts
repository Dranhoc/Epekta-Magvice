export function initAccordions() {
  const accordions = document.querySelectorAll('.accordion__button');

  accordions.forEach((accordion) => {
    const panel = accordion.nextElementSibling as HTMLElement;

    if (panel) {
      accordion.setAttribute('aria-expanded', 'false');

      // Toggle accordion
      accordion.addEventListener('click', () => {
        let expanded = accordion.getAttribute('aria-expanded') === 'true';
        expanded
          ? accordion.setAttribute('aria-expanded', 'false')
          : accordion.setAttribute('aria-expanded', 'true');

        if (panel.style.maxHeight) {
          panel.style.maxHeight = '';
        } else {
          panel.style.maxHeight = `${panel.scrollHeight}px`;
        }
      });
    }
  });
}
