import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        target: Number
    };

    connect() {
        this.hasAnimated = false;
        this.element.textContent = `0 %`;

        this.observer = new IntersectionObserver(
            (entries) => this.onIntersect(entries),
            { threshold: 0.4 } // throw when 40% of the element is visible
        );
        this.observer.observe(this.element);
    }

    disconnect() {
        this.observer?.disconnect();
        if (this.frameId) {
            cancelAnimationFrame(this.frameId);
        }
    }

    onIntersect(entries) {
        const entry = entries[0];

        if (entry.isIntersecting && !this.hasAnimated) {
            this.hasAnimated = true;
            this.animate();
            this.observer.disconnect(); // animation iw played only one time
        }
    }

    animate() {
        const startTime = performance.now();
        const to = this.targetValue;

        const step = (now) => {
            const progress = Math.min((now - startTime) / 4000, 1);

            const eased = 1 - Math.pow(1 - progress, 3);
            const value = Math.round(0 + to * eased);

            this.element.textContent = `${value} %`;

            if (progress < 1) {
                this.frameId = requestAnimationFrame(step);
            }
        };

        this.frameId = requestAnimationFrame(step);
    }
}