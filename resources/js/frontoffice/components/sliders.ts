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

  //section partners
  new Swiper('.swiper-logos', {
    modules: [Pagination, Autoplay],
    slidesPerView: 2,
    breakpoints: {
      460: {
        slidesPerView: 3
      },
      1280: {
        slidesPerView: 4
      }
    },
    spaceBetween: 30,
    autoplay: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    }
  });

  //home slider-photos
  new Swiper('.slider-photos', {
    modules: [Pagination, Autoplay],
    slidesPerView: 1,
    breakpoints: {
      630: {
        slidesPerView: 2
      },
      960: {
        slidesPerView: 3
      },
      1290: {
        slidesPerView: 4
      }
    },
    spaceBetween: 30,
    autoplay: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    }
  });

  //home slider-questions
  new Swiper('.slider-questions', {
    modules: [Pagination, Autoplay],
    slidesPerView: 1,
    spaceBetween: 30,
    autoplay: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    }
  });

  //home slider-testimonies
  new Swiper('.slider-testimonies', {
    modules: [Pagination, Autoplay, Navigation],
    slidesPerView: 1,
    spaceBetween: 30,
    autoplay: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    },
    navigation: {
      nextEl: '.swiper-button-testimonies.swiper-button-next',
      prevEl: '.swiper-button-testimonies.swiper-button-prev'
    }
  });
}
