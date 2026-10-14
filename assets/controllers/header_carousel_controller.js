import { Controller } from '@hotwired/stimulus';
import EmblaCarousel from 'embla-carousel';
import Autoplay from 'embla-carousel-autoplay';

export default class extends Controller {
    static targets = ['viewport', 'dot'];
    static values = {
        autoplayDelay: { type: Number, default: 6000 },
    };

    connect() {
        this.autoplay = Autoplay({ delay: this.autoplayDelayValue, stopOnInteraction: true });

        this.embla = EmblaCarousel(
            this.viewportTarget,
            { loop: true },
            [this.autoplay]
        );

        this.embla.on('select', () => this.updateDots());
        this.embla.on('init', () => this.updateDots());
    }

    disconnect() {
        this.embla?.destroy();
    }

    next() {
        this.autoplay.stop();
        this.embla.scrollNext();
    }

    prev() {
        this.autoplay.stop();
        this.embla.scrollPrev();
    }

    goTo(event) {
        const index = parseInt(event.params.index, 10);
        this.autoplay.stop();
        this.embla.scrollTo(index);
    }

    updateDots() {
        const selectedIndex = this.embla.selectedScrollSnap();

        this.dotTargets.forEach((dot, index) => {
            dot.classList.toggle('bg-navy-900', index === selectedIndex);
            dot.classList.toggle('bg-blue-300', index !== selectedIndex);
        });
    }
}