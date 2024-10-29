export function scrollToAnchor() {
  const links = document.querySelectorAll('a[href^="#"]');

  links.forEach(link => {
      link.addEventListener('click', scrollToAnchorWithOffset);
  });
}

function scrollToAnchorWithOffset(event: Event) {
  event.preventDefault();

  const targetId = (event.currentTarget as HTMLAnchorElement).getAttribute('href')?.substring(1);
  if (!targetId) return;
  const targetElement = document.getElementById(targetId);
  if (!targetElement) return;

  const headerOffset = 120;
  const elementPosition = targetElement.getBoundingClientRect().top + window.scrollY;
  const offsetPosition = elementPosition - headerOffset;

  window.scrollTo({
      top: offsetPosition,
      behavior: 'smooth'
  });
}
