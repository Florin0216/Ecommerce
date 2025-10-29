class ToastService {
    show(message, type, duration = 3000) {
        let toastContainer = document.getElementById("toast-container");

        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.id = "toast-container";
            toastContainer.className =
                "fixed bottom-4 right-4 flex flex-col gap-2 z-50";
            document.body.appendChild(toastContainer);
        }

        const toastEl = document.createElement("div");
        toastEl.className = `
      flex items-center justify-between max-w-xs w-full px-4 py-3 rounded shadow-lg text-white
      ${type === "success" ? "bg-green-500" : type === "error" ? "bg-red-500" : "bg-gray-500"}
      transform transition-transform duration-300
    `;

        toastEl.innerHTML = `
          <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 ${
                type === "success"
                    ? "fill-current text-white"
                    : type === "error"
                        ? "fill-current text-white"
                        : "fill-current text-white"
            }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              ${
                type === "success"
                    ? '<path d="M9 16.17l-3.59-3.58L4 14l5 5 12-12-1.41-1.42z"/>'
                    : type === "error"
                        ? '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>'
                        : '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>'
            }
            </svg>
            <span>${message}</span>
          </div>
          <button class="ml-4 text-white font-bold" aria-label="Close">&times;</button>`;

        toastContainer.appendChild(toastEl);

        toastEl.querySelector("button").addEventListener("click", () => {
            toastEl.remove();
        });

        setTimeout(() => {
            toastEl.classList.add("opacity-0", "translate-x-2");
            setTimeout(() => toastEl.remove(), 500);
        }, duration);
    }
}

export default new ToastService();
