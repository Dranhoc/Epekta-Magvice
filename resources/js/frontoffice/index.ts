import { initSlidersHome } from './components/sliders';
import { headerHeight, toggleMenu, animationHeader } from './components/header';
import { footerInit } from './components/footer';
import { initForms } from './components/forms';
import { initAccordions } from './components/accordions';
import { toggleModals } from './components/modals';

window.addEventListener('DOMContentLoaded', () => {
  headerHeight();
  toggleMenu();
  initSlidersHome();
  footerInit();
  initForms();
  initAccordions();
  toggleModals();
  animationHeader();
});

window.addEventListener('resize', () => {
  headerHeight();
});
