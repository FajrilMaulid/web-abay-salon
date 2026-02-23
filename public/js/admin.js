/**
 * Salon Cantik - Admin JS
 */
document.addEventListener("DOMContentLoaded", () => {
    // ─── SIDEBAR TOGGLE ─────────────────────────────
    const sidebar = document.getElementById("sidebar");
    const sidebarOverlay = document.getElementById("sidebarOverlay");
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebarClose = document.getElementById("sidebarClose");

    function openSidebar() {
        sidebar?.classList.add("open");
        sidebarOverlay?.classList.add("open");
    }
    function closeSidebar() {
        sidebar?.classList.remove("open");
        sidebarOverlay?.classList.remove("open");
    }

    sidebarToggle?.addEventListener("click", openSidebar);
    sidebarClose?.addEventListener("click", closeSidebar);
    sidebarOverlay?.addEventListener("click", closeSidebar);

    // ─── TOAST FUNCTION (GLOBAL) ────────────────────
    window.showAdminToast = function (msg, type = "success") {
        const t = document.createElement("div");
        t.className = `toast toast-${type}`;
        t.innerHTML = `<i class="fas fa-${type === "success" ? "check-circle" : type === "warning" ? "exclamation-triangle" : "times-circle"}"></i> ${msg}`;
        document.body.appendChild(t);
        requestAnimationFrame(() => t.classList.add("show"));
        setTimeout(() => {
            t.classList.remove("show");
            setTimeout(() => t.remove(), 400);
        }, 3500);
    };

    // ─── AUTO-DISMISS ALERTS ────────────────────────
    document.querySelectorAll("#alertSuccess, #alertError").forEach((el) => {
        setTimeout(() => {
            el.style.opacity = "0";
            setTimeout(() => el.remove(), 500);
        }, 5000);
    });

    // ─── CONFIRM DELETES ────────────────────────────
    document.querySelectorAll("[data-confirm]").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            if (!confirm(btn.dataset.confirm || "Apakah Anda yakin?"))
                e.preventDefault();
        });
    });

    // ─── TABLE ROW HIGHLIGHT ────────────────────────
    document.querySelectorAll(".admin-table tbody tr").forEach((row) => {
        row.addEventListener(
            "mouseenter",
            () => (row.style.background = "rgba(255,255,255,0.03)"),
        );
        row.addEventListener("mouseleave", () => (row.style.background = ""));
    });

    // ─── FORM VALIDATION ────────────────────────────
    document.querySelectorAll(".admin-form").forEach((form) => {
        form.addEventListener("submit", function (e) {
            const required = this.querySelectorAll("[required]");
            let valid = true;
            required.forEach((f) => {
                f.classList.remove("is-invalid");
                if (!f.value.trim()) {
                    f.classList.add("is-invalid");
                    valid = false;
                }
            });
            if (!valid) {
                e.preventDefault();
                showAdminToast(
                    "Mohon lengkapi semua field yang wajib diisi.",
                    "error",
                );
            }
        });
    });

    // ─── PREVIEW IMAGE ON UPLOAD ────────────────────
    const imgInput = document.getElementById("image");
    if (imgInput) {
        imgInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    let preview = document.getElementById("imagePreview");
                    if (!preview) {
                        preview = document.createElement("div");
                        preview.id = "imagePreview";
                        preview.style.cssText = "margin-top:10px;";
                        imgInput.closest(".form-group").appendChild(preview);
                    }
                    preview.innerHTML = `<img src="${e.target.result}" style="width:100px;height:75px;object-fit:cover;border-radius:8px;border:1px solid rgba(255,255,255,0.1);" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // ─── PERIOD SELECTION - EXPORT ──────────────────
    document.querySelectorAll(".period-option input").forEach((radio) => {
        radio.addEventListener("change", () => {
            document
                .querySelectorAll(".period-card")
                .forEach((c) => (c.style.borderColor = ""));
            radio.previousElementSibling;
        });
    });

    // ─── KEYBOARD SHORTCUTS ─────────────────────────
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeSidebar();
    });
});
