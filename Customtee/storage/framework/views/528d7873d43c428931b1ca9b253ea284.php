

<style>
/* ============================================
   MOTION TOKENS (CSS Custom Properties)
   ============================================ */
:root {
    /* Duration */
    --motion-fast: 200ms;
    --motion-normal: 350ms;
    --motion-slow: 500ms;
    --motion-entrance: 600ms;

    /* Easing */
    --ease-out-expo: cubic-bezier(0.16, 1, 0.3, 1);
    --ease-out-quart: cubic-bezier(0.25, 1, 0.5, 1);
    --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);

    /* Stagger */
    --stagger-step: 80ms;

    /* Distance */
    --reveal-distance: 24px;
    --slide-distance: 40px;
}

/* ============================================
   @KEYFRAMES
   ============================================ */
@keyframes motionFadeUp {
    from { opacity: 0; transform: translateY(var(--reveal-distance)); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes motionFadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
}

@keyframes motionScaleIn {
    from { opacity: 0; transform: scale(0.95); }
    to   { opacity: 1; transform: scale(1); }
}

@keyframes motionSlideInLeft {
    from { opacity: 0; transform: translateX(calc(-1 * var(--slide-distance))); }
    to   { opacity: 1; transform: translateX(0); }
}

@keyframes motionSlideInRight {
    from { opacity: 0; transform: translateX(var(--slide-distance)); }
    to   { opacity: 1; transform: translateX(0); }
}

@keyframes pulseRing {
    0%   { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.45); }
    70%  { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
    100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

@keyframes gentleBounce {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-6px); }
}

@keyframes pressDown {
    0%   { transform: scale(1); }
    50%  { transform: scale(0.97); }
    100% { transform: scale(1); }
}

@keyframes cartSuccessFlash {
    0%   { background-color: #0f172a; transform: scale(1); }
    40%  { background-color: #059669; transform: scale(1.03); }
    100% { background-color: #0f172a; transform: scale(1); }
}

@keyframes chipPopIn {
    from { opacity: 0; transform: scale(0.8); }
    to   { opacity: 1; transform: scale(1); }
}

/* ============================================
   SCROLL-REVEAL SYSTEM
   ============================================ */

/* Initial hidden state */
.reveal {
    opacity: 0;
    will-change: opacity, transform;
    transition: opacity var(--motion-entrance) var(--ease-out-expo),
                transform var(--motion-entrance) var(--ease-out-expo);
}

/* Default: fade up */
.reveal:not(.reveal-fade):not(.reveal-scale):not(.reveal-left):not(.reveal-right) {
    transform: translateY(var(--reveal-distance));
}

/* Variants */
.reveal.reveal-fade {
    transform: none;
}
.reveal.reveal-scale {
    transform: scale(0.95);
}
.reveal.reveal-left {
    transform: translateX(calc(-1 * var(--slide-distance)));
}
.reveal.reveal-right {
    transform: translateX(var(--slide-distance));
}

/* Revealed state — all variants converge here */
.reveal.is-revealed {
    opacity: 1;
    transform: translateY(0) translateX(0) scale(1);
}

/* Stagger delays (applied alongside .reveal) */
.stagger-1 { transition-delay: calc(1 * var(--stagger-step)); }
.stagger-2 { transition-delay: calc(2 * var(--stagger-step)); }
.stagger-3 { transition-delay: calc(3 * var(--stagger-step)); }
.stagger-4 { transition-delay: calc(4 * var(--stagger-step)); }
.stagger-5 { transition-delay: calc(5 * var(--stagger-step)); }
.stagger-6 { transition-delay: calc(6 * var(--stagger-step)); }
.stagger-7 { transition-delay: calc(7 * var(--stagger-step)); }
.stagger-8 { transition-delay: calc(8 * var(--stagger-step)); }

/* ============================================
   HERO ENTRANCE SEQUENCE (auto-play on load)
   ============================================ */
.hero-entrance {
    opacity: 0;
    transform: translateY(20px);
    animation: motionFadeUp var(--motion-entrance) var(--ease-out-expo) forwards;
}
.hero-entrance-1 { animation-delay: 0ms; }
.hero-entrance-2 { animation-delay: 150ms; }
.hero-entrance-3 { animation-delay: 300ms; }
.hero-entrance-media {
    opacity: 0;
    transform: scale(0.96);
    animation: motionScaleIn var(--motion-entrance) var(--ease-out-quart) forwards;
    animation-delay: 200ms;
}

/* ============================================
   PRODUCT INFO ENTRANCE (auto-play on load)
   ============================================ */
.info-entrance {
    opacity: 0;
    transform: translateY(16px);
    animation: motionFadeUp var(--motion-slow) var(--ease-out-quart) forwards;
}
.info-entrance-1 { animation-delay: 100ms; }
.info-entrance-2 { animation-delay: 200ms; }
.info-entrance-3 { animation-delay: 300ms; }
.info-entrance-4 { animation-delay: 400ms; }
.info-entrance-5 { animation-delay: 500ms; }
.info-entrance-6 { animation-delay: 600ms; }
.info-entrance-7 { animation-delay: 700ms; }

.gallery-entrance {
    opacity: 0;
    transform: scale(0.96);
    animation: motionScaleIn var(--motion-entrance) var(--ease-out-quart) forwards;
    animation-delay: 50ms;
}

/* ============================================
   MICRO-INTERACTIONS
   ============================================ */

/* Stock Pulse Dot — infinite radar ring */
.stock-pulse-dot {
    position: relative;
}
.stock-pulse-dot::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    border-radius: 50%;
    animation: pulseRing 2s var(--ease-out-quart) infinite;
}

/* Button Press Feedback */
.btn-primary-dark:active:not(:disabled),
.btn-secondary-outline:active:not(:disabled) {
    animation: pressDown var(--motion-fast) var(--ease-out-expo);
}

/* Stepper Button Press */
.stepper-btn:active {
    animation: pressDown 150ms var(--ease-out-expo);
}

/* Cart Success Flash — added via JS temporarily */
.cart-success-flash {
    animation: cartSuccessFlash 500ms var(--ease-out-expo) !important;
}

/* AI Chat Toggle Gentle Bounce — added via JS after delay */
.ai-chat-toggle-bounce {
    animation: gentleBounce 3s ease-in-out infinite;
}

/* Active Filter Chip Pop-in */
.chip-pop-in {
    animation: chipPopIn var(--motion-fast) var(--ease-spring);
}

/* Tab content smooth fade enhancement */
.tab-pane.fade {
    transition: opacity var(--motion-normal) var(--ease-out-expo);
}

/* ============================================
   ACCESSIBILITY: prefers-reduced-motion
   ============================================ */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        animation-delay: 0ms !important;
        transition-delay: 0ms !important;
    }

    .reveal {
        opacity: 1 !important;
        transform: none !important;
    }

    .hero-entrance,
    .hero-entrance-media,
    .info-entrance,
    .gallery-entrance {
        opacity: 1 !important;
        transform: none !important;
    }
}
</style>

