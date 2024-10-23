export function footerInit() {
  footerScrollUp();
  checkPrefooter();
  scrollToPrefooter();
}

function footerScrollUp() {
  const scrollToTopButton = document.querySelector('.g-footer__arrow');

  scrollToTopButton?.addEventListener('click', function () {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

function checkPrefooter() {
  const prefooter = document.querySelector('.s-prefooter');

  if (prefooter && prefooter.classList.contains('big')) {
    prefooter.classList.add('is-active');
    document.querySelector('.g-footer')?.classList.add('big');
  }
}

function scrollToPrefooter() {
  const links = document.querySelectorAll("a[href='#prefooter']");

  if (!links) return;

  links.forEach((link) => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const prefooter = document.getElementById('prefooter');
      if (!prefooter) return;

      const y = prefooter.getBoundingClientRect().top + window.pageYOffset - 120;

      window.scrollTo({
        top: y,
        behavior: 'smooth'
      });
    });
  });
}
