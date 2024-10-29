export function headerHeight() {
  const header = document.querySelector('.g-header') as HTMLElement;

  if (header) {
    document.documentElement.style.setProperty('--header-height', `${header.offsetHeight}px`);
  }
}

export function toggleMenu() {
  const burger = document.querySelector('.menu-burger') as HTMLElement;
  const headerElements = document.querySelectorAll(
    '.g-header__nav-mobile a, .g-header__nav-mobile button'
  ) as NodeListOf<HTMLElement>;

  burger?.addEventListener('click', () => {
    document.body.classList.toggle('menu-open');
  });

  headerElements.forEach((element) => {
    element.addEventListener('click', () => {
      document.body.classList.remove('menu-open');
    });
  });
}

export function animationHeader() {
  let lastScrollY = 0;
  const headerContent = document.querySelector('.g-header__content') as HTMLElement;
  const bgHeader = document.querySelector('.bg-header') as HTMLElement;

  const handleScroll = () => {
    const currentScrollY = window.scrollY;

    if (currentScrollY > lastScrollY && currentScrollY > 200) {
      headerContent.classList.add('header-scroll');
      bgHeader.classList.add('header-scroll');
    } else {
      headerContent.classList.remove('header-scroll');
      bgHeader.classList.remove('header-scroll');
    }

    lastScrollY = currentScrollY;
  };

  window.addEventListener('scroll', handleScroll, { passive: true });
}