<script>
/**
 * Motion Design System — Scroll Reveal & Micro-Interaction Controller
 */
(function() {
    'use strict';

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /**
     * Initialize IntersectionObserver for all .reveal elements
     * @param {Element|null} container - Scope to search within (default: document)
     */
    function initRevealObserver(container) {
        var scope = container || document;

        if (prefersReducedMotion) {
            scope.querySelectorAll('.reveal:not(.is-revealed)').forEach(function(el) {
                el.classList.add('is-revealed');
            });
            return;
        }

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -60px 0px'
        });

        scope.querySelectorAll('.reveal:not(.is-revealed)').forEach(function(el) {
            observer.observe(el);
        });
    }

    /**
     * Immediately reveal elements with staggered delay (for AJAX-loaded content)
     * @param {Element|null} container
     * @param {string} selector - CSS selector for elements to reveal
     * @param {number} baseDelay - Initial delay before first item (ms)
     * @param {number} stepDelay - Delay between each item (ms)
     */
    function staggerRevealImmediate(container, selector, baseDelay, stepDelay) {
        var scope = container || document;
        var items = scope.querySelectorAll(selector);

        if (prefersReducedMotion) {
            items.forEach(function(el) { el.classList.add('is-revealed'); });
            return;
        }

        items.forEach(function(item, index) {
            setTimeout(function() {
                item.classList.add('is-revealed');
            }, (baseDelay || 50) + (index * (stepDelay || 60)));
        });
    }

    /**
     * Cart success flash — call after successful add-to-cart
     * @param {Element} buttonEl - The button element to flash
     */
    function triggerCartSuccessFlash(buttonEl) {
        if (!buttonEl || prefersReducedMotion) return;
        buttonEl.classList.add('cart-success-flash');
        buttonEl.addEventListener('animationend', function() {
            buttonEl.classList.remove('cart-success-flash');
        }, { once: true });
    }

    /**
     * AI Chat toggle gentle bounce — start after delay
     */
    function initChatBounce() {
        var chatToggle = document.getElementById('aiChatToggle');
        if (chatToggle && !prefersReducedMotion) {
            setTimeout(function() {
                chatToggle.classList.add('ai-chat-toggle-bounce');
            }, 5000);
            chatToggle.addEventListener('click', function() {
                chatToggle.classList.remove('ai-chat-toggle-bounce');
            }, { once: true });
        }
    }

    /* Expose globally */
    window.MotionSystem = {
        initRevealObserver: initRevealObserver,
        staggerRevealImmediate: staggerRevealImmediate,
        triggerCartSuccessFlash: triggerCartSuccessFlash,
        prefersReducedMotion: prefersReducedMotion
    };

    /* Auto-init on DOMContentLoaded */
    document.addEventListener('DOMContentLoaded', function() {
        initRevealObserver();
        initChatBounce();
    });
})();
</script>
<?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\client\layout\motion-system.blade.php ENDPATH**/ ?>