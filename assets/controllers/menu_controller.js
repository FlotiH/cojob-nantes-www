import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['panel', 'openIcon', 'closeIcon', 'button'];

    connect() {
        this.close();
    }

    toggle() {
        const isOpen = this.buttonTarget.getAttribute('aria-expanded') === 'true';
        isOpen ? this.close() : this.open();
    }

    open() {
        this.panelTarget.classList.remove('hidden');
        this.openIconTarget.classList.add('hidden');
        this.closeIconTarget.classList.remove('hidden');
        this.buttonTarget.setAttribute('aria-expanded', 'true');
    }

    close() {
        this.panelTarget.classList.add('hidden');
        this.openIconTarget.classList.remove('hidden');
        this.closeIconTarget.classList.add('hidden');
        this.buttonTarget.setAttribute('aria-expanded', 'false');
    }

    closeOnClickOutside(event) {
        if (!this.element.contains(event.target)) {
            this.close();
        }
    }
}