import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
  static values = { key: { type: String, default: "banner-dismissed" } }

  connect() {
    if (this.isDismissed()) {
      this.element.remove()
    } else {
      this.element.classList.remove("hidden")
    }
  }

  dismiss() {
    this.element.remove()
    try {
      localStorage.setItem(this.keyValue, "1")
    } catch (e) {
      // localStorage indisponible (navigation privée, etc.) : on masque quand même
    }
  }

  isDismissed() {
    try {
      return localStorage.getItem(this.keyValue) === "1"
    } catch (e) {
      return false
    }
  }
}