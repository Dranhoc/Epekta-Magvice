import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, Thumbs } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export function initSlidersHome() {
  // homepage, cards section goods
  new Swiper('.slider-cards', {
    modules: [Navigation],
    slidesPerView: 1,
    spaceBetween: 16,
    centeredSlides: true,
    breakpoints: {
      1024: {
        slidesPerView: 3,
        centeredSlides: false
      },
      1280: {
        slidesPerView: 4,
        centeredSlides: false
      }
    },
    navigation: {
      nextEl: '.swiper-button-cards.swiper-button-next',
      prevEl: '.swiper-button-cards.swiper-button-prev'
    }
  });
}
