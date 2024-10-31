export function headerHeight() {
  const header = document.querySelector('.g-header') as HTMLElement;

  if (header) {
    document.documentElement.style.setProperty('--header-height', `${header.offsetHeight}px`);
  }
}

export function toggleMenu() {
  const burgers = document.querySelectorAll('.menu-burger') as NodeListOf<HTMLElement>;
  const headerElements = document.querySelectorAll(
    '.g-header__nav-mobile a, .g-header__nav-mobile button'
  ) as NodeListOf<HTMLElement>;

  burgers?.forEach((burger) => {
    burger.addEventListener('click', () => {
      document.body.classList.toggle('menu-open');
      document.body.classList.remove('header-scroll');
    });
  });

  headerElements.forEach((element) => {
    element.addEventListener('click', () => {
      document.body.classList.remove('menu-open');
    });
  });
}

export function animationHeader() {
  let lastScrollY = 0;

  const handleScroll = () => {
    const currentScrollY = window.scrollY;

    if (currentScrollY > lastScrollY && currentScrollY > 200) {
      document.body.classList.add('header-scroll');
    } else {
      document.body.classList.remove('header-scroll');
    }

    lastScrollY = currentScrollY;
  };

  window.addEventListener('scroll', handleScroll, { passive: true });
}
