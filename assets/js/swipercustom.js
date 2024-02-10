'use strict';
  // core version + navigation, pagination modules:
  import Swiper, { Navigation, Pagination } from 'swiper';
  // import Swiper and modules styles
  import 'swiper/css';
  import 'swiper/css/navigation';
  import 'swiper/css/pagination';
const mySwiper = new Swiper('.swiper-container', {
    slidesPerView: 3,
    slidesPerColumn: 3,
    slidesPerGroup :3,
    spaceBetween: 30,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    on: {
      init: function () {},
      orientationchange: function(){},
      beforeResize: function(){
        let vw = window.innerWidth;
        if(vw > 1000){
          mySwiper.params.slidesPerView = 3
            mySwiper.params.slidesPerColumn = 3
            mySwiper.params.slidesPerGroup = 3;
        } else {
          mySwiper.params.slidesPerView = 4
            mySwiper.params.slidesPerColumn = 2
            mySwiper.params.slidesPerGroup =4;
        }
        mySwiper.init();
      },
    },
});