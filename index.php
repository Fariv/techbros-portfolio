<?php
declare(strict_types=1);

$pageTitle = 'TechBros | Engineering Studio & Digital Product Labs';
$pageDescription = 'High-conviction software engineering studio building production web platforms, Flutter mobile apps, and high-concurrency cloud systems for global startups.';
$canonicalUrl = 'https://portfolio.techbros.co.za/';
$ogImage = 'https://portfolio.techbros.co.za/images/collaborating.jpg';
$currentYear = date('Y');
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Favicon & Touch Icons -->
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">

  <!-- Primary Meta Tags -->
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
  <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">

  <!-- Open Graph / Facebook / LinkedIn / WhatsApp -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') ?>">

  <!-- Twitter / X -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="twitter:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') ?>">

  <!-- Schema.org Structured Data for Google Rich Snippets -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ProfessionalService",
    "name": "TechBros",
    "url": "https://portfolio.techbros.co.za/",
    "logo": "https://portfolio.techbros.co.za/images/techbros-icon-512.png",
    "image": "https://portfolio.techbros.co.za/images/collaborating.jpg",
    "description": "<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>",
    "email": "techbros@techbros.co.za",
    "knowsAbout": [
      "Custom Web Applications",
      "Laravel",
      "Next.js",
      "Flutter Mobile Development",
      "High-Concurrency Async PHP",
      "OpenSwoole",
      "Cloud Infrastructure & CI/CD"
    ],
    "priceRange": "$$"
  }
  </script>

  <!-- Tailwind CSS Engine -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#eff6ff',
              100: '#dbeafe',
              200: '#bfdbfe',
              300: '#93c5fd',
              400: '#38bdf8',
              500: '#0084ff',
              600: '#006fe6',
              700: '#0057b8',
              800: '#0a2554',
              900: '#081a36'
            }
          }
        }
      }
    };
  </script>

  <!-- Prevent Theme Flash -->
  <script>
    (function() {
      const savedTheme = localStorage.getItem('techbros_theme');
      if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        document.documentElement.classList.remove('light');
      } else {
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
      }
    })();
  </script>

  <style>
    /* Smooth theme transitions */
    * {
      transition: background-color 0.2s ease, border-color 0.2s ease, color 0.15s ease, box-shadow 0.2s ease;
    }

    /* Day Mode Canvas (Inspired by Mahfuz Miah's clean agency shots) */
    html:not(.dark) body {
      background-color: #f8f9fc;
      color: #101828;
    }
    html.dark body {
      background-color: #07090e;
      color: #f1f5f9;
    }

    .tracking-tight-title {
      letter-spacing: -0.035em;
    }

    /* Day Mode Bento Card Styling */
    html:not(.dark) .bento-card {
      background: #ffffff;
      border: 1px solid #eaecf0;
      box-shadow: 0 1px 3px 0 rgba(16, 24, 40, 0.04), 0 1px 2px -1px rgba(16, 24, 40, 0.02);
    }
    html:not(.dark) .bento-card:hover {
      border-color: #0084ff;
      box-shadow: 0 12px 28px -4px rgba(16, 24, 40, 0.08), 0 4px 12px -2px rgba(0, 132, 255, 0.12);
      transform: translateY(-2px);
    }

    /* Dark Mode Bento Card Styling */
    html.dark .bento-card {
      background: #0d111a;
      border: 1px solid rgba(255, 255, 255, 0.07);
    }
    html.dark .bento-card:hover {
      border-color: rgba(0, 245, 212, 0.4);
      box-shadow: 0 12px 30px -8px rgba(0, 132, 255, 0.2);
      transform: translateY(-2px);
    }

    /* Subtle Architectural Dot Grid */
    html:not(.dark) .dot-grid {
      background-image: radial-gradient(#d0d5dd 1px, transparent 1px);
      background-size: 28px 28px;
    }
    html.dark .dot-grid {
      background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
      background-size: 28px 28px;
    }

    .chip-active {
      background-color: #0084ff !important;
      color: #ffffff !important;
      border-color: #0084ff !important;
      box-shadow: 0 4px 12px rgba(0, 132, 255, 0.25) !important;
    }

    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }
    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>
