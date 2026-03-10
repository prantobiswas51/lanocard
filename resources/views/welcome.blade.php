<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <title>LanoCard — Safer Virtual Cards Worldwide | Virtual Card &amp; API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="LanoCard — Safer Virtual Cards Worldwide. Create one-time and reloadable virtual cards, pay online safely from any country. Open to everyone—individuals, freelancers, businesses. API for developers. Crypto and local payment options.">
    <meta name="keywords"
        content="LanoCard, safer virtual cards, virtual card worldwide, international virtual card, one-time card, reloadable card, virtual card API, secure payments worldwide, global virtual card, pay online internationally">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://lanocard.com/">
    <meta property="og:title" content="LanoCard — Safer Virtual Cards Worldwide">
    <meta property="og:description"
        content="LanoCard — Safer Virtual Cards Worldwide. Create virtual cards and pay online from anywhere. One-time and reloadable cards, API for developers.">
    <meta property="og:type" content="website">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: { 50: '#ecfdf5', 100: '#d1fae5', 500: '#10b981', 600: '#059669' }
          }
        }
      }
    }
    </script>
    <style>
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        .mobile-nav-open {
            transform: translateX(0);
        }

        .mobile-nav-closed {
            transform: translateX(100%);
        }

        @media (min-width: 768px) {
            .mobile-nav-panel {
                display: none !important;
            }
        }

        .hero-card {
            position: absolute;
            border-radius: 12px;
            pointer-events: none;
            opacity: 0.12;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: 12px;
            left: 14px;
            width: 28px;
            height: 22px;
            border-radius: 4px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.5) 0%, rgba(255, 255, 255, 0.2) 100%);
        }

        .hero-card .card-line {
            position: absolute;
            bottom: 24px;
            left: 14px;
            right: 14px;
            height: 6px;
            border-radius: 3px;
            background: rgba(0, 0, 0, 0.15);
        }

        .hero-card .card-dots {
            position: absolute;
            top: 50%;
            left: 14px;
            right: 14px;
            height: 4px;
            margin-top: -2px;
            background: repeating-linear-gradient(90deg, rgba(0, 0, 0, 0.2) 0, rgba(0, 0, 0, 0.2) 4px, transparent 4px, transparent 8px);
        }

        /* Animated design inside hero virtual card */
        .hero-virtual-card {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            background-color: #282F41;
        }

        .hero-virtual-card .card-animated-bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
            border-radius: inherit;
        }

        .hero-virtual-card .card-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.35;
            animation: card-glow-move 8s ease-in-out infinite;
        }

        .hero-virtual-card .card-glow-1 {
            width: 140px;
            height: 140px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.5) 0%, transparent 70%);
            top: -30%;
            left: -20%;
        }

        .hero-virtual-card .card-glow-2 {
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.4) 0%, transparent 70%);
            bottom: -20%;
            right: -15%;
            animation-delay: -4s;
        }

        .hero-virtual-card .card-shine {
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg,
                    transparent 0%,
                    transparent 40%,
                    rgba(255, 255, 255, 0.06) 50%,
                    transparent 60%,
                    transparent 100%);
            background-size: 200% 100%;
            animation: card-shine 4s ease-in-out infinite;
        }

        @keyframes card-glow-move {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(8px, -10px) scale(1.05);
            }

            66% {
                transform: translate(-5px, 8px) scale(0.95);
            }
        }

        @keyframes card-shine {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }
    </style>
    <style>
        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style:
        }

        /* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        ::after,
        ::before {
            --tw-content: ''
        }

        :host,
        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-feature-settings: normal;
            font-variation-settings: normal;
            -webkit-tap-highlight-color: transparent
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b,
        strong {
            font-weight: bolder
        }

        code,
        kbd,
        pre,
        samp {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-feature-settings: normal;
            font-variation-settings: normal;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-feature-settings: inherit;
            font-variation-settings: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            letter-spacing: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button,
        select {
            text-transform: none
        }

        button,
        input:where([type=button]),
        input:where([type=reset]),
        input:where([type=submit]) {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote,
        dd,
        dl,
        figure,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        p,
        pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        menu,
        ol,
        ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        dialog {
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        [role=button],
        button {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        audio,
        canvas,
        embed,
        iframe,
        img,
        object,
        svg,
        video {
            display: block;
            vertical-align: middle
        }

        img,
        video {
            max-width: 100%;
            height: auto
        }

        [hidden]:where(:not([hidden=until-found])) {
            display: none
        }

        .pointer-events-none {
            pointer-events: none
        }

        .fixed {
            position: fixed
        }

        .absolute {
            position: absolute
        }

        .relative {
            position: relative
        }

        .sticky {
            position: sticky
        }

        .inset-0 {
            inset: 0px
        }

        .bottom-\[12\%\] {
            bottom: 12%
        }

        .bottom-\[18\%\] {
            bottom: 18%
        }

        .bottom-\[25\%\] {
            bottom: 25%
        }

        .bottom-\[8\%\] {
            bottom: 8%
        }

        .left-1\/2 {
            left: 50%
        }

        .left-\[12\%\] {
            left: 12%
        }

        .left-\[15\%\] {
            left: 15%
        }

        .left-\[20\%\] {
            left: 20%
        }

        .left-\[25\%\] {
            left: 25%
        }

        .left-\[8\%\] {
            left: 8%
        }

        .right-0 {
            right: 0px
        }

        .right-\[10\%\] {
            right: 10%
        }

        .right-\[18\%\] {
            right: 18%
        }

        .right-\[25\%\] {
            right: 25%
        }

        .right-\[30\%\] {
            right: 30%
        }

        .right-\[6\%\] {
            right: 6%
        }

        .top-0 {
            top: 0px
        }

        .top-\[12\%\] {
            top: 12%
        }

        .top-\[15\%\] {
            top: 15%
        }

        .top-\[20\%\] {
            top: 20%
        }

        .top-\[35\%\] {
            top: 35%
        }

        .top-\[55\%\] {
            top: 55%
        }

        .top-\[58\%\] {
            top: 58%
        }

        .top-\[8\%\] {
            top: 8%
        }

        .z-10 {
            z-index: 10
        }

        .z-40 {
            z-index: 40
        }

        .z-50 {
            z-index: 50
        }

        .order-1 {
            order: 1
        }

        .order-2 {
            order: 2
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .mb-10 {
            margin-bottom: 2.5rem
        }

        .mb-12 {
            margin-bottom: 3rem
        }

        .mb-2 {
            margin-bottom: 0.5rem
        }

        .mb-3 {
            margin-bottom: 0.75rem
        }

        .mb-4 {
            margin-bottom: 1rem
        }

        .mb-6 {
            margin-bottom: 1.5rem
        }

        .mb-8 {
            margin-bottom: 2rem
        }

        .mt-0\.5 {
            margin-top: 0.125rem
        }

        .mt-1 {
            margin-top: 0.25rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .mt-6 {
            margin-top: 1.5rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .inline-block {
            display: inline-block
        }

        .flex {
            display: flex
        }

        .inline-flex {
            display: inline-flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .h-1\.5 {
            height: 0.375rem
        }

        .h-10 {
            height: 2.5rem
        }

        .h-14 {
            height: 3.5rem
        }

        .h-16 {
            height: 4rem
        }

        .h-20 {
            height: 5rem
        }

        .h-4 {
            height: 1rem
        }

        .h-5 {
            height: 1.25rem
        }

        .h-6 {
            height: 1.5rem
        }

        .h-7 {
            height: 1.75rem
        }

        .h-8 {
            height: 2rem
        }

        .h-9 {
            height: 2.25rem
        }

        .h-full {
            height: 100%
        }

        .w-1\.5 {
            width: 0.375rem
        }

        .w-10 {
            width: 2.5rem
        }

        .w-12 {
            width: 3rem
        }

        .w-24 {
            width: 6rem
        }

        .w-28 {
            width: 7rem
        }

        .w-32 {
            width: 8rem
        }

        .w-36 {
            width: 9rem
        }

        .w-4 {
            width: 1rem
        }

        .w-5 {
            width: 1.25rem
        }

        .w-6 {
            width: 1.5rem
        }

        .w-72 {
            width: 18rem
        }

        .w-8 {
            width: 2rem
        }

        .w-9 {
            width: 2.25rem
        }

        .w-full {
            width: 100%
        }

        .min-w-\[280px\] {
            min-width: 280px
        }

        .max-w-2xl {
            max-width: 42rem
        }

        .max-w-3xl {
            max-width: 48rem
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .max-w-\[320px\] {
            max-width: 320px
        }

        .max-w-\[85vw\] {
            max-width: 85vw
        }

        .flex-shrink-0 {
            flex-shrink: 0
        }

        .-translate-x-1\/2 {
            --tw-translate-x: -50%;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        .flex-col {
            flex-direction: column
        }

        .flex-wrap {
            flex-wrap: wrap
        }

        .items-start {
            align-items: flex-start
        }

        .items-end {
            align-items: flex-end
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .justify-between {
            justify-content: space-between
        }

        .gap-1 {
            gap: 0.25rem
        }

        .gap-1\.5 {
            gap: 0.375rem
        }

        .gap-10 {
            gap: 2.5rem
        }

        .gap-2 {
            gap: 0.5rem
        }

        .gap-3 {
            gap: 0.75rem
        }

        .gap-4 {
            gap: 1rem
        }

        .gap-6 {
            gap: 1.5rem
        }

        .space-y-2> :not([hidden])~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.5rem * var(--tw-space-y-reverse))
        }

        .space-y-5> :not([hidden])~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(1.25rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(1.25rem * var(--tw-space-y-reverse))
        }

        .overflow-hidden {
            overflow: hidden
        }

        .scroll-smooth {
            scroll-behavior: smooth
        }

        .rounded {
            border-radius: 0.25rem
        }

        .rounded-2xl {
            border-radius: 1rem
        }

        .rounded-full {
            border-radius: 9999px
        }

        .rounded-lg {
            border-radius: 0.5rem
        }

        .rounded-md {
            border-radius: 0.375rem
        }

        .rounded-xl {
            border-radius: 0.75rem
        }

        .border {
            border-width: 1px
        }

        .border-2 {
            border-width: 2px
        }

        .border-b {
            border-bottom-width: 1px
        }

        .border-l {
            border-left-width: 1px
        }

        .border-t {
            border-top-width: 1px
        }

        .border-emerald-300\/30 {
            border-color: rgb(110 231 183 / 0.3)
        }

        .border-slate-100 {
            --tw-border-opacity: 1;
            border-color: rgb(241 245 249 / var(--tw-border-opacity, 1))
        }

        .border-slate-200 {
            --tw-border-opacity: 1;
            border-color: rgb(226 232 240 / var(--tw-border-opacity, 1))
        }

        .border-slate-300 {
            --tw-border-opacity: 1;
            border-color: rgb(203 213 225 / var(--tw-border-opacity, 1))
        }

        .border-slate-300\/25 {
            border-color: rgb(203 213 225 / 0.25)
        }

        .border-white\/10 {
            border-color: rgb(255 255 255 / 0.1)
        }

        .bg-emerald-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(209 250 229 / var(--tw-bg-opacity, 1))
        }

        .bg-emerald-200\/25 {
            background-color: rgb(167 243 208 / 0.25)
        }

        .bg-emerald-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(236 253 245 / var(--tw-bg-opacity, 1))
        }

        .bg-emerald-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(16 185 129 / var(--tw-bg-opacity, 1))
        }

        .bg-sky-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(224 242 254 / var(--tw-bg-opacity, 1))
        }

        .bg-sky-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(14 165 233 / var(--tw-bg-opacity, 1))
        }

        .bg-slate-300\/20 {
            background-color: rgb(203 213 225 / 0.2)
        }

        .bg-slate-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(248 250 252 / var(--tw-bg-opacity, 1))
        }

        .bg-slate-50\/50 {
            background-color: rgb(248 250 252 / 0.5)
        }

        .bg-slate-900\/20 {
            background-color: rgb(15 23 42 / 0.2)
        }

        .bg-transparent {
            background-color: transparent
        }

        .bg-violet-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(237 233 254 / var(--tw-bg-opacity, 1))
        }

        .bg-violet-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(139 92 246 / var(--tw-bg-opacity, 1))
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1))
        }

        .bg-white\/90 {
            background-color: rgb(255 255 255 / 0.9)
        }

        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops))
        }

        .from-emerald-300 {
            --tw-gradient-from: #6ee7b7 var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(110 231 183 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-emerald-400 {
            --tw-gradient-from: #34d399 var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(52 211 153 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-emerald-50 {
            --tw-gradient-from: #ecfdf5 var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(236 253 245 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-emerald-50\/80 {
            --tw-gradient-from: rgb(236 253 245 / 0.8) var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(236 253 245 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-emerald-500 {
            --tw-gradient-from: #10b981 var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(16 185 129 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-sky-500 {
            --tw-gradient-from: #0ea5e9 var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(14 165 233 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-slate-500 {
            --tw-gradient-from: #64748b var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(100 116 139 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-slate-600 {
            --tw-gradient-from: #475569 var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(71 85 105 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-teal-400 {
            --tw-gradient-from: #2dd4bf var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(45 212 191 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .via-white {
            --tw-gradient-to: rgb(255 255 255 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), #fff var(--tw-gradient-via-position), var(--tw-gradient-to)
        }

        .to-cyan-500 {
            --tw-gradient-to: #06b6d4 var(--tw-gradient-to-position)
        }

        .to-emerald-600 {
            --tw-gradient-to: #059669 var(--tw-gradient-to-position)
        }

        .to-indigo-500 {
            --tw-gradient-to: #6366f1 var(--tw-gradient-to-position)
        }

        .to-sky-400 {
            --tw-gradient-to: #38bdf8 var(--tw-gradient-to-position)
        }

        .to-sky-50 {
            --tw-gradient-to: #f0f9ff var(--tw-gradient-to-position)
        }

        .to-sky-50\/80 {
            --tw-gradient-to: rgb(240 249 255 / 0.8) var(--tw-gradient-to-position)
        }

        .to-slate-700 {
            --tw-gradient-to: #334155 var(--tw-gradient-to-position)
        }

        .to-slate-800 {
            --tw-gradient-to: #1e293b var(--tw-gradient-to-position)
        }

        .to-teal-600 {
            --tw-gradient-to: #0d9488 var(--tw-gradient-to-position)
        }

        .p-2 {
            padding: 0.5rem
        }

        .p-4 {
            padding: 1rem
        }

        .p-5 {
            padding: 1.25rem
        }

        .p-6 {
            padding: 1.5rem
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem
        }

        .px-5 {
            padding-left: 1.25rem;
            padding-right: 1.25rem
        }

        .py-1\.5 {
            padding-top: 0.375rem;
            padding-bottom: 0.375rem
        }

        .py-10 {
            padding-top: 2.5rem;
            padding-bottom: 2.5rem
        }

        .py-16 {
            padding-top: 4rem;
            padding-bottom: 4rem
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem
        }

        .py-2\.5 {
            padding-top: 0.625rem;
            padding-bottom: 0.625rem
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .pt-1 {
            padding-top: 0.25rem
        }

        .pt-4 {
            padding-top: 1rem
        }

        .text-left {
            text-align: left
        }

        .text-center {
            text-align: center
        }

        .font-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem
        }

        .text-\[10px\] {
            font-size: 10px
        }

        .text-base {
            font-size: 1rem;
            line-height: 1.5rem
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem
        }

        .font-bold {
            font-weight: 700
        }

        .font-medium {
            font-weight: 500
        }

        .font-semibold {
            font-weight: 600
        }

        .uppercase {
            text-transform: uppercase
        }

        .tracking-\[0\.2em\] {
            letter-spacing: 0.2em
        }

        .tracking-tight {
            letter-spacing: -0.025em
        }

        .tracking-wide {
            letter-spacing: 0.025em
        }

        .tracking-wider {
            letter-spacing: 0.05em
        }

        .text-\[\#1e3a5f\] {
            --tw-text-opacity: 1;
            color: rgb(30 58 95 / var(--tw-text-opacity, 1))
        }

        .text-\[\#22c55e\] {
            --tw-text-opacity: 1;
            color: rgb(34 197 94 / var(--tw-text-opacity, 1))
        }

        .text-emerald-500 {
            --tw-text-opacity: 1;
            color: rgb(16 185 129 / var(--tw-text-opacity, 1))
        }

        .text-emerald-600 {
            --tw-text-opacity: 1;
            color: rgb(5 150 105 / var(--tw-text-opacity, 1))
        }

        .text-sky-600 {
            --tw-text-opacity: 1;
            color: rgb(2 132 199 / var(--tw-text-opacity, 1))
        }

        .text-slate-500 {
            --tw-text-opacity: 1;
            color: rgb(100 116 139 / var(--tw-text-opacity, 1))
        }

        .text-slate-600 {
            --tw-text-opacity: 1;
            color: rgb(71 85 105 / var(--tw-text-opacity, 1))
        }

        .text-slate-700 {
            --tw-text-opacity: 1;
            color: rgb(51 65 85 / var(--tw-text-opacity, 1))
        }

        .text-slate-800 {
            --tw-text-opacity: 1;
            color: rgb(30 41 59 / var(--tw-text-opacity, 1))
        }

        .text-slate-900 {
            --tw-text-opacity: 1;
            color: rgb(15 23 42 / var(--tw-text-opacity, 1))
        }

        .text-violet-500 {
            --tw-text-opacity: 1;
            color: rgb(139 92 246 / var(--tw-text-opacity, 1))
        }

        .text-violet-600 {
            --tw-text-opacity: 1;
            color: rgb(124 58 237 / var(--tw-text-opacity, 1))
        }

        .text-white {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity, 1))
        }

        .text-white\/70 {
            color: rgb(255 255 255 / 0.7)
        }

        .text-white\/90 {
            color: rgb(255 255 255 / 0.9)
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .opacity-0 {
            opacity: 0
        }

        .shadow-\[0_10px_40px_rgba\(0\2c 0\2c 0\2c 0\.15\)\] {
            --tw-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            --tw-shadow-colored: 0 10px 40px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .shadow-md {
            --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .shadow-sm {
            --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .shadow-xl {
            --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .backdrop-blur {
            --tw-backdrop-blur: blur(8px);
            -webkit-backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);
            backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)
        }

        .backdrop-blur-sm {
            --tw-backdrop-blur: blur(4px);
            -webkit-backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);
            backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)
        }

        .transition {
            transition-property: color, background-color, border-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-text-decoration-color, -webkit-backdrop-filter;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-text-decoration-color, -webkit-backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .transition-opacity {
            transition-property: opacity;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .transition-transform {
            transition-property: transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .duration-200 {
            transition-duration: 200ms
        }

        .ease-out {
            transition-timing-function: cubic-bezier(0, 0, 0.2, 1)
        }

        .hover\:border-emerald-100:hover {
            --tw-border-opacity: 1;
            border-color: rgb(209 250 229 / var(--tw-border-opacity, 1))
        }

        .hover\:border-emerald-200:hover {
            --tw-border-opacity: 1;
            border-color: rgb(167 243 208 / var(--tw-border-opacity, 1))
        }

        .hover\:border-emerald-300:hover {
            --tw-border-opacity: 1;
            border-color: rgb(110 231 183 / var(--tw-border-opacity, 1))
        }

        .hover\:border-sky-100:hover {
            --tw-border-opacity: 1;
            border-color: rgb(224 242 254 / var(--tw-border-opacity, 1))
        }

        .hover\:border-slate-400:hover {
            --tw-border-opacity: 1;
            border-color: rgb(148 163 184 / var(--tw-border-opacity, 1))
        }

        .hover\:border-violet-100:hover {
            --tw-border-opacity: 1;
            border-color: rgb(237 233 254 / var(--tw-border-opacity, 1))
        }

        .hover\:bg-emerald-50:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(236 253 245 / var(--tw-bg-opacity, 1))
        }

        .hover\:bg-emerald-50\/50:hover {
            background-color: rgb(236 253 245 / 0.5)
        }

        .hover\:bg-emerald-600:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(5 150 105 / var(--tw-bg-opacity, 1))
        }

        .hover\:bg-sky-600:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(2 132 199 / var(--tw-bg-opacity, 1))
        }

        .hover\:bg-slate-100:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(241 245 249 / var(--tw-bg-opacity, 1))
        }

        .hover\:bg-slate-50:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(248 250 252 / var(--tw-bg-opacity, 1))
        }

        .hover\:bg-violet-600:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(124 58 237 / var(--tw-bg-opacity, 1))
        }

        .hover\:text-emerald-600:hover {
            --tw-text-opacity: 1;
            color: rgb(5 150 105 / var(--tw-text-opacity, 1))
        }

        .hover\:shadow-md:hover {
            --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .hover\:shadow-sm:hover {
            --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        @media (min-width: 640px) {
            .sm\:h-20 {
                height: 5rem
            }

            .sm\:h-24 {
                height: 6rem
            }

            .sm\:h-28 {
                height: 7rem
            }

            .sm\:w-28 {
                width: 7rem
            }

            .sm\:w-32 {
                width: 8rem
            }

            .sm\:w-36 {
                width: 9rem
            }

            .sm\:w-40 {
                width: 10rem
            }

            .sm\:w-44 {
                width: 11rem
            }

            .sm\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .sm\:flex-row {
                flex-direction: row
            }

            .sm\:p-5 {
                padding: 1.25rem
            }

            .sm\:p-8 {
                padding: 2rem
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:py-20 {
                padding-top: 5rem;
                padding-bottom: 5rem
            }

            .sm\:py-24 {
                padding-top: 6rem;
                padding-bottom: 6rem
            }

            .sm\:text-2xl {
                font-size: 1.5rem;
                line-height: 2rem
            }

            .sm\:text-3xl {
                font-size: 1.875rem;
                line-height: 2.25rem
            }

            .sm\:text-4xl {
                font-size: 2.25rem;
                line-height: 2.5rem
            }

            .sm\:text-base {
                font-size: 1rem;
                line-height: 1.5rem
            }

            .sm\:text-xs {
                font-size: 0.75rem;
                line-height: 1rem
            }
        }

        @media (min-width: 768px) {
            .md\:flex {
                display: flex
            }

            .md\:hidden {
                display: none
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .md\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr))
            }

            .md\:text-3xl {
                font-size: 1.875rem;
                line-height: 2.25rem
            }

            .md\:text-5xl {
                font-size: 3rem;
                line-height: 1
            }
        }

        @media (min-width: 1024px) {
            .lg\:order-1 {
                order: 1
            }

            .lg\:order-2 {
                order: 2
            }

            .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr))
            }

            .lg\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr))
            }

            .lg\:grid-cols-5 {
                grid-template-columns: repeat(5, minmax(0, 1fr))
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased">
    <!-- Header -->
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
            <a href="index.html" class="flex items-center gap-3 text-slate-800">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                    <svg class="w-full h-full" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <rect width="40" height="40" rx="8" fill="url(#lanocard-grad-header)"></rect>
                        <path d="M10 10v20h16v-4H14V10H10z" fill="white"></path>
                        <circle cx="30" cy="10" r="2.5" fill="white" opacity="0.9"></circle>
                        <defs>
                            <linearGradient id="lanocard-grad-header" x1="0" y1="0" x2="40" y2="0"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#1e3a5f"></stop>
                                <stop offset="1" stop-color="#22c55e"></stop>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <span class="text-sm font-bold tracking-tight"><span class="text-[#1e3a5f]">Lano</span><span
                        class="text-[#22c55e]">Card</span></span>
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="index.html" class="text-emerald-600 font-medium">Home</a>
                <a href="virtual-card.html" class="text-slate-600 hover:text-emerald-600">Virtual Card</a>
                <a href="how-it-works.html" class="text-slate-600 hover:text-emerald-600">How it works</a>
                <a href="security.html" class="text-slate-600 hover:text-emerald-600">Security</a>
                <a href="pricing.html" class="text-slate-600 hover:text-emerald-600">Pricing</a>
                <a href="faq.html" class="text-slate-600 hover:text-emerald-600">FAQ</a>
                <a href="api-documentation.html" class="text-slate-600 hover:text-emerald-600">API Docs</a>
            </nav>
            <div class="hidden md:flex items-center gap-2">
                @auth
                <a href="{{ route('dashboard') }}" class="px-3 py-1.5 text-sm font-medium text-slate-700 hover:text-emerald-600">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="px-3 py-1.5 text-sm font-medium text-slate-700 hover:text-emerald-600">Log
                    in</a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 rounded-full bg-emerald-500 text-white text-sm font-semibold hover:bg-emerald-600 shadow-sm">Sign
                    up</a>
                @endauth
            </div>
            <button type="button" id="mobileMenuBtn"
                class="md:hidden p-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 aria-label="
                open="" menu"="">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <!-- Mobile nav overlay + panel -->
        <div id="mobileNavOverlay"
            class="mobile-nav-panel fixed inset-0 z-50 bg-slate-900/20 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-200 md:hidden"
            aria-hidden="true"></div>
        <div id="mobileNavPanel"
            class="mobile-nav-panel mobile-nav-closed fixed top-0 right-0 z-50 w-72 max-w-[85vw] h-full bg-white border-l border-slate-200 shadow-xl transition-transform duration-200 ease-out md:hidden">
            <div class="flex items-center justify-between px-4 py-4 border-b border-slate-100">
                <span class="font-semibold text-slate-900">Menu</span>
                <button type="button" id="mobileMenuClose" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100"
                    aria-label="Close menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="p-4 flex flex-col gap-1 text-sm">
                <a href="index.html" class="rounded-lg px-3 py-2.5 text-emerald-600 font-medium bg-emerald-50">Home</a>
                <a href="virtual-card.html" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">Virtual
                    Card</a>
                <a href="how-it-works.html" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">How it
                    works</a>
                <a href="security.html" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">Security</a>
                <a href="pricing.html" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">Pricing</a>
                <a href="faq.html" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">FAQ</a>
                <a href="api-documentation.html" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">API
                    Docs</a>
                <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col gap-2">
                    <a href="login.html"
                        class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50 text-center font-medium">Log
                        in</a>
                    <a href="register.html"
                        class="rounded-full bg-emerald-500 text-white px-4 py-2.5 text-center font-semibold hover:bg-emerald-600">Sign
                        up</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/80 via-white to-sky-50/80"></div>
        <!-- Background: watermark-style cards (code-only, no images) -->
        <div class="hero-card absolute left-[8%] top-[15%] w-32 sm:w-40 h-20 sm:h-24 bg-gradient-to-br from-emerald-400 to-cyan-500"
            style="transform: rotate(-12deg);"><span class="card-line"></span></div>
        <div class="hero-card absolute left-[12%] top-[55%] w-28 sm:w-36 h-20 sm:h-24 bg-gradient-to-br from-slate-600 to-slate-800"
            style="transform: rotate(8deg);"><span class="card-line"></span></div>
        <div class="hero-card absolute right-[10%] top-[20%] w-36 sm:w-44 h-22 sm:h-28 bg-gradient-to-br from-emerald-500 to-teal-600"
            style="transform: rotate(6deg);"><span class="card-dots"></span><span class="card-line"></span></div>
        <div class="hero-card absolute right-[6%] top-[58%] w-28 sm:w-36 h-20 sm:h-24 bg-gradient-to-br from-sky-500 to-indigo-500"
            style="transform: rotate(-8deg);"></div>
        <div class="hero-card absolute left-1/2 -translate-x-1/2 top-[8%] w-24 sm:w-28 h-14 sm:h-18 bg-gradient-to-br from-emerald-300 to-sky-400"
            style="transform: rotate(-3deg); opacity: 0.08;"></div>
        <div class="hero-card absolute right-[25%] bottom-[12%] w-24 sm:w-32 h-16 sm:h-20 bg-gradient-to-br from-slate-500 to-slate-700"
            style="transform: rotate(10deg);"></div>
        <div class="hero-card absolute left-[25%] bottom-[18%] w-28 sm:w-36 h-16 sm:h-20 bg-gradient-to-br from-teal-400 to-emerald-600"
            style="transform: rotate(-5deg);"></div>
        <!-- Subtle payment/card icons (CSS only) -->
        <div class="absolute right-[18%] top-[12%] w-10 h-10 rounded-full border-2 border-emerald-300/30"
            style="transform: rotate(15deg);"></div>
        <div class="absolute left-[20%] bottom-[25%] w-8 h-8 rounded-lg bg-slate-300/20"
            style="transform: rotate(-10deg);"></div>
        <div class="absolute left-[15%] top-[35%] w-12 h-8 rounded border border-slate-300/25"
            style="transform: rotate(-6deg);"></div>
        <div class="absolute right-[30%] bottom-[8%] w-9 h-9 rounded-full bg-emerald-200/25"
            style="transform: rotate(8deg);"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-16 sm:py-24 text-center">
            <span
                class="inline-block rounded-full border border-slate-300 bg-white/90 px-4 py-1.5 text-xs font-medium text-slate-700 shadow-sm mb-6">Safer
                virtual cards &amp; API — open to everyone, worldwide</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 mb-2 max-w-3xl mx-auto">
                LanoCard — Safer Virtual Cards Worldwide
            </h1>
            <h2 class="text-xl sm:text-2xl md:text-3xl font-semibold text-slate-600 mb-6 max-w-2xl mx-auto">
                Create one-time or reloadable virtual cards. Pay online safely from any country. For individuals,
                freelancers, SaaS, and businesses—no borders.
            </h2>
            <p class="text-slate-600 text-lg max-w-2xl mx-auto mb-8">
                LanoCard gives you virtual cards and an API to pay online safely from anywhere. Fund with crypto or
                local methods. Full control—freeze, top‑up, or close cards anytime.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3 mb-12">
                <a href="api-documentation.html"
                    class="inline-flex items-center gap-2 rounded-lg bg-sky-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-sky-600">Start
                    with API</a>
                <a href="register.html"
                    class="inline-flex items-center gap-2 rounded-lg border-2 border-slate-300 bg-transparent px-5 py-2.5 text-sm font-semibold text-slate-800 hover:border-slate-400 hover:bg-slate-50">Book
                    a demo</a>
            </div>
            <!-- Virtual card illustration (screenshot style – matches user panel card) -->
            <div
                class="hero-virtual-card inline-block rounded-2xl text-left min-w-[280px] max-w-[320px] shadow-[0_10px_40px_rgba(0,0,0,0.15)]">
                <div class="card-animated-bg">
                    <div class="card-glow card-glow-1"></div>
                    <div class="card-glow card-glow-2"></div>
                    <div class="card-shine"></div>
                </div>
                <div class="relative z-10 p-4 sm:p-5 space-y-5">
                    <div class="flex items-start justify-between gap-2">
                        <div class="w-9 h-7 rounded-md flex-shrink-0"
                            style="background: linear-gradient(135deg, #d4af37 0%, #b8960c 100%);"></div>
                        <span
                            class="text-[10px] sm:text-xs font-bold tracking-wide text-white uppercase">LanoCard</span>
                    </div>
                    <p class="font-mono text-white text-sm sm:text-base tracking-[0.2em]">• • • • • • • • • • • • 4242
                    </p>
                    <div class="flex items-end justify-between pt-1 border-t border-white/10">
                        <span
                            class="text-[10px] sm:text-xs font-semibold tracking-wider text-white/90">VIRTUALPAY</span>
                        <span class="text-[10px] sm:text-xs font-medium tracking-wider text-white/70">VIRTUAL</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 sm:py-20 border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 text-center mb-12">Why LanoCard</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md hover:border-emerald-100 transition">
                    <div
                        class="h-10 w-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                        💳</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">One‑time &amp; reloadable cards</h3>
                    <p class="text-slate-600 text-sm">Create virtual cards for single use or top‑up anytime. Available
                        for international users. Choose BIN and amount. 3D Secure OTP via email for reloadable cards.
                    </p>
                </div>
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md hover:border-sky-100 transition">
                    <div class="h-10 w-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center mb-4">🔐
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Freeze &amp; control</h3>
                    <p class="text-slate-600 text-sm">Freeze or close your LanoCard virtual cards instantly from
                        anywhere. Top‑up from balance with a small fee. Full transaction and notification history.</p>
                </div>
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md hover:border-violet-100 transition">
                    <div
                        class="h-10 w-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center mb-4">
                        ⚡</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">API for developers</h3>
                    <p class="text-slate-600 text-sm">Integrate LanoCard virtual card creation and management via API.
                        Clear documentation, code samples, and API plans for developers worldwide.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Card payments content -->
    <section class="py-16 sm:py-20 bg-white border-t border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Secure virtual card payments for
                        everyone, worldwide</h2>
                    <p class="text-slate-600 mb-4">LanoCard virtual cards work like regular payment cards for online
                        payments—available to international users in any country. Use them for subscriptions, free
                        trials, e‑commerce, ads, and one‑off purchases without exposing your main bank or personal card.
                    </p>
                    <p class="text-slate-600 mb-4">Choose one‑time cards for a single merchant or reloadable LanoCard
                        cards for ongoing use. Each card has its own number, expiry, and CVV. Payments are processed
                        securely and you get instant notifications for every transaction.</p>
                    <ul class="space-y-2 text-slate-600 text-sm">
                        <li class="flex items-center gap-2"><span
                                class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Online card payments with real
                            card credentials</li>
                        <li class="flex items-center gap-2"><span
                                class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> One‑time and reloadable card
                            options</li>
                        <li class="flex items-center gap-2"><span
                                class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Transaction history and
                            notifications</li>
                    </ul>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-emerald-50 to-sky-50 p-6 sm:p-8">
                    <p class="text-xs uppercase tracking-wider text-emerald-600 font-semibold mb-2">Card payments</p>
                    <h3 class="text-lg font-semibold text-slate-900 mb-3">Use LanoCard virtual cards anywhere cards are
                        accepted</h3>
                    <p class="text-slate-600 text-sm">Pay for Netflix, Amazon, Meta ads, Google ads, SaaS trials, and
                        more—from any country. Set a fixed amount per card so you never overspend. All payments show up
                        in your dashboard with full details.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Keep your card safe / LanoCard benefits -->
    <section class="py-16 sm:py-20 border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 text-center mb-4">Keep your cards safe with
                LanoCard</h2>
            <p class="text-slate-600 text-center max-w-2xl mx-auto mb-12">LanoCard puts you in control. Your main bank
                and personal card stay safe; only the virtual card is used for payments. Available for users worldwide.
            </p>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-base font-semibold text-slate-900 mb-2">Freeze anytime</h3>
                    <p class="text-slate-600 text-sm">Suspend a card with one click. No new card payments go through
                        until you unfreeze. Perfect when you suspect misuse or want to pause a subscription.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-base font-semibold text-slate-900 mb-2">Spend limits</h3>
                    <p class="text-slate-600 text-sm">Set the exact amount when you create a card. One‑time cards can’t
                        be charged more than that. Reloadable cards have a limit you choose—so you keep your card safe
                        from overcharging.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-base font-semibold text-slate-900 mb-2">3D Secure &amp; OTP</h3>
                    <p class="text-slate-600 text-sm">Reloadable LanoCard virtual cards support 3D Secure. OTP is sent
                        to your email so only you can complete sensitive payments. Extra layer to keep your card safe.
                    </p>
                </div>
            </div>
            <p class="mt-8 text-center text-slate-600 text-sm max-w-2xl mx-auto">Using LanoCard is simple: create a
                virtual card, fund your balance with crypto or local payment methods, and pay online from anywhere. Full
                transaction history and close cards anytime. Open to international users.</p>
        </div>
    </section>

    <!-- API – build your own business -->
    <section class="py-16 sm:py-20 bg-white border-t border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div class="order-2 lg:order-1 rounded-2xl border border-slate-200 bg-slate-50 p-6 sm:p-8">
                    <p class="text-xs uppercase tracking-wider text-violet-600 font-semibold mb-2">API access</p>
                    <h3 class="text-xl font-semibold text-slate-900 mb-3">Purchase API and build your own card business
                    </h3>
                    <p class="text-slate-600 text-sm mb-4">Get LanoCard API access to create, manage, and issue virtual
                        cards programmatically. Build your own SaaS, reseller platform, or internal tool on top of our
                        card infrastructure. Available globally.</p>
                    <ul class="space-y-2 text-slate-600 text-sm">
                        <li class="flex items-center gap-2"><span class="text-violet-500">✓</span> Create and manage
                            cards via API</li>
                        <li class="flex items-center gap-2"><span class="text-violet-500">✓</span> Integrate card
                            payments into your product</li>
                        <li class="flex items-center gap-2"><span class="text-violet-500">✓</span> Full documentation
                            and code examples</li>
                    </ul>
                </div>
                <div class="order-1 lg:order-2">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Build your own business with LanoCard
                        API</h2>
                    <p class="text-slate-600 mb-4">LanoCard API lets you offer virtual card payments to your users or
                        automate card creation for your business. Purchase API access once and use it to power your
                        platform—whether you run a fintech app, subscription service, or agency. Open to developers and
                        businesses worldwide.</p>
                    <p class="text-slate-600 mb-6">You get a dedicated API key, clear documentation, and endpoints for
                        creating one‑time and reloadable cards, freezing, top‑up, and more. No need to build card
                        infrastructure from scratch; focus on your product and let LanoCard handle payments and
                        security.</p>
                    <a href="pricing.html#api"
                        class="inline-flex items-center gap-2 rounded-full bg-violet-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-violet-600">View
                        API pricing</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Use cases -->
    <section class="py-16 sm:py-20 border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 text-center mb-12">Use LanoCard virtual cards for
            </h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div
                    class="rounded-xl border border-slate-200 bg-white px-4 py-4 text-center hover:border-emerald-200 hover:shadow-sm transition">
                    <p class="font-semibold text-slate-900">Subscriptions</p>
                    <p class="text-xs text-slate-500 mt-0.5">Netflix, Spotify, SaaS</p>
                </div>
                <div
                    class="rounded-xl border border-slate-200 bg-white px-4 py-4 text-center hover:border-emerald-200 hover:shadow-sm transition">
                    <p class="font-semibold text-slate-900">Free trials</p>
                    <p class="text-xs text-slate-500 mt-0.5">One‑time card, no surprise charges</p>
                </div>
                <div
                    class="rounded-xl border border-slate-200 bg-white px-4 py-4 text-center hover:border-emerald-200 hover:shadow-sm transition">
                    <p class="font-semibold text-slate-900">Ads &amp; marketing</p>
                    <p class="text-xs text-slate-500 mt-0.5">Meta, Google, paid campaigns</p>
                </div>
                <div
                    class="rounded-xl border border-slate-200 bg-white px-4 py-4 text-center hover:border-emerald-200 hover:shadow-sm transition">
                    <p class="font-semibold text-slate-900">E‑commerce</p>
                    <p class="text-xs text-slate-500 mt-0.5">Online shopping, marketplaces</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SEO / Explore pages – all in one place -->
    <section class="py-16 sm:py-20 bg-white border-t border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 text-center mb-4">Explore LanoCard</h2>
            <p class="text-slate-600 text-center max-w-2xl mx-auto mb-10">Learn more about virtual cards, how it works,
                security, pricing, and common questions. All pages in one place.</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <a href="virtual-card.html"
                    class="flex flex-col rounded-xl border border-slate-200 bg-slate-50/50 p-5 hover:border-emerald-200 hover:bg-emerald-50/50 hover:shadow-sm transition text-center">
                    <span class="text-2xl mb-2">💳</span>
                    <span class="font-semibold text-slate-900">Virtual Card</span>
                    <span class="text-xs text-slate-500 mt-1">What it is &amp; use cases</span>
                </a>
                <a href="how-it-works.html"
                    class="flex flex-col rounded-xl border border-slate-200 bg-slate-50/50 p-5 hover:border-emerald-200 hover:bg-emerald-50/50 hover:shadow-sm transition text-center">
                    <span class="text-2xl mb-2">🔄</span>
                    <span class="font-semibold text-slate-900">How it works</span>
                    <span class="text-xs text-slate-500 mt-1">Sign up to pay in 4 steps</span>
                </a>
                <a href="security.html"
                    class="flex flex-col rounded-xl border border-slate-200 bg-slate-50/50 p-5 hover:border-emerald-200 hover:bg-emerald-50/50 hover:shadow-sm transition text-center">
                    <span class="text-2xl mb-2">🔐</span>
                    <span class="font-semibold text-slate-900">Security</span>
                    <span class="text-xs text-slate-500 mt-1">How we keep you safe</span>
                </a>
                <a href="pricing.html"
                    class="flex flex-col rounded-xl border border-slate-200 bg-slate-50/50 p-5 hover:border-emerald-200 hover:bg-emerald-50/50 hover:shadow-sm transition text-center">
                    <span class="text-2xl mb-2">💰</span>
                    <span class="font-semibold text-slate-900">Pricing</span>
                    <span class="text-xs text-slate-500 mt-1">Fees &amp; API plans</span>
                </a>
                <a href="faq.html"
                    class="flex flex-col rounded-xl border border-slate-200 bg-slate-50/50 p-5 hover:border-emerald-200 hover:bg-emerald-50/50 hover:shadow-sm transition text-center">
                    <span class="text-2xl mb-2">❓</span>
                    <span class="font-semibold text-slate-900">FAQ</span>
                    <span class="text-xs text-slate-500 mt-1">Common questions</span>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-2xl font-bold text-slate-900 mb-3">Ready to get started?</h2>
            <p class="text-slate-600 mb-6">Sign up free—open to everyone, worldwide. Create an account and fund your
                balance with crypto or local payment methods. No long forms.</p>
            <a href="register.html"
                class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-emerald-600">Sign
                up free</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-slate-50 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-slate-800">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                        <svg class="w-full h-full" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <rect width="40" height="40" rx="8" fill="url(#lanocard-grad-footer)"></rect>
                            <path d="M10 10v20h16v-4H14V10H10z" fill="white"></path>
                            <circle cx="30" cy="10" r="2.5" fill="white" opacity="0.9"></circle>
                            <defs>
                                <linearGradient id="lanocard-grad-footer" x1="0" y1="0" x2="40" y2="0"
                                    gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#1e3a5f"></stop>
                                    <stop offset="1" stop-color="#22c55e"></stop>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <span class="text-sm font-bold tracking-tight"><span class="text-[#1e3a5f]">Lano</span><span
                            class="text-[#22c55e]">Card</span></span>
                </div>
                <nav class="flex flex-wrap items-center justify-center gap-4 text-sm text-slate-600">
                    <a href="index.html" class="hover:text-emerald-600">Home</a>
                    <a href="virtual-card.html" class="hover:text-emerald-600">Virtual Card</a>
                    <a href="how-it-works.html" class="hover:text-emerald-600">How it works</a>
                    <a href="security.html" class="hover:text-emerald-600">Security</a>
                    <a href="pricing.html" class="hover:text-emerald-600">Pricing</a>
                    <a href="faq.html" class="hover:text-emerald-600">FAQ</a>
                    <a href="api-documentation.html" class="hover:text-emerald-600">API Docs</a>
                    <a href="privacy-policy.html" class="hover:text-emerald-600">Privacy</a>
                    <a href="terms-and-conditions.html" class="hover:text-emerald-600">Terms</a>
                    <a href="login.html" class="hover:text-emerald-600">Log in</a>
                    <a href="register.html" class="hover:text-emerald-600">Sign up</a>
                    <a href="https://www.trustpilot.com/review/virtualcardglobal.com" target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-slate-700 hover:border-emerald-300 hover:text-emerald-600 hover:bg-emerald-50 transition">
                        <svg class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                            </path>
                        </svg>
                        Reviews
                    </a>
                </nav>
            </div>
            <p class="mt-6 text-center text-xs text-slate-500">© LanoCard. Safer virtual cards worldwide. All rights
                reserved.</p>
        </div>
    </footer>

    <script>
        (function() {
      var btn = document.getElementById('mobileMenuBtn');
      var closeBtn = document.getElementById('mobileMenuClose');
      var overlay = document.getElementById('mobileNavOverlay');
      var panel = document.getElementById('mobileNavPanel');
      function openNav() {
        if (overlay) { overlay.classList.remove('opacity-0', 'pointer-events-none'); overlay.classList.add('opacity-100'); overlay.setAttribute('aria-hidden', 'false'); }
        if (panel) { panel.classList.remove('mobile-nav-closed'); panel.classList.add('mobile-nav-open'); }
        document.body.style.overflow = 'hidden';
      }
      function closeNav() {
        if (overlay) { overlay.classList.add('opacity-0', 'pointer-events-none'); overlay.classList.remove('opacity-100'); overlay.setAttribute('aria-hidden', 'true'); }
        if (panel) { panel.classList.add('mobile-nav-closed'); panel.classList.remove('mobile-nav-open'); }
        document.body.style.overflow = '';
      }
      if (btn) btn.addEventListener('click', openNav);
      if (closeBtn) closeBtn.addEventListener('click', closeNav);
      if (overlay) overlay.addEventListener('click', closeNav);
    })();
    </script>


</body>

</html>