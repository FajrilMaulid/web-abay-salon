/**
 * Salon Cantik - Public JS
 */
document.addEventListener("DOMContentLoaded", () => {
    // ─── NAVBAR SCROLL EFFECT ───────────────────────
    const navbar = document.querySelector(".navbar");
    if (navbar) {
        window.addEventListener(
            "scroll",
            () => {
                navbar.classList.toggle("scrolled", window.scrollY > 50);
            },
            { passive: true },
        );
    }

    // ─── HAMBURGER MENU ─────────────────────────────
    const hamburger = document.getElementById("hamburger");
    const navLinks = document.getElementById("navLinks");
    if (hamburger && navLinks) {
        hamburger.addEventListener("click", () => {
            hamburger.classList.toggle("open");
            navLinks.classList.toggle("open");
        });
        // Close on nav link click
        navLinks.querySelectorAll(".nav-link").forEach((link) => {
            link.addEventListener("click", () => {
                hamburger.classList.remove("open");
                navLinks.classList.remove("open");
            });
        });
    }

    // ─── SCROLL REVEAL ──────────────────────────────
    const revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                }
            });
        },
        { threshold: 0.1, rootMargin: "0px 0px -40px 0px" },
    );

    document
        .querySelectorAll(".reveal")
        .forEach((el) => revealObserver.observe(el));

    // ─── FLOATING PARTICLES ─────────────────────────
    const particleContainer = document.querySelector(".hero-particles");
    if (particleContainer) {
        const colors = ["#E91E63", "#9C27B0", "#FF6B9D", "#CE93D8"];
        for (let i = 0; i < 18; i++) {
            const p = document.createElement("div");
            p.className = "particle";
            const size = Math.random() * 8 + 3;
            p.style.cssText = `
                width: ${size}px; height: ${size}px;
                background: ${colors[Math.floor(Math.random() * colors.length)]};
                left: ${Math.random() * 100}%;
                animation-duration: ${Math.random() * 15 + 8}s;
                animation-delay: ${Math.random() * -15}s;
            `;
            particleContainer.appendChild(p);
        }
    }

    // ─── SMOOTH SCROLL FOR ANCHORS ──────────────────
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        });
    });

    // ─── BOOKING FORM: MULTI-STEP ───────────────────
    const TOTAL_STEPS = 4;
    let currentStep = 1;
    const steps = document.querySelectorAll(".form-step");
    const stepIndicators = document.querySelectorAll(".step-item");

    function goToStep(n) {
        if (n < 1 || n > TOTAL_STEPS) return;
        steps.forEach((s, i) => s.classList.toggle("active", i + 1 === n));
        stepIndicators.forEach((ind, i) => {
            ind.classList.remove("active", "done");
            if (i + 1 === n) ind.classList.add("active");
            if (i + 1 < n) ind.classList.add("done");
        });
        currentStep = n;
        window.scrollTo({
            top: document.querySelector(".booking-container")?.offsetTop - 80,
            behavior: "smooth",
        });
    }

    document.querySelectorAll(".btn-next").forEach((btn) => {
        btn.addEventListener("click", () => {
            if (validateStep(currentStep)) goToStep(currentStep + 1);
        });
    });
    document.querySelectorAll(".btn-prev").forEach((btn) => {
        btn.addEventListener("click", () => goToStep(currentStep - 1));
    });

    function validateStep(step) {
        const fields = document.querySelectorAll(
            `.form-step:nth-child(${step}) [required]`,
        );
        let valid = true;
        fields.forEach((f) => {
            f.classList.remove("is-invalid");
            if (!f.value.trim()) {
                f.classList.add("is-invalid");
                valid = false;
            }
        });
        // Radio groups
        if (step === 2) {
            const svc = document.querySelector(
                'input[name="service_id"]:checked',
            );
            if (!svc) {
                showPublicToast("Pilih layanan terlebih dahulu.", "error");
                valid = false;
            }
        }
        if (step === 3) {
            const time = document.getElementById("booking_time");
            if (!time?.value) {
                showPublicToast("Pilih jam terlebih dahulu.", "error");
                valid = false;
            }
        }
        return valid;
    }

    // ─── TIME SLOTS ─────────────────────────────────
    function initTimeSlots() {
        const slotBtns = document.querySelectorAll(".time-slot");
        const timeInput = document.getElementById("booking_time");
        slotBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                slotBtns.forEach((b) => b.classList.remove("selected"));
                btn.classList.add("selected");
                if (timeInput) timeInput.value = btn.dataset.value;
                updateSummary();
            });
        });
    }

    // ─── ORDER SUMMARY SYNC ─────────────────────────
    function updateSummary() {
        // Service
        const checkedSvc = document.querySelector(
            'input[name="service_id"]:checked',
        );
        if (checkedSvc) {
            const card = checkedSvc.closest(".service-select-card");
            document.getElementById("sum-service")?.textContent &&
                (document.getElementById("sum-service").textContent =
                    card?.querySelector("strong")?.textContent || "-");
            document.getElementById("sum-price")?.textContent &&
                (document.getElementById("sum-price").textContent =
                    card?.querySelector(".price")?.textContent || "-");
        }
        // Date & time
        const date = document.getElementById("booking_date");
        const time = document.getElementById("booking_time");
        if (date?.value) {
            const d = new Date(date.value);
            const opts = {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
            };
            document.getElementById("sum-date") &&
                (document.getElementById("sum-date").textContent =
                    d.toLocaleDateString("id-ID", opts));
        }
        if (time?.value)
            document.getElementById("sum-time") &&
                (document.getElementById("sum-time").textContent =
                    time.value + " WIB");
        // Payment
        const pay = document.querySelector(
            'input[name="payment_method"]:checked',
        );
        if (pay)
            document.getElementById("sum-payment") &&
                (document.getElementById("sum-payment").textContent =
                    pay.value.charAt(0).toUpperCase() + pay.value.slice(1));
        // Customer name
        const name = document.getElementById("customer_name");
        if (name?.value)
            document.getElementById("sum-customer") &&
                (document.getElementById("sum-customer").textContent =
                    name.value);
    }

    // Listen for changes to update summary
    document
        .querySelectorAll('input[name="service_id"]')
        .forEach((r) => r.addEventListener("change", updateSummary));
    document
        .getElementById("booking_date")
        ?.addEventListener("change", updateSummary);
    document
        .getElementById("booking_time")
        ?.addEventListener("change", updateSummary);
    document
        .querySelectorAll('input[name="payment_method"]')
        .forEach((r) => r.addEventListener("change", updateSummary));
    document
        .getElementById("customer_name")
        ?.addEventListener("input", updateSummary);

    initTimeSlots();
    updateSummary();

    // ─── AUTO-DISMISS ALERTS ────────────────────────
    document.querySelectorAll(".alert-banner").forEach((el) => {
        setTimeout(() => (el.style.opacity = "0"), 4000);
        setTimeout(() => el.remove(), 4500);
    });
});

function showPublicToast(msg, type) {
    const t = document.createElement("div");
    t.className = `toast toast-${type}`;
    t.style.cssText =
        "position:fixed;bottom:24px;right:24px;z-index:9999;padding:14px 20px;background:#1A1A2E;border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:#F1F5F9;font-family:Poppins,sans-serif;font-size:0.85rem;max-width:280px;box-shadow:0 8px 32px rgba(0,0,0,0.4);";
    if (type === "error") t.style.borderLeft = "3px solid #EF4444";
    if (type === "success") t.style.borderLeft = "3px solid #22C55E";
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => {
        t.style.opacity = "0";
        setTimeout(() => t.remove(), 300);
    }, 3000);
}
