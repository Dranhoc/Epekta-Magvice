export function headerHeight() {
  const header = document.querySelector('.g-header') as HTMLElement;

  if (header) {
    document.documentElement.style.setProperty('--header-height', `${header.offsetHeight}px`);
  }
}

export function toggleMenu() {
  const burger = document.querySelector('.menu-burger') as HTMLElement;

  burger?.addEventListener('click', () => {
    document.body.classList.toggle('menu-open');
  });
}
