import { Controller } from '@hotwired/stimulus';
import EmblaCarousel from 'embla-carousel';
import Autoplay from 'embla-carousel-autoplay';

const BREAKPOINTS = [
    { query: '(min-width: 1024px)', slidesToScroll: 3 },
    { query: '(min-width: 640px)', slidesToScroll: 2 },
    { query: '(min-width: 0px)', slidesToScroll: 1 },
];

export default class extends Controller {
    static targets = ['viewport', 'dots'];
    static values = {
        autoplayDelay: { type: Number, default: 8000 },
    };

    connect() {
        this.autoplay = Autoplay({ delay: this.autoplayDelayValue, stopOnInteraction: false });

        this.embla = EmblaCarousel(
            this.viewportTarget,
            { loop: false, align: 'start', containScroll: 'trimSnaps', slidesToScroll: this.currentSlidesToScroll() },
            [this.autoplay]
        );

        this.buildDots();
        this.embla.on('select', () => this.updateDots());
        this.embla.on('reInit', () => this.buildDots());

        this.mediaQueries = BREAKPOINTS.map(bp => window.matchMedia(bp.query));
        this.handleBreakpointChange = () => this.applyBreakpoint();
        this.mediaQueries.forEach(mq => mq.addEventListener('change', this.handleBreakpointChange));
    }

    disconnect() {
        this.mediaQueries?.forEach(mq => mq.removeEventListener('change', this.handleBreakpointChange));
        this.embla?.destroy();
    }

    currentSlidesToScroll() {
        const match = BREAKPOINTS.find(bp => window.matchMedia(bp.query).matches);
        return match ? match.slidesToScroll : 1;
    }

    applyBreakpoint() {
        const newValue = this.currentSlidesToScroll();

        this.embla.reInit({ loop: false, align: 'start', containScroll: 'trimSnaps', slidesToScroll: newValue });
    }

    next() {
        this.embla.scrollNext();
    }

    prev() {
        this.embla.scrollPrev();
    }

    buildDots() {
        this.dotsTarget.innerHTML = '';

        this.embla.scrollSnapList().forEach((_, index) => {
            const dot = document.createElement('button');
            dot.className = 'w-2 h-2 rounded-full transition';
            dot.setAttribute('aria-label', `Aller au groupe ${index + 1}`);
            dot.addEventListener('click', () => this.embla.scrollTo(index));
            this.dotsTarget.appendChild(dot);
        });

        this.updateDots();
    }

    updateDots() {
        const selectedIndex = this.embla.selectedScrollSnap();

        Array.from(this.dotsTarget.children).forEach((dot, index) => {
            dot.classList.toggle('bg-navy-900', index === selectedIndex);
            dot.classList.toggle('bg-blue-300', index !== selectedIndex);
        });
    }
}