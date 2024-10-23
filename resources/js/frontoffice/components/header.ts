/**
 * Sets the CSS variable for the header height based on the actual height of the header element.
 * This allows other elements to use the header height in their styling.
 */

/**
 * Adds a click handler to the menu burger button to toggle the 'menu-open' class on the body.
 * This class controls the open/closed state of the menu.
 */
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
