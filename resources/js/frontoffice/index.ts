import { initSlidersHome } from './components/sliders';
import { headerHeight, toggleMenu, animationHeader } from './components/header';
import { footerInit } from './components/footer';
import { initForms } from './components/forms';
import { initAccordions } from './components/accordions';
import { toggleModals } from './components/modals';
import { scrollToAnchor } from './components/scroll-to-anchor';

window.addEventListener('DOMContentLoaded', () => {
  headerHeight();
  toggleMenu();
  initSlidersHome();
  footerInit();
  initForms();
  initAccordions();
  toggleModals();
  animationHeader();
  scrollToAnchor();
});

window.addEventListener('resize', () => {
  headerHeight();
});
