import './bootstrap';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import Swal from 'sweetalert2';
import { createIcons, icons } from 'lucide';
import Chart from 'chart.js/auto';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'sweetalert2/dist/sweetalert2.min.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

Swiper.use([Navigation, Pagination, Autoplay]);

window.Swiper = Swiper;
window.SwiperModules = {
    Navigation,
    Pagination,
    Autoplay
};
window.Swal = Swal;
window.Chart = Chart;
window.lucide = {
    createIcons(options = {}) {
        return createIcons({
            icons,
            ...options,
        });
    },
};
