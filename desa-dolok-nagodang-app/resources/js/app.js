import './bootstrap';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Swiper = Swiper;
window.SwiperModules = {
    Navigation,
    Pagination,
    Autoplay
};