<body class="min-h-screen font-sans antialiased selection:bg-brand-500 selection:text-white pb-24">

  <!-- Header / Navigation Bar -->
  <header class="sticky top-0 z-40 dark:bg-[#07090e]/85 bg-white/85 backdrop-blur-md border-b dark:border-slate-800/80 border-[#eaecf0] px-6 py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
      
      <!-- Logo -->
      <a href="#" class="flex items-center gap-3 group">
        <div class="w-10 h-10 rounded-xl dark:bg-slate-900 bg-white border dark:border-slate-800 border-slate-200/90 shadow-sm flex items-center justify-center p-1.5 group-hover:scale-105 group-hover:border-brand-500 transition-all">
          <img src="images/techbros-logo.png" alt="TechBros Monogram Logo" class="w-full h-full object-contain" width="40" height="40">
        </div>
        <div>
          <span class="font-extrabold text-lg tracking-tight dark:text-white text-slate-900 block leading-tight">TechBros</span>
          <span class="text-[10px] font-mono font-bold tracking-widest text-brand-600 dark:text-brand-400 uppercase">Studio & Labs</span>
        </div>
      </a>

      <!-- Navigation Links -->
      <nav class="hidden md:flex items-center gap-8 text-sm font-semibold dark:text-slate-300 text-slate-600">
        <a href="#services" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Services</a>
        <a href="#work" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Selected Work</a>
        <a href="#why" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Philosophy</a>
      </nav>

      <!-- Right Controls: Theme Switcher & CTA -->
      <div class="flex items-center gap-3">
        <!-- Theme Toggle Button -->
        <button onclick="toggleTheme()" aria-label="Toggle visual theme" class="flex items-center gap-2 px-3 py-1.5 rounded-full dark:bg-slate-800 bg-[#f2f4f7] border dark:border-slate-700 border-[#d0d5dd] text-xs font-semibold dark:text-slate-200 text-slate-700 hover:scale-105 active:scale-95 transition-all shadow-sm">
          <span id="theme-icon">🌙</span>
          <span id="theme-label" class="hidden sm:inline">Dark Mode</span>
        </button>

        <a href="#contact" class="px-5 py-2.5 rounded-full bg-brand-600 hover:bg-brand-700 dark:bg-brand-500 dark:hover:bg-brand-400 text-white dark:text-slate-950 font-bold text-xs tracking-wide hover:opacity-95 shadow-md shadow-brand-500/20 transition-all">
          Start Project ➔
        </a>
      </div>

    </div>
  </header>

  <!-- Hero Section -->
  <section class="dot-grid border-b dark:border-slate-800/80 border-[#eaecf0]">
    <div class="max-w-6xl mx-auto px-6 pt-20 pb-20 text-center">
      
      <!-- Status Badge -->
      <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full dark:bg-slate-900 bg-white border dark:border-slate-800 border-[#d0d5dd] text-xs font-mono font-semibold dark:text-cyan-400 text-brand-600 shadow-sm mb-8">
        <span class="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-pulse"></span>
        Available for Q4 & 2027 Engineering Sprints
      </div>

      <!-- Main Headline -->
      <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight-title dark:text-white text-slate-900 max-w-4xl mx-auto leading-[1.08] mb-6">
        We build scalable software with 
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-cyan-500 dark:from-brand-400 dark:to-cyan-400">engineering rigor</span> and speed.
      </h1>

      <!-- Subtitle -->
      <p class="text-base sm:text-xl dark:text-slate-400 text-slate-600 max-w-2xl mx-auto mb-10 leading-relaxed font-normal">
        Senior full-stack engineering studio specializing in bespoke web platforms, Flutter mobile apps, and high-concurrency systems. Built for founders and startups worldwide.
      </p>

      <!-- CTA Row -->
      <div class="flex flex-wrap items-center justify-center gap-3.5 mb-16">
        <a href="#work" class="px-7 py-3.5 rounded-full bg-brand-600 hover:bg-brand-700 dark:bg-brand-500 dark:hover:bg-brand-400 text-white dark:text-slate-950 font-bold text-sm transition-all shadow-lg shadow-brand-600/20 dark:shadow-brand-500/20 flex items-center gap-2">
          <span>Explore Selected Work</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </a>
        <a href="#contact" class="px-7 py-3.5 rounded-full dark:bg-slate-900 bg-white border dark:border-slate-800 border-[#d0d5dd] dark:text-slate-200 text-slate-800 font-semibold text-sm hover:border-slate-400 transition-all shadow-sm">
          Schedule Technical Scoping ➔
        </a>
      </div>

      <!-- Trust Metrics (Mahfuz Miah Inspired Floating Cards) -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto text-left">
        <div class="bento-card p-5 rounded-2xl">
          <div class="text-3xl font-extrabold dark:text-white text-slate-900 tracking-tight-title mb-1">100%</div>
          <div class="text-xs dark:text-slate-400 text-slate-500 font-medium">Sprint Delivery Record</div>
        </div>
        <div class="bento-card p-5 rounded-2xl">
          <div class="text-3xl font-extrabold text-brand-600 dark:text-cyan-400 tracking-tight-title mb-1">&lt;0.2s</div>
          <div class="text-xs dark:text-slate-400 text-slate-500 font-medium">TTFB / Initial Render</div>
        </div>
        <div class="bento-card p-5 rounded-2xl">
          <div class="text-3xl font-extrabold dark:text-white text-slate-900 tracking-tight-title mb-1">Global</div>
          <div class="text-xs dark:text-slate-400 text-slate-500 font-medium">US, UK, EU & KSA Clients</div>
        </div>
        <div class="bento-card p-5 rounded-2xl">
          <div class="text-3xl font-extrabold dark:text-white text-slate-900 tracking-tight-title mb-1">Direct</div>
          <div class="text-xs dark:text-slate-400 text-slate-500 font-medium">Senior Engineer Access</div>
        </div>
      </div>

    </div>
  </section>

  <!-- Section 01: Core Capabilities (Bento Grid) -->
  <section id="services" class="max-w-6xl mx-auto px-6 py-20">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
      <div>
        <span class="text-xs font-mono font-bold tracking-widest text-brand-600 dark:text-brand-400 uppercase block mb-2">01 / Capabilities</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold dark:text-white text-slate-900 tracking-tight-title">Full-Lifecycle Product Engineering</h2>
      </div>
      <p class="text-sm dark:text-slate-400 text-slate-600 max-w-md leading-relaxed">
        We handle architecture, code implementation, and production deployment with no intermediaries or bloated account managers.
      </p>
    </div>

    <!-- Asymmetric Bento Grid -->
    <div class="grid md:grid-cols-3 gap-6">
      
      <!-- Card 1: Web Platforms (Wide) -->
      <div class="bento-card md:col-span-2 p-8 md:p-10 rounded-3xl flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-6">
            <span class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-brand-50 dark:bg-brand-500/10 text-brand-700 dark:text-brand-400 border border-brand-200 dark:border-brand-500/20">
              WEB PLATFORMS & SAAS
            </span>
            <span class="text-xs text-slate-400 font-mono">01</span>
          </div>
          <h3 class="text-2xl font-bold dark:text-white text-slate-900 mb-3">Custom Web Application Engineering</h3>
          <p class="dark:text-slate-400 text-slate-600 text-sm leading-relaxed mb-6 max-w-xl">
            Scalable multi-tenant web applications, admin portals, and custom SaaS platforms built with PHP 8.5, Laravel, Next.js, and TypeScript. Designed for high conversion, clean database schemas, and enterprise security.
          </p>
        </div>
        <div class="flex flex-wrap gap-2 pt-6 border-t dark:border-slate-800/80 border-[#f2f4f7] text-xs font-mono dark:text-slate-300 text-slate-600">
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">PHP 8.5 / Laravel</span>
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">React / Next.js</span>
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">PostgreSQL / MySQL</span>
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">Tailwind CSS</span>
        </div>
      </div>

      <!-- Card 2: Mobile Apps (Compact) -->
      <div class="bento-card p-8 md:p-10 rounded-3xl flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-6">
            <span class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-sky-50 dark:bg-cyan-500/10 text-sky-700 dark:text-cyan-400 border border-sky-200 dark:border-cyan-500/20">
              CROSS-PLATFORM MOBILE
            </span>
            <span class="text-xs text-slate-400 font-mono">02</span>
          </div>
          <h3 class="text-2xl font-bold dark:text-white text-slate-900 mb-3">Flutter iOS & Android</h3>
          <p class="dark:text-slate-400 text-slate-600 text-sm leading-relaxed mb-6">
            Production-grade mobile apps with 60fps animations, offline-first data caching, and native camera/sensor integrations published directly to stores.
          </p>
        </div>
        <div class="flex flex-wrap gap-2 pt-6 border-t dark:border-slate-800/80 border-[#f2f4f7] text-xs font-mono dark:text-slate-300 text-slate-600">
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">Flutter</span>
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">Dart</span>
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">Store Deployment</span>
        </div>
      </div>

      <!-- Card 3: Cloud & CI/CD (Compact) -->
      <div class="bento-card p-8 md:p-10 rounded-3xl flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-6">
            <span class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-500/20">
              INFRASTRUCTURE & DEVOPS
            </span>
            <span class="text-xs text-slate-400 font-mono">03</span>
          </div>
          <h3 class="text-2xl font-bold dark:text-white text-slate-900 mb-3">Automated CI/CD & Cloud</h3>
          <p class="dark:text-slate-400 text-slate-600 text-sm leading-relaxed mb-6">
            Automated deployment pipelines with GitHub Actions, FTPS/SFTP delivery to DirectAdmin/cPanel, AWS setups, and zero-downtime releases.
          </p>
        </div>
        <div class="flex flex-wrap gap-2 pt-6 border-t dark:border-slate-800/80 border-[#f2f4f7] text-xs font-mono dark:text-slate-300 text-slate-600">
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">GitHub Actions</span>
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">DirectAdmin FTPS</span>
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">AWS / Linux</span>
        </div>
      </div>

      <!-- Card 4: Systems Engineering (Wide) -->
      <div class="bento-card md:col-span-2 p-8 md:p-10 rounded-3xl flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-6">
            <span class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">
              SYSTEMS & HIGH CONCURRENCY
            </span>
            <span class="text-xs text-slate-400 font-mono">04</span>
          </div>
          <h3 class="text-2xl font-bold dark:text-white text-slate-900 mb-3">High-Concurrency Backend Architecture</h3>
          <p class="dark:text-slate-400 text-slate-600 text-sm leading-relaxed mb-6 max-w-xl">
            We build event-driven, memory-aware backend architectures. Leveraging asynchronous runtimes, worker pools, and automated memory-leak isolation to achieve sub-millisecond API response times.
          </p>
        </div>
        <div class="flex flex-wrap gap-2 pt-6 border-t dark:border-slate-800/80 border-[#f2f4f7] text-xs font-mono dark:text-slate-300 text-slate-600">
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">Async PHP</span>
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">OpenSwoole</span>
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">Event Loops</span>
          <span class="px-3 py-1 rounded-lg bg-[#f2f4f7] dark:bg-slate-800 font-medium">Zero State Leaks</span>
        </div>
      </div>

    </div>
  </section>

  <!-- Section 02: Selected Case Studies (Showcase Cards) -->
  <section id="work" class="max-w-6xl mx-auto px-6 py-20 border-t dark:border-slate-800/80 border-[#eaecf0]">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
      <div>
        <span class="text-xs font-mono font-bold tracking-widest text-brand-600 dark:text-brand-400 uppercase block mb-2">02 / Portfolio</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold dark:text-white text-slate-900 tracking-tight-title">Featured Projects & Case Studies</h2>
      </div>

      <!-- Filter Tabs -->
      <div class="flex flex-wrap gap-2 text-xs font-semibold">
        <button onclick="filterCategory('all')" id="btn-all" class="chip-active px-4 py-2 rounded-full border border-brand-500 dark:border-slate-700 transition-all">All Work</button>
        <button onclick="filterCategory('mobile')" id="btn-mobile" class="px-4 py-2 rounded-full border border-[#d0d5dd] dark:border-slate-800 bg-white dark:bg-slate-900/60 text-slate-700 dark:text-slate-300 hover:border-slate-400 transition-all">Mobile Apps</button>
        <button onclick="filterCategory('web')" id="btn-web" class="px-4 py-2 rounded-full border border-[#d0d5dd] dark:border-slate-800 bg-white dark:bg-slate-900/60 text-slate-700 dark:text-slate-300 hover:border-slate-400 transition-all">Web & Commerce</button>
        <button onclick="filterCategory('oss')" id="btn-oss" class="px-4 py-2 rounded-full border border-[#d0d5dd] dark:border-slate-800 bg-white dark:bg-slate-900/60 text-slate-700 dark:text-slate-300 hover:border-slate-400 transition-all">Systems & OSS</button>
      </div>
    </div>

    <!-- Editorial Cards Grid -->
    <div class="grid md:grid-cols-2 gap-8" id="projects-container">

      <!-- Project 1: TransFor (FLAGSHIP FRONT SHOWCASE) -->
      <div class="project-card mobile bento-card p-8 md:p-10 rounded-3xl flex flex-col justify-between border-2 border-brand-500/40 dark:border-brand-500/40 relative">
        <div class="absolute -top-3 left-8 px-3 py-0.5 rounded-full bg-brand-600 text-white font-mono text-[10px] font-bold tracking-wider uppercase shadow-md">
          ★ Flagship International Client (KSA)
        </div>
        <div>
          <!-- Studio Delivery & Wallet Mockup with Real Play Store Screenshots -->
          <div class="rounded-2xl dark:bg-[#05070c] bg-slate-100 p-4 sm:p-5 text-xs font-mono mb-6 shadow-sm border dark:border-slate-800 border-[#e4e7ec]">
            <!-- App Identity Bar -->
            <div class="flex items-center justify-between pb-3.5 mb-3.5 border-b dark:border-slate-800 border-[#d0d5dd]">
              <div class="flex items-center gap-3">
                <img src="images/projects/transfor-icon.png" alt="TransFor App Icon" class="w-11 h-11 rounded-xl shadow-md border dark:border-slate-700/60 border-slate-200 object-cover flex-shrink-0" loading="lazy">
                <div>
                  <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="text-xs font-bold font-sans text-slate-900 dark:text-white">TransFor Ecosystem</span>
                  </div>
                  <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Store Delivery & Digital Wallet</span>
                </div>
              </div>
              <span class="text-[10px] px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 font-bold border border-amber-300 dark:border-amber-700/40">Testing Phase</span>
            </div>

            <!-- Screenshots Showcase (3 Real Play Store Screens) -->
            <div class="flex items-center gap-2.5 sm:gap-3 overflow-x-auto no-scrollbar pb-1">
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/transfor-screen1.png" alt="TransFor Store & Products" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Store & Cart</div>
              </div>
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/transfor-screen2.png" alt="TransFor Wallet & Checkout" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Digital Wallet</div>
              </div>
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/transfor-screen3.png" alt="TransFor Rider Delivery" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Live Tracking</div>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-mono font-bold text-brand-600 dark:text-brand-400">ENTERPRISE LOGISTICS & WALLET</span>
            <span class="text-xs dark:text-slate-500 text-slate-400 font-mono">Saudi Arabia (KSA) • Pre-Launch</span>
          </div>

          <h3 class="text-2xl font-bold dark:text-white text-slate-900 mb-2">TransFor Logistics, Store & Wallet</h3>
          <p class="dark:text-slate-400 text-slate-600 text-sm leading-relaxed mb-6">
            On-demand delivery, multi-vendor marketplace ordering, and in-app digital wallet ecosystem built for an enterprise client in Saudi Arabia (KSA). Currently in active staging and user-testing phase ahead of commercial launch, transitioning backend to a Python AI-native dispatch core.
          </p>
        </div>

        <div class="flex items-center justify-between pt-5 border-t dark:border-slate-800/80 border-[#f2f4f7]">
          <button onclick="openModal('transfor')" class="text-xs font-bold text-brand-600 dark:text-brand-400 hover:opacity-80 flex items-center gap-1.5">
            <span>Read Case Study & Architecture Roadmap</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
          </button>
          <a href="https://play.google.com/store/apps/details?id=com.techomega.trans_for" target="_blank" class="text-xs font-mono font-semibold dark:text-slate-400 text-slate-500 hover:text-brand-600 dark:hover:text-brand-400 underline">
            Play Store (Testing) ↗
          </a>
        </div>
      </div>

      <!-- Project 2: HishabKhata -->
      <div class="project-card mobile bento-card p-8 md:p-10 rounded-3xl flex flex-col justify-between">
        <div>
          <!-- Studio Financial Mockup with Real Play Store Screenshots -->
          <div class="rounded-2xl dark:bg-[#05070c] bg-slate-100 p-4 sm:p-5 text-xs font-mono mb-6 shadow-sm border dark:border-slate-800 border-[#e4e7ec]">
            <!-- App Identity Bar -->
            <div class="flex items-center justify-between pb-3.5 mb-3.5 border-b dark:border-slate-800 border-[#d0d5dd]">
              <div class="flex items-center gap-3">
                <img src="images/projects/hishabkhata-icon.png" alt="HishabKhata App Icon" class="w-11 h-11 rounded-xl shadow-md border dark:border-slate-700/60 border-slate-200 object-cover flex-shrink-0" loading="lazy">
                <div>
                  <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                    <span class="text-xs font-bold font-sans text-slate-900 dark:text-white">HishabKhata</span>
                  </div>
                  <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Store Ledger & Credit Tracking</span>
                </div>
              </div>
              <span class="text-[10px] px-2.5 py-1 rounded-full bg-sky-100 dark:bg-sky-950/80 text-sky-800 dark:text-cyan-300 font-bold border border-sky-300 dark:border-cyan-700/40">AI Transformation</span>
            </div>

            <!-- Screenshots Showcase (3 Real Play Store Screens) -->
            <div class="flex items-center gap-2.5 sm:gap-3 overflow-x-auto no-scrollbar pb-1">
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/hishabkhata-screen1.png" alt="HishabKhata Smart Dashboard" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Cash Ledger</div>
              </div>
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/hishabkhata-screen2.png" alt="HishabKhata Due Reminders" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Due Reminders</div>
              </div>
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/hishabkhata-screen3.png" alt="HishabKhata Financial Analytics" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Store Reports</div>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-mono font-bold text-sky-600 dark:text-cyan-400">STORE FINANCIAL & FINTECH</span>
            <span class="text-xs dark:text-slate-500 text-slate-400 font-mono">Flutter / Next.js / Go / Python</span>
          </div>

          <h3 class="text-2xl font-bold dark:text-white text-slate-900 mb-2">HishabKhata Store Finance</h3>
          <p class="dark:text-slate-400 text-slate-600 text-sm leading-relaxed mb-6">
            Digital ledger, transaction tracking, and merchant credit management mobile application built for retail businesses. Engineered with Flutter and Next.js, currently undergoing AI-native transformation with high-throughput Golang and Python microservices.
          </p>
        </div>

        <div class="flex items-center justify-between pt-5 border-t dark:border-slate-800/80 border-[#f2f4f7]">
          <button onclick="openModal('hishabkhata')" class="text-xs font-bold text-sky-600 dark:text-cyan-400 hover:opacity-80 flex items-center gap-1.5">
            <span>Read Case Study & AI Roadmap</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
          </button>
          <a href="https://play.google.com/store/apps/details?id=com.hisabkhata.app" target="_blank" class="text-xs font-mono font-semibold dark:text-slate-400 text-slate-500 hover:text-sky-600 dark:hover:text-cyan-400 underline">
            Play Store ↗
          </a>
        </div>
      </div>

      <!-- Project 3: Pulse Framework -->
      <div class="project-card oss bento-card p-8 md:p-10 rounded-3xl flex flex-col justify-between">
        <div>
          <!-- Studio Mockup Container -->
          <div class="rounded-2xl dark:bg-[#05070c] bg-slate-900 p-5 text-xs font-mono mb-6 shadow-md border dark:border-slate-800 border-slate-800 text-slate-200">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-800">
              <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-rose-500/80 inline-block"></span>
                <span class="w-3 h-3 rounded-full bg-amber-500/80 inline-block"></span>
                <span class="w-3 h-3 rounded-full bg-emerald-500/80 inline-block"></span>
              </div>
              <span class="text-[11px] text-slate-400">pulse-core / engine.php</span>
              <span class="text-[10px] text-brand-400 font-semibold">OpenSwoole 8.4+</span>
            </div>
            <div class="space-y-1.5 text-[11px]">
              <div><span class="text-brand-400 font-bold">$app</span> = Pulse\Kernel::boot();</div>
              <div><span class="text-cyan-400">$app</span>->enforceWorkerBoundary(Isolation::STRICT);</div>
              <div class="text-emerald-400 flex items-center justify-between pt-1">
                <span>✓ 10,000 requests served</span>
                <span class="text-slate-400 text-[10px]">0.00MB leak</span>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-mono font-bold text-brand-600 dark:text-brand-400">SYSTEMS & ARCHITECTURE</span>
            <span class="text-xs dark:text-slate-500 text-slate-400 font-mono">2026 Release</span>
          </div>

          <h3 class="text-2xl font-bold dark:text-white text-slate-900 mb-2">Pulse Microframework</h3>
          <p class="dark:text-slate-400 text-slate-600 text-sm leading-relaxed mb-6">
            Open-source microframework engineered for long-running PHP environments. Eliminates cross-request state pollution and ensures clean memory isolation in asynchronous event-loops.
          </p>
        </div>

        <div class="flex items-center justify-between pt-5 border-t dark:border-slate-800/80 border-[#f2f4f7]">
          <button onclick="openModal('pulse')" class="text-xs font-bold text-brand-600 dark:text-brand-400 hover:opacity-80 flex items-center gap-1.5">
            <span>Read Architecture Case Study</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
          </button>
          <a href="https://github.com/Fariv/pulse" target="_blank" class="text-xs font-mono font-semibold dark:text-slate-400 text-slate-500 hover:text-brand-600 dark:hover:text-brand-400 underline">
            GitHub ↗
          </a>
        </div>
      </div>

      <!-- Project 4: Pantone Picker -->
      <div class="project-card mobile bento-card p-8 md:p-10 rounded-3xl flex flex-col justify-between">
        <div>
          <!-- Studio Mobile Preview Container with Real Play Store Screenshots -->
          <div class="rounded-2xl dark:bg-[#05070c] bg-slate-100 p-4 sm:p-5 text-xs font-mono mb-6 shadow-sm border dark:border-slate-800 border-[#e4e7ec]">
            <!-- App Identity Bar -->
            <div class="flex items-center justify-between pb-3.5 mb-3.5 border-b dark:border-slate-800 border-[#d0d5dd]">
              <div class="flex items-center gap-3">
                <img src="images/projects/pantone-icon.png" alt="Pantone Picker App Icon" class="w-11 h-11 rounded-xl shadow-md border dark:border-slate-700/60 border-slate-200 object-cover flex-shrink-0" loading="lazy">
                <div>
                  <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-violet-500"></span>
                    <span class="text-xs font-bold font-sans text-slate-900 dark:text-white">Pantone Picker</span>
                  </div>
                  <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Camera Color Extraction</span>
                </div>
              </div>
              <span class="text-[10px] px-2.5 py-1 rounded-full bg-violet-100 dark:bg-purple-950/80 text-violet-800 dark:text-purple-300 font-bold border border-violet-300 dark:border-purple-700/40">Google Play</span>
            </div>

            <!-- Screenshots Showcase (3 Real Play Store Screens) -->
            <div class="flex items-center gap-2.5 sm:gap-3 overflow-x-auto no-scrollbar pb-1">
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/pantone-screen1.png" alt="Camera Sensor Sampling" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Color Sensor</div>
              </div>
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/pantone-screen2.png" alt="Palette Harmonies" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Harmonies</div>
              </div>
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/pantone-screen3.png" alt="Color Swatch Library" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Swatch Library</div>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-mono font-bold text-violet-600 dark:text-purple-400">MOBILE UTILITY</span>
            <span class="text-xs dark:text-slate-500 text-slate-400 font-mono">Flutter / Dart</span>
          </div>

          <h3 class="text-2xl font-bold dark:text-white text-slate-900 mb-2">Pantone Picker App</h3>
          <p class="dark:text-slate-400 text-slate-600 text-sm leading-relaxed mb-6">
            Production Flutter utility published on Google Play. Empowers designers with real-time camera color sampling, instant harmony suggestions, and multi-format hex/RGB export.
          </p>
        </div>

        <div class="flex items-center justify-between pt-5 border-t dark:border-slate-800/80 border-[#f2f4f7]">
          <button onclick="openModal('pantone')" class="text-xs font-bold text-violet-600 dark:text-purple-400 hover:opacity-80 flex items-center gap-1.5">
            <span>Read Case Study</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
          </button>
          <a href="https://play.google.com/store/apps/details?id=com.af.pantone_book" target="_blank" class="text-xs font-mono font-semibold dark:text-slate-400 text-slate-500 hover:text-violet-600 dark:hover:text-purple-400 underline">
            Play Store ↗
          </a>
        </div>
      </div>

      <!-- Project 5: SuperStoreX -->
      <div class="project-card web bento-card p-8 md:p-10 rounded-3xl flex flex-col justify-between">
        <div>
          <!-- Studio Commerce Preview Container with Real Production Screenshots -->
          <div class="rounded-2xl dark:bg-[#05070c] bg-slate-100 p-4 sm:p-5 text-xs font-mono mb-6 shadow-sm border dark:border-slate-800 border-[#e4e7ec]">
            <!-- App Identity Bar -->
            <div class="flex items-center justify-between pb-3.5 mb-3.5 border-b dark:border-slate-800 border-[#d0d5dd]">
              <div class="flex items-center gap-3">
                <img src="images/projects/superstore-icon.png" alt="SuperStoreX App Icon" class="w-11 h-11 rounded-xl shadow-md border dark:border-slate-700/60 border-slate-200 object-cover flex-shrink-0" loading="lazy">
                <div>
                  <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    <span class="text-xs font-bold font-sans text-slate-900 dark:text-white">SuperStoreX</span>
                  </div>
                  <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Next.js 16 • Headless E-Commerce</span>
                </div>
              </div>
              <span class="text-[10px] px-2.5 py-1 rounded-full bg-indigo-100 dark:bg-indigo-950/80 text-indigo-800 dark:text-indigo-300 font-bold border border-indigo-300 dark:border-indigo-700/40">Production Live</span>
            </div>

            <!-- Screenshots Showcase (3 Real Production Screens) -->
            <div class="flex items-center gap-2.5 sm:gap-3 overflow-x-auto no-scrollbar pb-1">
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/superstore-screen1.png" alt="SuperStoreX Storefront & Deals" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Deals & Catalog</div>
              </div>
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/superstore-screen2.png" alt="SuperStoreX Faceted Search" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Faceted Search</div>
              </div>
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/superstore-screen3.png" alt="SuperStoreX Product Details" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Interactive Detail</div>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400">HEADLESS E-COMMERCE PLATFORM</span>
            <span class="text-xs dark:text-slate-500 text-slate-400 font-mono">Next.js 16 • Turbopack • Mongoose</span>
          </div>

          <h3 class="text-2xl font-bold dark:text-white text-slate-900 mb-2">SuperStoreX Modern Retail Storefront</h3>
          <p class="dark:text-slate-400 text-slate-600 text-sm leading-relaxed mb-6">
            Production headless electronics and robotics marketplace with Turbopack & React 19. Features bilingual localization (next-intl), multi-provider authentication (Auth.js v5 beta), bKash digital payment integration, automated PDF invoice generation, and Google Drive cloud media storage.
          </p>
        </div>

        <div class="flex items-center justify-between pt-5 border-t dark:border-slate-800/80 border-[#f2f4f7]">
          <button onclick="openModal('superstore')" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:opacity-80 flex items-center gap-1.5">
            <span>Read Case Study</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
          </button>
          <a href="https://superstorex.vercel.app/" target="_blank" class="text-xs font-mono font-semibold dark:text-slate-400 text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 underline">
            Live Vercel ↗
          </a>
        </div>
      </div>

      <!-- Project 6: RentBDOnline -->
      <div class="project-card web bento-card p-8 md:p-10 rounded-3xl flex flex-col justify-between">
        <div>
          <!-- Studio Portal Preview Container with Real Production Screenshots -->
          <div class="rounded-2xl dark:bg-[#05070c] bg-slate-100 p-4 sm:p-5 text-xs font-mono mb-6 shadow-sm border dark:border-slate-800 border-[#e4e7ec]">
            <!-- App Identity Bar -->
            <div class="flex items-center justify-between pb-3.5 mb-3.5 border-b dark:border-slate-800 border-[#d0d5dd]">
              <div class="flex items-center gap-3">
                <img src="images/projects/rentbd-icon.png" alt="RentBD App Icon" class="w-11 h-11 rounded-xl shadow-md border dark:border-slate-700/60 border-slate-200 object-cover flex-shrink-0" loading="lazy">
                <div>
                  <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold font-sans text-slate-900 dark:text-white">RentBD PropTech</span>
                  </div>
                  <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Direct Landlord Marketplace</span>
                </div>
              </div>
              <span class="text-[10px] px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 font-bold border border-emerald-300 dark:border-emerald-700/40">Production Live</span>
            </div>

            <!-- Screenshots Showcase (3 Real Production Screens) -->
            <div class="flex items-center gap-2.5 sm:gap-3 overflow-x-auto no-scrollbar pb-1">
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/rentbd-screen1.png" alt="RentBD Homepage & Carousel" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">Hero & Carousel</div>
              </div>
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/rentbd-screen2.png" alt="RentBD 10/Page Directory" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">10/Page Directory</div>
              </div>
              <div class="relative flex-shrink-0 w-24 sm:w-28 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950 group/screen">
                <img src="images/projects/rentbd-screen3.png" alt="RentBD HD Lightbox Gallery" class="w-full h-auto object-cover group-hover/screen:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/90 to-transparent p-1.5 text-[9px] text-white text-center font-sans font-medium">HD Lightbox</div>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-mono font-bold text-brand-600 dark:text-brand-400">COMMERCIAL & RESIDENTIAL PROPTECH</span>
            <span class="text-xs dark:text-slate-500 text-slate-400 font-mono">Laravel 12 • Alpine.js</span>
          </div>

          <h3 class="text-2xl font-bold dark:text-white text-slate-900 mb-2">RentBD Commercial & Property Portal</h3>
          <p class="dark:text-slate-400 text-slate-600 text-sm leading-relaxed mb-6">
            Nationwide property marketplace serving 64 districts in Bangladesh. Features touch-friendly recent listings carousel, bilingual English/Bangla localization, Select2 SVG taxonomy, operations verification moderation pipeline, and zero-dependency GLightbox gallery.
          </p>
        </div>

        <div class="flex items-center justify-between pt-5 border-t dark:border-slate-800/80 border-[#f2f4f7]">
          <button onclick="openModal('rentbd')" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:opacity-80 flex items-center gap-1.5">
            <span>Read Case Study</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
          </button>
          <a href="https://rentbdonline.techbros.co.za/" target="_blank" class="text-xs font-mono font-semibold dark:text-slate-400 text-slate-500 hover:text-amber-600 dark:hover:text-amber-400 underline">
            Live Site ↗
          </a>
        </div>
      </div>

    </div>
  </section>

  <!-- Section 03: High-Converting Project Inquiry Engine -->
  <section id="contact" class="max-w-4xl mx-auto px-6 py-20 border-t dark:border-slate-800/80 border-[#eaecf0]">
    <div class="bento-card p-8 md:p-12 rounded-3xl">
      <div class="max-w-2xl mb-8">
        <span class="text-xs font-mono font-bold tracking-widest text-brand-600 dark:text-brand-400 uppercase block mb-2">03 / Inbound</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold dark:text-white text-slate-900 tracking-tight-title mb-3">Schedule a Project Scoping Call</h2>
        <p class="text-sm dark:text-slate-400 text-slate-600 leading-relaxed">
          Share your product requirements and timeline. A senior engineer will review your brief and reply within 24 hours.
        </p>
      </div>

      <form id="inquiry-form" onsubmit="handleFormSubmit(event)" class="space-y-6">
        <div>
          <label class="block text-xs font-mono dark:text-slate-300 text-slate-700 mb-2 uppercase tracking-wider font-semibold">1. Select Project Discipline</label>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
            <button type="button" onclick="selectDiscipline(this, 'Web Platform')" class="discipline-btn chip-active px-3 py-2.5 rounded-xl border border-brand-500 dark:border-slate-700 text-xs font-medium text-center transition-all">Web Platform</button>
            <button type="button" onclick="selectDiscipline(this, 'Mobile App')" class="discipline-btn px-3 py-2.5 rounded-xl border border-[#d0d5dd] dark:border-slate-800 bg-white dark:bg-slate-900/60 text-slate-700 dark:text-slate-300 text-xs font-medium text-center hover:border-slate-400 transition-all">Mobile App</button>
            <button type="button" onclick="selectDiscipline(this, 'Full MVP Build')" class="discipline-btn px-3 py-2.5 rounded-xl border border-[#d0d5dd] dark:border-slate-800 bg-white dark:bg-slate-900/60 text-slate-700 dark:text-slate-300 text-xs font-medium text-center hover:border-slate-400 transition-all">Full MVP Build</button>
            <button type="button" onclick="selectDiscipline(this, 'Cloud & Systems')" class="discipline-btn px-3 py-2.5 rounded-xl border border-[#d0d5dd] dark:border-slate-800 bg-white dark:bg-slate-900/60 text-slate-700 dark:text-slate-300 text-xs font-medium text-center hover:border-slate-400 transition-all">Cloud & Systems</button>
          </div>
          <input type="hidden" id="selected-discipline" name="discipline" value="Web Platform">
        </div>

        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label for="contact-name" class="block text-xs font-mono dark:text-slate-300 text-slate-700 mb-2 uppercase tracking-wider font-semibold">Your Name</label>
            <input id="contact-name" name="name" required type="text" placeholder="e.g. Alex Morgan" class="w-full px-4 py-3 rounded-xl dark:bg-slate-900/80 bg-white border dark:border-slate-800 border-[#d0d5dd] text-sm dark:text-white text-slate-900 focus:outline-none focus:border-brand-500 transition-all shadow-sm">
          </div>
          <div>
            <label for="contact-email" class="block text-xs font-mono dark:text-slate-300 text-slate-700 mb-2 uppercase tracking-wider font-semibold">Work Email</label>
            <input id="contact-email" name="email" required type="email" placeholder="alex@company.com" class="w-full px-4 py-3 rounded-xl dark:bg-slate-900/80 bg-white border dark:border-slate-800 border-[#d0d5dd] text-sm dark:text-white text-slate-900 focus:outline-none focus:border-brand-500 transition-all shadow-sm">
          </div>
        </div>

        <div>
          <label for="contact-message" class="block text-xs font-mono dark:text-slate-300 text-slate-700 mb-2 uppercase tracking-wider font-semibold">Project Scope & Target Launch</label>
          <textarea id="contact-message" name="message" rows="3" required placeholder="Tell us about your product goals, timeline, and tech stack expectations..." class="w-full px-4 py-3 rounded-xl dark:bg-slate-900/80 bg-white border dark:border-slate-800 border-[#d0d5dd] text-sm dark:text-white text-slate-900 focus:outline-none focus:border-brand-500 transition-all shadow-sm"></textarea>
        </div>

        <!-- Alert Response Area -->
        <div id="form-alert" class="hidden p-4 rounded-xl text-xs font-semibold"></div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
          <button type="submit" id="submit-btn" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-brand-600 hover:bg-brand-700 dark:bg-brand-500 dark:hover:bg-brand-400 text-white dark:text-slate-950 font-bold transition-all shadow-lg shadow-brand-600/20 dark:shadow-brand-500/20 disabled:opacity-50">
            Send Inquiry to TechBros ➔
          </button>
          <div class="text-xs dark:text-slate-400 text-slate-500 flex items-center gap-2">
            <span>Direct contact:</span>
            <a href="mailto:techbros@techbros.co.za" class="text-brand-600 dark:text-brand-400 font-mono font-semibold hover:underline">techbros@techbros.co.za</a>
          </div>
        </div>
      </form>
    </div>
  </section>

  <!-- Interactive Case Study Modal -->
  <div id="case-study-modal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="dark:bg-[#0d111a] bg-white dark:border-slate-800 border-[#eaecf0] border rounded-3xl max-w-xl w-full p-6 md:p-8 shadow-2xl relative">
      <button onclick="closeModal()" aria-label="Close modal" class="absolute top-5 right-5 text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 text-lg font-mono">✕</button>
      <div id="modal-content"></div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center text-xs dark:text-slate-500 text-slate-400 py-12 border-t dark:border-slate-800/80 border-[#eaecf0]">
    &copy; <?= $currentYear ?> TechBros. Built with SEO-first PHP 8.5 & modern Tailwind CSS.
  </footer>

  <!-- Interactive Logic Script -->
  <script>
    function toggleTheme() {
      const html = document.documentElement;
      const isDark = html.classList.toggle('dark');
      if (isDark) {
        html.classList.remove('light');
        localStorage.setItem('techbros_theme', 'dark');
        document.getElementById('theme-icon').textContent = '☀️';
        document.getElementById('theme-label').textContent = 'Light Mode';
      } else {
        html.classList.add('light');
        localStorage.setItem('techbros_theme', 'light');
        document.getElementById('theme-icon').textContent = '🌙';
        document.getElementById('theme-label').textContent = 'Dark Mode';
      }
    }

    // Set initial button label on load
    window.addEventListener('DOMContentLoaded', () => {
      const isDark = document.documentElement.classList.contains('dark');
      document.getElementById('theme-icon').textContent = isDark ? '☀️' : '🌙';
      document.getElementById('theme-label').textContent = isDark ? 'Light Mode' : 'Dark Mode';
    });

    function filterCategory(cat) {
      document.querySelectorAll('#work button').forEach(btn => btn.classList.remove('chip-active'));
      document.getElementById('btn-' + cat).classList.add('chip-active');

      const cards = document.querySelectorAll('.project-card');
      cards.forEach(card => {
        card.style.display = (cat === 'all' || card.classList.contains(cat)) ? 'flex' : 'none';
      });
    }

    function selectDiscipline(btn, name) {
      document.querySelectorAll('.discipline-btn').forEach(b => b.classList.remove('chip-active'));
      btn.classList.add('chip-active');
      document.getElementById('selected-discipline').value = name;
    }

    const caseStudyData = {
      transfor: {
        title: "TransFor Logistics, Store & Wallet",
        subtitle: "Production Flutter Mobile & Backend System • Client in Saudi Arabia (KSA)",
        icon: "images/projects/transfor-icon.png",
        screenshots: [
          "images/projects/transfor-screen1.png",
          "images/projects/transfor-screen2.png",
          "images/projects/transfor-screen3.png"
        ],
        storeUrl: "https://play.google.com/store/apps/details?id=com.techomega.trans_for",
        challenge: "An enterprise retail client in Saudi Arabia needed a unified multi-vendor on-demand delivery ecosystem, integrating real-time rider tracking, multi-store order dispatching, and an in-app digital wallet processing SAR (Saudi Riyal) transactions with zero balance discrepancies.",
        solution: "Architected cross-platform Flutter mobile applications for consumers, merchants, and riders with offline resilience and map routing. Backend originally built in PHP, now being renovated into an asynchronous Python microservices architecture with an AI-native smart dispatch and route optimization core.",
        outcome: "Currently in active user acceptance testing (UAT) and pilot staging for Saudi Arabia client, preparing for commercial rollout with multi-vendor store ordering and digital wallet balance."
      },
      hishabkhata: {
        title: "HishabKhata Store Financial Mobile App",
        subtitle: "Retail Bookkeeping & Ledger Mobile Platform • Flutter & Next.js",
        icon: "images/projects/hishabkhata-icon.png",
        screenshots: [
          "images/projects/hishabkhata-screen1.png",
          "images/projects/hishabkhata-screen2.png",
          "images/projects/hishabkhata-screen3.png"
        ],
        storeUrl: "https://play.google.com/store/apps/details?id=com.hisabkhata.app",
        challenge: "Retail shop owners and micro-enterprises needed an intuitive, fast, mobile-first ledger system to replace paper cashbooks, track receivables/payables, and calculate customer credit balances without accounting complexity.",
        solution: "Engineered high-performance Flutter mobile application with responsive Next.js cloud APIs. Currently architecting an AI-native evolution utilizing high-concurrency Golang services and Python machine learning pipelines for automated paper-bill OCR scanning, predictive cashflow forecasting, and automated merchant voice ledger input.",
        outcome: "Published on Google Play, serving active merchant bookkeeping records with zero transaction loss."
      },
      pulse: {
        title: "Pulse Microframework",
        subtitle: "Minimal OpenSwoole microframework for long-running PHP 8.4+",
        challenge: "Standard PHP request lifecycles wipe memory on exit. Running PHP in persistent event loops (OpenSwoole) causes static caches and singletons to leak data across concurrent requests.",
        solution: "Engineered Pulse with strict isolation between Worker-level state (DB connection pools, routes) and Request-level state. Added active memory-leak metrics.",
        outcome: "Sub-millisecond API response latency, 100% memory isolation, public open-source project."
      },
      pantone: {
        title: "Pantone Picker Mobile App",
        subtitle: "Production Flutter Application published on Google Play",
        icon: "images/projects/pantone-icon.png",
        screenshots: [
          "images/projects/pantone-screen1.png",
          "images/projects/pantone-screen2.png",
          "images/projects/pantone-screen3.png"
        ],
        storeUrl: "https://play.google.com/store/apps/details?id=com.af.pantone_book",
        challenge: "Designers needed a reliable offline mobile utility to sample colors through hardware camera sensors and match them to international swatch libraries.",
        solution: "Built in Flutter with custom hardware color extraction, local SQLite database, and 60fps palette search without network latency.",
        outcome: "Published on Google Play, 100% crash-free sessions."
      },
      superstore: {
        title: "SuperStoreX Headless Commerce",
        subtitle: "Production Next.js 16, React 19 & Mongoose Retail Platform",
        icon: "images/projects/superstore-icon.png",
        screenshots: [
          "images/projects/superstore-screen1.png",
          "images/projects/superstore-screen2.png",
          "images/projects/superstore-screen3.png"
        ],
        storeUrl: "https://superstorex.vercel.app/",
        storeText: "Visit Live Storefront ↗",
        challenge: "Traditional e-commerce platforms suffer from high bounce rates due to sluggish page recalculations, fragmented checkout gateways, unoptimized mobile catalogs, and rigid monolithic backends unable to handle multi-locale currencies and bilingual customer bases.",
        solution: "Engineered a headless retail application using Next.js 16 with Turbopack, React 19, and Mongoose 8. Features Next-Intl bilingual English/Bangla localization, dual BDT/USD currency toggle, multi-provider Auth.js (v5 beta) authentication, real-time faceted search, bKash digital payment gateway integration, automated serverless PDF receipt generation with @react-pdf, and cloud media asset management via Google Drive APIs.",
        outcome: "Sub-second page transitions on Vercel Edge, 98+ Lighthouse scores, zero-latency client cart updates, and robust automated checkout and invoice delivery."
      },
      rentbd: {
        title: "RentBD Commercial & PropTech Portal",
        subtitle: "Modernized Laravel 12 & Alpine.js Marketplace",
        icon: "images/projects/rentbd-icon.png",
        screenshots: [
          "images/projects/rentbd-screen1.png",
          "images/projects/rentbd-screen2.png",
          "images/projects/rentbd-screen3.png"
        ],
        storeUrl: "https://rentbdonline.techbros.co.za/",
        storeText: "Visit Live Platform ↗",
        challenge: "Modernizing a high-throughput nationwide property directory across 64 districts in Bangladesh without service downtime, while upgrading legacy tables to an indexed Laravel 12 architecture, enforcing strict administrative phone verification, and enhancing listing photo presentation.",
        solution: "Re-engineered the platform with bilingual (English/Bangla) localization, Select2 SVG taxonomy, automated GD thumbnail generation, touch-friendly homepage recent listings carousel, responsive 10-per-page directory pagination, and full-resolution GLightbox modal gallery.",
        outcome: "100% verified listing feeds, sub-100ms response times on LiteSpeed, zero unverified leaks to public visitors, and an end-to-end audit trail in the operations admin dashboard."
      }
    };

    function openModal(id) {
      const data = caseStudyData[id];
      if (!data) return;

      const headerIconHtml = data.icon ? `
        <img src="${data.icon}" alt="${data.title} Icon" class="w-14 h-14 rounded-2xl shadow-md border dark:border-slate-700/60 border-slate-200 object-cover flex-shrink-0" loading="lazy">
      ` : '';

      const screenshotsHtml = (data.screenshots && data.screenshots.length > 0) ? `
        <div class="mb-5">
          <span class="text-[10px] font-mono uppercase tracking-wider text-slate-400 block mb-2">Production App Screenshots</span>
          <div class="flex items-center gap-3 overflow-x-auto no-scrollbar pb-2 pt-1">
            ${data.screenshots.map((src, i) => `
              <div class="relative flex-shrink-0 w-32 sm:w-36 rounded-xl overflow-hidden shadow-md border dark:border-slate-800 border-slate-200/80 bg-slate-950">
                <img src="${src}" alt="Screenshot ${i+1}" class="w-full h-auto object-cover" loading="lazy">
              </div>
            `).join('')}
          </div>
        </div>
      ` : '';

      const storeLinkHtml = data.storeUrl ? `
        <a href="${data.storeUrl}" target="_blank" class="flex-1 py-3 px-4 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-semibold text-xs text-center transition-all flex items-center justify-center gap-1.5 shadow-sm">
          <span>${data.storeText || 'View on Google Play'}</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>
      ` : '';

      document.getElementById('modal-content').innerHTML = `
        <div class="flex items-start gap-4 mb-4">
          ${headerIconHtml}
          <div>
            <span class="text-xs font-mono text-brand-600 dark:text-brand-400 uppercase tracking-widest font-bold block mb-1">Technical Case Study</span>
            <h3 class="text-2xl font-bold dark:text-white text-slate-900 leading-tight mb-1">${data.title}</h3>
            <p class="text-xs dark:text-slate-400 text-slate-500 font-mono">${data.subtitle}</p>
          </div>
        </div>

        ${screenshotsHtml}
        
        <div class="space-y-4 text-sm leading-relaxed mb-6">
          <div class="p-4 rounded-2xl dark:bg-[#05070c] bg-[#f8f9fc] border dark:border-slate-800 border-[#eaecf0]">
            <strong class="dark:text-slate-200 text-slate-800 block text-xs uppercase font-mono tracking-wider mb-1.5">Challenge</strong>
            <p class="dark:text-slate-400 text-slate-600 text-xs leading-relaxed">${data.challenge}</p>
          </div>
          <div class="p-4 rounded-2xl dark:bg-[#05070c] bg-[#f8f9fc] border dark:border-slate-800 border-[#eaecf0]">
            <strong class="dark:text-slate-200 text-slate-800 block text-xs uppercase font-mono tracking-wider mb-1.5">Architecture & Engineering</strong>
            <p class="dark:text-slate-400 text-slate-600 text-xs leading-relaxed">${data.solution}</p>
          </div>
          <div class="p-3.5 rounded-xl dark:bg-brand-950/40 bg-brand-50 border dark:border-brand-500/30 border-brand-200 text-brand-800 dark:text-brand-300 text-xs font-medium">
            <strong>Key Outcome:</strong> ${data.outcome}
          </div>
        </div>

        <div class="flex items-center gap-3">
          ${storeLinkHtml}
          <button onclick="closeModal()" class="flex-1 py-3 rounded-xl dark:bg-slate-800 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition-all">
            Close Case Study
          </button>
        </div>
      `;
      document.getElementById('case-study-modal').classList.remove('hidden');
    }

    function closeModal() {
      document.getElementById('case-study-modal').classList.add('hidden');
    }

    // Asynchronous Inquiry Form Submission
    async function handleFormSubmit(e) {
      e.preventDefault();
      const form = e.target;
      const btn = document.getElementById('submit-btn');
      const alertBox = document.getElementById('form-alert');

      btn.disabled = true;
      btn.textContent = 'Submitting brief...';
      alertBox.className = 'hidden';

      const payload = {
        name: form.name.value,
        email: form.email.value,
        discipline: document.getElementById('selected-discipline').value,
        message: form.message.value
      };

      try {
        const response = await fetch('api/contact.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const result = await response.json();

        if (response.ok && result.success) {
          alertBox.className = 'block p-4 rounded-xl text-xs font-semibold bg-brand-50 dark:bg-brand-950/60 text-brand-800 dark:text-brand-300 border border-brand-200 dark:border-brand-500/30';
          alertBox.textContent = result.message;
          form.reset();
        } else {
          alertBox.className = 'block p-4 rounded-xl text-xs font-semibold bg-rose-50 dark:bg-rose-950/60 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-500/30';
          alertBox.textContent = result.error || 'Failed to submit inquiry. Please email directly at techbros@techbros.co.za';
        }
      } catch (err) {
        alertBox.className = 'block p-4 rounded-xl text-xs font-semibold bg-rose-50 dark:bg-rose-950/60 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-500/30';
        alertBox.textContent = 'Connection error. Please email directly at techbros@techbros.co.za';
      } finally {
        btn.disabled = false;
        btn.textContent = 'Send Inquiry to TechBros ➔';
      }
    }
  </script>
</body>
</html>
