<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EduSkill – Skills & Courses</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    /* ─── TOKENS ────────────────────────────────────────── */
    :root {
      --primary:       #c97b2e;
      --primary-dark:  #a35f18;
      --primary-light: #e8a44a;
      --cream:         #faf4ec;
      --cream-dark:    #f0e6d3;
      --text-dark:     #1e1a14;
      --text-mid:      #5a4e3a;
      --text-light:    #9a8a6a;
      --white:         #ffffff;
      --radius:        18px;
      --nav-h:         64px;
      --transition:    0.32s cubic-bezier(.4,0,.2,1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--cream);
      color: var(--text-dark);
      overflow-x: hidden;
    }
    img { display: block; max-width: 100%; }
    a { text-decoration: none; }

    /* ─── FLOATING PILL NAVBAR ──────────────────────────── */
    .nav-wrapper {
      position: fixed;
      top: 16px; left: 50%; transform: translateX(-50%);
      width: calc(100% - 48px);
      max-width: 1160px;
      z-index: 1000;
    }
    nav {
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 20px 0 16px;
      height: var(--nav-h);
      background: rgba(255,255,255,0.88);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border-radius: 50px;
      border: 1px solid rgba(201,123,46,0.18);
      box-shadow: 0 8px 32px rgba(201,123,46,0.13), 0 2px 8px rgba(0,0,0,0.06);
      transition: box-shadow var(--transition), background var(--transition);
    }
    nav.scrolled {
      background: rgba(255,255,255,0.97);
      box-shadow: 0 12px 40px rgba(201,123,46,0.18), 0 2px 8px rgba(0,0,0,0.08);
    }

    /* Logo */
    .nav-logo {
      display: flex; align-items: center; gap: 9px;
      font-family: 'Playfair Display', serif;
      font-size: 1.3rem; font-weight: 700; color: var(--primary);
      white-space: nowrap;
    }
    .nav-logo-icon {
      width: 34px; height: 34px;
      background: var(--primary); border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .nav-logo-icon i { color: white; font-size: 0.85rem; }

    /* Links */
    .nav-links {
      display: flex; align-items: center; gap: 2px;
      list-style: none;
    }
    .nav-links a {
      padding: 7px 15px;
      font-size: 0.88rem; font-weight: 500;
      color: var(--text-mid);
      border-radius: 50px;
      transition: color var(--transition), background var(--transition);
    }
    .nav-links a:hover,
    .nav-links a.active { color: var(--primary); background: rgba(201,123,46,0.09); }

    /* Hamburger */
    .nav-hamburger {
      display: none; flex-direction: column; gap: 5px;
      background: none; border: none; cursor: pointer; padding: 6px;
    }
    .nav-hamburger span {
      display: block; width: 22px; height: 2px;
      background: var(--text-dark); border-radius: 2px;
      transition: transform 0.3s, opacity 0.3s;
    }
    .nav-hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    .nav-hamburger.open span:nth-child(2) { opacity: 0; }
    .nav-hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* Mobile nav panel */
    .mobile-menu {
      display: none;
      position: absolute; top: calc(100% + 10px); left: 0; right: 0;
      background: white; border-radius: 20px;
      box-shadow: 0 12px 40px rgba(0,0,0,0.12);
      padding: 16px; flex-direction: column; gap: 4px;
    }
    .mobile-menu.open { display: flex; }
    .mobile-menu a {
      padding: 11px 16px; border-radius: 12px;
      font-size: 0.92rem; font-weight: 500; color: var(--text-mid);
      transition: background 0.2s, color 0.2s;
    }
    .mobile-menu a:hover { background: var(--cream); color: var(--primary); }
    .mobile-divider {
      height: 1px; background: var(--cream-dark); margin: 6px 0;
    }
    .mobile-section-label {
      padding: 4px 16px;
      font-size: 0.7rem; font-weight: 700; color: var(--text-light);
      letter-spacing: 0.08em; text-transform: uppercase;
    }

    /* Join Us dropdown */
    .join-dropdown { position: relative; }
    .btn-join {
      background: var(--primary); color: white;
      border: none; border-radius: 50px;
      padding: 9px 20px; font-size: 0.88rem; font-weight: 600;
      cursor: pointer; font-family: 'DM Sans', sans-serif;
      display: flex; align-items: center; gap: 7px;
      white-space: nowrap;
      transition: background var(--transition), transform var(--transition);
    }
    .btn-join:hover { background: var(--primary-dark); transform: translateY(-1px); }
    .btn-join i { font-size: 0.7rem; transition: transform 0.3s; }
    .join-dropdown:hover .btn-join i,
    .join-dropdown.open .btn-join i { transform: rotate(180deg); }

    .dropdown-menu {
      position: absolute; top: calc(100% + 12px); right: 0;
      background: white; border-radius: 16px;
      box-shadow: 0 12px 40px rgba(0,0,0,0.14);
      min-width: 210px; overflow: hidden;
      opacity: 0; visibility: hidden; transform: translateY(-8px);
      transition: all 0.22s ease;
      z-index: 100;
    }
    .join-dropdown:hover .dropdown-menu,
    .join-dropdown.open .dropdown-menu {
      opacity: 1; visibility: visible; transform: translateY(0);
    }
    .dd-label {
      padding: 10px 16px 4px;
      font-size: 0.68rem; font-weight: 700; color: var(--text-light);
      letter-spacing: 0.09em; text-transform: uppercase;
      border-top: 1px solid #f0e6d3;
    }
    .dd-label:first-child { border-top: none; }
    .dd-item {
      display: flex; align-items: center; gap: 10px;
      padding: 9px 16px; font-size: 0.86rem;
      color: var(--text-dark);
      transition: background 0.18s;
    }
    .dd-item:hover { background: var(--cream); color: var(--primary); }
    .dd-item i { width: 15px; color: var(--primary-light); font-size: 0.78rem; }

    /* ─── COMMON LAYOUT ─────────────────────────────────── */
    .container { max-width: 1160px; margin: 0 auto; }
    section { padding: 88px 24px; }

    .section-header { text-align: center; margin-bottom: 52px; }
    .section-tag {
      display: inline-block;
      background: rgba(201,123,46,0.1); color: var(--primary);
      font-size: 0.72rem; font-weight: 700;
      letter-spacing: 0.1em; text-transform: uppercase;
      padding: 5px 14px; border-radius: 50px; margin-bottom: 10px;
    }
    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.7rem, 3vw, 2.4rem);
      color: var(--text-dark); margin-bottom: 12px;
    }
    .section-divider {
      width: 48px; height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--primary-light));
      border-radius: 3px; margin: 0 auto 14px;
    }
    .section-desc {
      font-size: 0.97rem; color: var(--text-mid);
      max-width: 540px; margin: 0 auto; line-height: 1.75;
    }

    /* Buttons */
    .btn-primary {
      display: inline-flex; align-items: center; gap: 8px;
      background: var(--primary); color: white;
      padding: 13px 26px; border-radius: 50px;
      font-weight: 600; font-size: 0.92rem;
      border: none; cursor: pointer;
      box-shadow: 0 4px 18px rgba(201,123,46,0.32);
      transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
    }
    .btn-primary:hover {
      background: var(--primary-dark); transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(201,123,46,0.42);
    }
    .btn-outline {
      display: inline-flex; align-items: center; gap: 8px;
      background: transparent; color: var(--primary);
      border: 2px solid var(--primary);
      padding: 11px 24px; border-radius: 50px;
      font-weight: 600; font-size: 0.92rem; cursor: pointer;
      transition: all var(--transition);
    }
    .btn-outline:hover { background: var(--primary); color: white; transform: translateY(-2px); }

    /* Scroll reveal */
    .reveal {
      opacity: 0; transform: translateY(28px);
      transition: opacity 0.65s ease, transform 0.65s ease;
    }
    .reveal.visible { opacity: 1; transform: none; }

    /* ─── HERO ──────────────────────────────────────────── */
    #home {
      min-height: 100vh;
      display: flex; align-items: center;
      padding-top: calc(var(--nav-h) + 40px);
      padding-bottom: 60px;
      padding-left: 24px; padding-right: 24px;
      position: relative; overflow: hidden;
    }
    .hero-bg {
      position: absolute; inset: 0; z-index: 0;
      background: linear-gradient(135deg, #faf4ec 0%, #f5e8d0 55%, #eedcb8 100%);
    }
    .hero-blob {
      position: absolute; border-radius: 50%;
      filter: blur(65px); opacity: 0.3; pointer-events: none;
    }
    .hero-blob-1 {
      width: 520px; height: 520px;
      background: radial-gradient(circle, #e8a44a, transparent 70%);
      top: -160px; right: -60px;
      animation: blobFloat 9s ease-in-out infinite;
    }
    .hero-blob-2 {
      width: 380px; height: 380px;
      background: radial-gradient(circle, #c97b2e, transparent 70%);
      bottom: -80px; right: 28%;
      animation: blobFloat 11s ease-in-out infinite reverse;
    }
    @keyframes blobFloat {
      0%,100% { transform: translateY(0) scale(1); }
      50%      { transform: translateY(-28px) scale(1.04); }
    }

    .hero-inner {
      max-width: 1160px; margin: 0 auto; width: 100%;
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 56px; align-items: center; position: relative; z-index: 1;
    }

    .hero-left { animation: slideUp .8s ease both; }
    .hero-right { animation: slideUp .8s .18s ease both; }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(36px); }
      to   { opacity: 1; transform: none; }
    }

    .hero-badge {
      display: inline-flex; align-items: center; gap: 7px;
      background: rgba(201,123,46,0.11); border: 1px solid rgba(201,123,46,0.24);
      border-radius: 50px; padding: 6px 14px;
      font-size: 0.76rem; font-weight: 600; color: var(--primary);
      margin-bottom: 18px; letter-spacing: 0.04em;
    }
    .hero-badge span {
      width: 7px; height: 7px; border-radius: 50%;
      background: var(--primary); display: inline-block;
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0%,100%{ box-shadow: 0 0 0 0 rgba(201,123,46,0.5); }
      50%    { box-shadow: 0 0 0 6px rgba(201,123,46,0); }
    }

    .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.1rem, 4vw, 3.3rem);
      line-height: 1.2; color: var(--text-dark); margin-bottom: 18px;
    }
    .hero-title span { color: var(--primary); }
    .hero-desc {
      font-size: 1rem; color: var(--text-mid);
      line-height: 1.78; max-width: 450px; margin-bottom: 32px;
    }
    .hero-btns { display: flex; gap: 12px; flex-wrap: wrap; }

    /* Hero right */
    .hero-card {
      background: linear-gradient(135deg, var(--primary) 0%, #b86820 100%);
      border-radius: 24px; overflow: hidden;
      aspect-ratio: 16/11; display: flex; align-items: center; justify-content: center;
      flex-direction: column; gap: 14px; position: relative;
      box-shadow: 0 16px 48px rgba(201,123,46,0.38);
    }
    .hero-card::before {
      content: ''; position: absolute; inset: 0;
      background: radial-gradient(circle at 70% 30%, rgba(255,255,255,0.15), transparent 60%);
    }
    .hero-logo-ring {
      width: 110px; height: 110px; border-radius: 50%;
      background: rgba(255,255,255,0.18);
      border: 3px solid rgba(255,255,255,0.45);
      display: flex; align-items: center; justify-content: center;
      animation: ringPulse 2.4s ease-in-out infinite;
      position: relative; z-index: 1;
    }
    @keyframes ringPulse {
      0%,100%{ box-shadow: 0 0 0 0 rgba(255,255,255,0.35); }
      50%    { box-shadow: 0 0 0 18px rgba(255,255,255,0); }
    }
    .hero-logo-ring i { font-size: 2.8rem; color: white; }
    .hero-card h3 {
      font-family: 'Playfair Display', serif; color: white;
      font-size: 1.6rem; position: relative; z-index: 1;
    }
    .hero-card p { color: rgba(255,255,255,0.78); font-size: 0.83rem; position: relative; z-index: 1; }

    .stats-row {
      display: grid; grid-template-columns: repeat(3, 1fr);
      gap: 12px; margin-top: 16px;
    }
    .stat-card {
      background: rgba(255,255,255,0.68);
      backdrop-filter: blur(14px);
      border: 1px solid rgba(201,123,46,0.2);
      border-radius: 16px; padding: 16px 10px; text-align: center;
      box-shadow: 0 4px 18px rgba(201,123,46,0.1),
                  inset 0 1px 0 rgba(255,255,255,0.75);
      transition: transform var(--transition), box-shadow var(--transition);
    }
    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 30px rgba(201,123,46,0.2);
    }
    .stat-number {
      font-family: 'Playfair Display', serif;
      font-size: 1.8rem; font-weight: 700; color: var(--primary); display: block;
    }
    .stat-label { font-size: 0.7rem; color: var(--text-light); font-weight: 500; margin-top: 3px; }

    /* ─── ABOUT ─────────────────────────────────────────── */
    #about { background: white; }
    .about-grid {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 56px; align-items: center;
    }
    .about-logo-box {
      background: linear-gradient(135deg, var(--cream), var(--cream-dark));
      border-radius: 24px; padding: 48px 36px;
      display: flex; flex-direction: column; align-items: center; gap: 18px;
      border: 2px solid rgba(201,123,46,0.14);
    }
    .about-circle {
      width: 120px; height: 120px; border-radius: 50%;
      background: white;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 12px 36px rgba(201,123,46,0.35);
      animation: float 4s ease-in-out infinite;
    }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
    .about-circle svg { width: 80px; height: 80px; }
    .about-logo-box h2 { font-family:'Playfair Display',serif; color:var(--primary); font-size:1.9rem; }
    .about-logo-box p { color:var(--text-light); font-size:0.83rem; text-align:center; }

    .about-content h3 { font-family:'Playfair Display',serif; font-size:1.7rem; margin-bottom:14px; }
    .about-content p { color:var(--text-mid); line-height:1.8; margin-bottom:12px; font-size:0.96rem; }
    .about-contact { margin-top:18px; display:flex; flex-direction:column; gap:7px; }
    .about-contact span { font-size:0.88rem; color:var(--text-mid); }
    .about-contact i { color:var(--primary); margin-right:8px; width:14px; }

    .mission-box {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border-radius: 20px; padding: 40px 44px;
      text-align: center; color: white; margin-top: 48px;
      box-shadow: 0 14px 44px rgba(201,123,46,0.32);
    }
    .mission-box h3 { font-family:'Playfair Display',serif; font-size:1.4rem; margin-bottom:12px; }
    .mission-box p { font-size:0.96rem; line-height:1.78; opacity:0.92; max-width:680px; margin:0 auto; }

    /* ─── WHO ───────────────────────────────────────────── */
    #who { background: var(--cream); }
    .who-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 22px;
    }
    .who-card {
      background: white; border-radius: var(--radius); padding: 34px 26px;
      text-align: center;
      border: 1px solid rgba(201,123,46,0.1);
      box-shadow: 0 4px 18px rgba(201,123,46,0.07);
      transition: transform var(--transition), box-shadow var(--transition);
    }
    .who-card:hover { transform: translateY(-8px); box-shadow: 0 16px 38px rgba(201,123,46,0.17); }
    .who-icon {
      width: 68px; height: 68px; border-radius: 50%;
      background: rgba(201,123,46,0.09); border: 2px solid rgba(201,123,46,0.15);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 20px;
    }
    .who-icon i { font-size: 1.6rem; color: var(--primary); }
    .who-card h3 { font-family:'Playfair Display',serif; font-size:1.15rem; margin-bottom:9px; }
    .who-card p { color:var(--text-mid); font-size:0.86rem; line-height:1.72; margin-bottom:22px; }

    /* ─── COURSES ────────────────────────────────────────── */
    #courses { background: white; }
    .courses-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 22px;
    }
    .course-card {
      background: white; border-radius: var(--radius);
      border: 1px solid rgba(201,123,46,0.1);
      box-shadow: 0 4px 16px rgba(201,123,46,0.07);
      overflow: hidden;
      transition: transform var(--transition), box-shadow var(--transition);
    }
    .course-card:hover { transform: translateY(-6px) scale(1.01); box-shadow: 0 14px 38px rgba(201,123,46,0.17); }
    .course-img { height: 170px; overflow: hidden; position: relative; }
    .course-img-bg {
      width:100%; height:100%;
      display:flex; align-items:center; justify-content:center;
      transition: transform 0.5s ease;
    }
    .course-card:hover .course-img-bg { transform: scale(1.07); }
    .course-img-bg i { font-size: 3.2rem; color: rgba(255,255,255,0.9); }
    .course-badge {
      position:absolute; top:10px; left:10px;
      background:rgba(255,255,255,0.92); color:var(--primary);
      font-size:0.68rem; font-weight:700; padding:3px 10px; border-radius:50px;
    }
    .course-body { padding: 18px; }
    .course-meta {
      display:flex; align-items:center; gap:10px;
      font-size:0.76rem; color:var(--text-light); margin-bottom:8px;
    }
    .course-meta i { color:var(--primary-light); }
    .course-card h3 { font-weight:600; font-size:0.97rem; margin-bottom:5px; }
    .course-card p { font-size:0.8rem; color:var(--text-mid); line-height:1.65; margin-bottom:12px; }
    .course-footer {
      display:flex; align-items:center; justify-content:space-between;
      padding-top:12px; border-top:1px solid var(--cream-dark);
    }
    .course-stars { color:#f59e0b; font-size:0.76rem; }
    .course-price { font-weight:700; color:var(--primary); font-size:0.9rem; }
    .btn-enroll {
      background:var(--primary); color:white; border:none; border-radius:8px;
      padding:7px 14px; font-size:0.76rem; font-weight:600; cursor:pointer;
      transition:background .2s, transform .2s;
    }
    .btn-enroll:hover { background:var(--primary-dark); transform:translateY(-1px); }
    .view-more-wrap { text-align:center; margin-top:38px; }

    /* ─── REVIEWS ────────────────────────────────────────── */
    #reviews { background: var(--cream); }

    .reviews-carousel {
      position: relative;
      overflow: hidden; /* clips cards outside the viewport window */
    }

    /* Sliding strip — width is set by JS to fit all cards */
    .reviews-track {
      display: flex;
      flex-wrap: nowrap;          /* single row, no wrapping */
      gap: 20px;
      transition: transform 0.52s cubic-bezier(.4,0,.2,1);
      will-change: transform;
    }

    /* Each card: exactly 1/3 of the carousel width minus gaps */
    .review-card {
      flex: 0 0 calc((100% - 40px) / 3); /* 3 visible, 2 gaps of 20px */
      min-width: 0;
      background: white;
      border-radius: var(--radius);
      padding: 24px 22px;
      box-shadow: 0 4px 20px rgba(201,123,46,0.08);
      border: 1px solid rgba(201,123,46,0.1);
      display: flex; flex-direction: column;
      transition: transform var(--transition), box-shadow var(--transition);
    }
    .review-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 32px rgba(201,123,46,0.16);
    }

    /* On tablet: show 2 at a time */
    @media (max-width: 860px) {
      .review-card { flex: 0 0 calc((100% - 20px) / 2); }
    }
    /* On phone: show 1 at a time */
    @media (max-width: 540px) {
      .review-card { flex: 0 0 100%; }
    }

    /* Wireframe-style header row */
    .review-header {
      display: flex; align-items: center; gap: 12px; margin-bottom: 12px;
    }
    .reviewer-avatar {
      width: 42px; height: 42px; border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--primary-light));
      display: flex; align-items: center; justify-content: center;
      color: white; font-weight: 700; font-size: 0.95rem;
      flex-shrink: 0;
    }
    .reviewer-meta { flex: 1; min-width: 0; }
    .reviewer-meta h4 { font-size: 0.92rem; font-weight: 600; line-height: 1.3; }
    .reviewer-meta .course-tag {
      font-size: 0.72rem; color: var(--primary); font-weight: 500; margin-top: 1px;
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    /* Role badge — top-right corner like wireframe */
    .role-pill {
      align-self: flex-start;
      background: rgba(201,123,46,0.1); color: var(--primary-dark);
      font-size: 0.65rem; font-weight: 700;
      padding: 3px 9px; border-radius: 50px;
      letter-spacing: 0.04em; text-transform: uppercase;
      white-space: nowrap; flex-shrink: 0;
    }
    .role-pill.provider { background: rgba(99,102,241,0.08); color: #4338ca; }

    .review-stars { color: #f59e0b; font-size: 1rem; margin-bottom: 8px; letter-spacing: 2px; }
    .review-text { font-size: 0.84rem; color: var(--text-mid); line-height: 1.72; flex: 1; }

    /* Controls: arrows + dots */
    .slider-controls {
      display: flex; justify-content: center; align-items: center;
      gap: 14px; margin-top: 34px;
    }
    .slider-btn {
      width: 42px; height: 42px; border-radius: 50%;
      border: 2px solid var(--primary); background: transparent;
      color: var(--primary); font-size: 0.95rem; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: all 0.22s;
    }
    .slider-btn:hover { background: var(--primary); color: white; transform: scale(1.1); }
    .slider-btn:disabled { opacity: 0.3; cursor: not-allowed; transform: none; }
    .slider-dots { display: flex; gap: 7px; }
    .dot {
      width: 8px; height: 8px; border-radius: 50%;
      background: rgba(201,123,46,0.25); cursor: pointer; transition: all .28s;
    }
    .dot.active { background: var(--primary); width: 22px; border-radius: 4px; }

    /* ─── WRITE A REVIEW ─────────────────────────────────── */
    #write-review { background: white; }
    .review-form-wrap {
      background: var(--cream);
      border: 1px solid rgba(201,123,46,0.16);
      border-radius: 24px; padding: 40px;
      max-width: 720px; margin: 0 auto;
    }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-size: 0.8rem; font-weight: 600; color: var(--text-mid); }
    .form-group input,
    .form-group select {
      padding: 11px 14px; border-radius: 10px;
      border: 1.5px solid rgba(201,123,46,0.22);
      background: white; font-family: 'DM Sans', sans-serif;
      font-size: 0.88rem; color: var(--text-dark); outline: none;
      transition: border-color .22s, box-shadow .22s;
    }
    .form-group input:focus,
    .form-group select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(201,123,46,0.1);
    }
    .form-group textarea {
      padding: 11px 14px; border-radius: 10px;
      border: 1.5px solid rgba(201,123,46,0.22);
      background: white; font-family: 'DM Sans', sans-serif;
      font-size: 0.88rem; color: var(--text-dark); outline: none;
      resize: vertical; min-height: 105px;
      transition: border-color .22s, box-shadow .22s;
    }
    .form-group textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(201,123,46,0.1); }

    /* Star picker */
    .star-picker { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 4px; }
    .star-picker input { display: none; }
    .star-picker label {
      font-size: 1.65rem; color: #d1c4a8; cursor: pointer;
      transition: color .18s, transform .18s;
    }
    .star-picker label:hover,
    .star-picker label:hover ~ label { color: #f59e0b; }
    .star-picker input:checked ~ label { color: #f59e0b; }

    .btn-submit {
      width: 100%; padding: 14px; border-radius: 50px;
      background: var(--primary); color: white; border: none;
      font-family: 'DM Sans', sans-serif; font-size: 0.97rem; font-weight: 600;
      cursor: pointer; margin-top: 10px;
      box-shadow: 0 4px 18px rgba(201,123,46,0.3);
      transition: background var(--transition), transform var(--transition);
    }
    .btn-submit:hover { background: var(--primary-dark); transform: translateY(-2px); }

    /* ─── FOOTER ─────────────────────────────────────────── */
    footer { background: var(--text-dark); color: white; padding: 56px 24px 28px; }
    .footer-inner {
      max-width: 1160px; margin: 0 auto;
      display: grid; grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 36px; padding-bottom: 36px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .footer-brand h3 {
      font-family: 'Playfair Display', serif; font-size: 1.4rem;
      color: var(--primary-light); margin-bottom: 10px;
      display: flex; align-items: center; gap: 9px;
    }
    .footer-brand p { color: rgba(255,255,255,0.55); font-size:0.85rem; line-height:1.76; max-width:250px; }
    .footer-socials { display:flex; gap:8px; margin-top:18px; }
    .social-btn {
      width:34px; height:34px; border-radius:8px;
      background:rgba(255,255,255,0.07); color:rgba(255,255,255,0.65);
      display:flex; align-items:center; justify-content:center;
      font-size:0.82rem; transition:background .22s, color .22s;
    }
    .social-btn:hover { background:var(--primary); color:white; }
    .footer-col h4 {
      font-size:0.78rem; font-weight:700; color:rgba(255,255,255,0.88);
      margin-bottom:14px; letter-spacing:.06em; text-transform:uppercase;
    }
    .footer-col ul { list-style:none; }
    .footer-col li { margin-bottom:7px; }
    .footer-col a {
      color:rgba(255,255,255,0.5); font-size:0.83rem;
      transition:color .2s;
    }
    .footer-col a:hover { color:var(--primary-light); }
    .footer-bottom {
      max-width:1160px; margin:22px auto 0;
      display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;
      font-size:0.76rem; color:rgba(255,255,255,0.35);
    }

    /* ─── TOAST ─────────────────────────────────────────── */
    .toast {
      position:fixed; bottom:28px; right:28px; z-index:9999;
      background:#1e1a14; color:white;
      padding:13px 22px; border-radius:12px;
      font-size:0.87rem; font-weight:500;
      box-shadow:0 8px 28px rgba(0,0,0,0.24);
      display:flex; align-items:center; gap:9px;
      transform:translateY(90px); opacity:0;
      transition:all .38s cubic-bezier(.4,0,.2,1);
    }
    .toast.show { transform:translateY(0); opacity:1; }
    .toast i { color:#4ade80; }

    /* ─── RESPONSIVE ─────────────────────────────────────── */
    /* Tablet */
    @media (max-width: 900px) {
      .hero-inner   { grid-template-columns: 1fr; gap: 36px; }
      .hero-left    { order: 1; }
      .hero-right   { order: 2; }
      .about-grid   { grid-template-columns: 1fr; gap: 32px; }
      .footer-inner { grid-template-columns: 1fr 1fr; }
    }

    /* Show hamburger on ≤768 */
    @media (max-width: 768px) {
      .nav-links, .join-dropdown { display: none; }
      .nav-hamburger { display: flex; }
      .nav-wrapper { width: calc(100% - 32px); top: 12px; }
      nav { border-radius: 20px; padding: 0 16px; }
    }
    @media (min-width: 769px) {
      .mobile-menu { display: none !important; }
    }

    /* Phone */
    @media (max-width: 580px) {
      section { padding: 64px 16px; }
      .hero-title { font-size: 1.9rem; }
      .stats-row  { grid-template-columns: repeat(3,1fr); gap: 8px; }
      .stat-number { font-size: 1.4rem; }
      .form-grid  { grid-template-columns: 1fr; }
      .review-form-wrap { padding: 24px 18px; }
      .mission-box { padding: 28px 22px; }
      .footer-inner { grid-template-columns: 1fr; }
      .footer-bottom { flex-direction: column; text-align: center; }
    }

    /* New review card entrance */
    @keyframes cardIn {
      from { opacity: 0; transform: scale(0.94) translateY(14px); }
      to   { opacity: 1; transform: none; }
    }
    .review-card.new { animation: cardIn .45s ease both; }
  </style>
</head>
<body>

<!-- ═══════════════════════════════════════════════════════
     FLOATING PILL NAVBAR
════════════════════════════════════════════════════════ -->
<div class="nav-wrapper">
  <nav id="navbar">
    <a href="#home" class="nav-logo">
      <div class="nav-logo-icon"><img src="assets/images/eduskill-logo.png" alt="EduSkill" style="width:30px;height:30px;object-fit:contain;border-radius:50%;display:block"></div>
      EduSkill
    </a>

    <!-- Desktop links -->
    <ul class="nav-links">
      <li><a href="#home" class="active">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="courses.php">Courses</a></li>
      <li><a href="#reviews">Reviews</a></li>
    </ul>

    <!-- Desktop join button -->
    <div class="join-dropdown">
      <button class="btn-join">Join Us <i class="fas fa-chevron-down"></i></button>
      <div class="dropdown-menu">
        <div class="dd-label">Login As</div>
        <a href="student/login.php" class="dd-item"><i class="fas fa-user-graduate"></i> Student</a>
        <a href="provider/login.php" class="dd-item"><i class="fas fa-chalkboard-teacher"></i> Training Provider</a>
        <a href="admin/login.php" class="dd-item"><i class="fas fa-user-shield"></i> Admin</a>
        <div class="dd-label">Sign Up</div>
        <a href="student/register.php" class="dd-item"><i class="fas fa-user-plus"></i> Student Registration</a>
        <a href="provider/register.php" class="dd-item"><i class="fas fa-building"></i> Provider Registration</a>
      </div>
    </div>

    <!-- Mobile hamburger -->
    <button class="nav-hamburger" id="hamburger" aria-label="Toggle menu">
      <span></span><span></span><span></span>
    </button>
  </nav>

  <!-- Mobile slide-down menu -->
  <div class="mobile-menu" id="mobileMenu">
    <a href="#home"        onclick="closeMobile()">Home</a>
    <a href="#about"       onclick="closeMobile()">About</a>
    <a href="courses.php" onclick="closeMobile()">Courses</a>
    <a href="#reviews"     onclick="closeMobile()">Reviews</a>
    <div class="mobile-divider"></div>
    <div class="mobile-section-label">Login As</div>
    <a href="student/login.php">As Student</a>
    <a href="provider/login.php">As Training Provider</a>
    <a href="admin/login.php">As Admin</a>
    <div class="mobile-divider"></div>
    <div class="mobile-section-label">Sign Up</div>
    <a href="student/register.php">Student Registration</a>
    <a href="provider/register.php">Provider Registration</a>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════════ -->
<section id="home">
  <div class="hero-bg">
    <div class="hero-blob hero-blob-1"></div>
    <div class="hero-blob hero-blob-2"></div>
  </div>
  <div class="hero-inner">
    <div class="hero-left">
      <div class="hero-badge"><span></span> Ministry of Education Initiative</div>
      <h1 class="hero-title">
        Elevate Your Potential with <span>EduSkill</span>.
      </h1>
      <p class="hero-desc">
        Discover certified courses and workshops from accredited training providers nationwide. Learn at your own pace, earn credentials, and advance your career.
      </p>
      <div class="hero-btns">
        <a href="student/login.php" class="btn-primary"><i class="fas fa-play-circle"></i> Start Learning</a>
        <a href="#courses" class="btn-outline">Browse Courses</a>
      </div>
    </div>
    <div class="hero-right">
      <div class="hero-card">
        <img src="assets/images/herosection.svg"
             alt="EduSkill – Elevate Your Potential"
             style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;z-index:0;border-radius:24px;background:transparent"/>
      </div>
      <div class="stats-row">
        <div class="stat-card">
          <span class="stat-number" data-target="90">0</span>
          <div class="stat-label">Courses Offered</div>
        </div>
        <div class="stat-card">
          <span class="stat-number" data-target="45">0</span>
          <div class="stat-label">Training Providers</div>
        </div>
        <div class="stat-card">
          <span class="stat-number" data-target="1200">0</span>
          <div class="stat-label">Students Enrolled</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ABOUT
════════════════════════════════════════════════════════ -->
<section id="about">
  <div class="container">
    <div class="section-header reveal">
      <span class="section-tag">Who We Are</span>
      <h2 class="section-title">About Our Platform</h2>
      <div class="section-divider"></div>
    </div>
    <div class="about-grid reveal">
      <div class="about-logo-box">
        <div class="about-circle"><img src="assets/images/eduskill-logo.png" alt="EduSkill" style="width:80px;height:80px;object-fit:contain"></div>
        <h2>EduSkill</h2>
        <p>Empowering Professionals Since 2024</p>
      </div>
      <div class="about-content">
        <h3>A Smarter Way to Learn &amp; Grow</h3>
        <p>EduSkill System (EMS) is a Ministry of Education initiative, designed to bridge the gap between skilled professionals and quality training providers. We connect learners with accredited courses, workshops, and certification programmes nationwide.</p>
        <p>Our platform lets approved training providers list and manage courses, while learners browse, enrol, and track progress — all in one place. Whether upskilling, reskilling, or exploring a new field, EduSkill has you covered.</p>
        <div class="about-contact">
          <span><i class="fas fa-envelope"></i> support@eduskill.gov.my</span>
          <span><i class="fas fa-phone"></i> +603-8000-1234</span>
          <span><i class="fas fa-map-marker-alt"></i> Ministry of Education, Putrajaya</span>
        </div>
      </div>
    </div>
    <div class="mission-box reveal">
      <h3><i class="fas fa-bullseye"></i> &nbsp;Our Mission</h3>
      <p>To empower every professional with accessible, high-quality, and affordable training — fostering a skilled, competitive, and future-ready workforce through technology, collaboration, and continuous learning.</p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     WHO CAN USE
════════════════════════════════════════════════════════ -->
<section id="who">
  <div class="container">
    <div class="section-header reveal">
      <span class="section-tag">Community</span>
      <h2 class="section-title">Who Can Use EduSkill?</h2>
      <div class="section-divider"></div>
      <p class="section-desc">Built for everyone in the learning ecosystem — from eager learners to experienced educators.</p>
    </div>
    <div class="who-grid">
      <div class="who-card reveal">
        <div class="who-icon"><i class="fas fa-user-graduate"></i></div>
        <h3>Students &amp; Learners</h3>
        <p>Browse certified courses, enrol online, and receive official receipts. Rate and review completed courses to help fellow learners make informed decisions.</p>
        <a href="student/register.php" class="btn-primary">Sign Up as Student</a>
      </div>
      <div class="who-card reveal" style="transition-delay:.1s">
        <div class="who-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <h3>Training Providers</h3>
        <p>Register your institution, list courses, and manage enrolments effortlessly. Generate monthly and yearly reports to grow your student base nationwide.</p>
        <a href="provider/register.php" class="btn-primary">Register as Provider</a>
      </div>
      <div class="who-card reveal" style="transition-delay:.2s">
        <div class="who-icon"><i class="fas fa-user-shield"></i></div>
        <h3>Ministry Officers</h3>
        <p>Review and approve provider registrations, oversee listings, and ensure platform quality standards are maintained across the platform.</p>
        <a href="admin/login.php" class="btn-primary">Admin Portal</a>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     POPULAR COURSES
════════════════════════════════════════════════════════ -->
<section id="courses">
  <div class="container">
    <div class="section-header reveal">
      <span class="section-tag">Featured</span>
      <h2 class="section-title">Popular Courses</h2>
      <div class="section-divider"></div>
      <p class="section-desc">Explore our most sought-after programmes from industry experts and accredited providers.</p>
    </div>
    <div class="courses-grid">
      <div class="course-card reveal">
        <div class="course-img">
          <div class="course-img-bg" style="background:none;padding:0">
            <img src="assets/images/technology.jpg" alt="Technology" style="width:100%;height:100%;object-fit:cover"/>
          </div>
          <span class="course-badge">Technology</span>
        </div>
        <div class="course-body">
          <div class="course-meta"><span><i class="fas fa-clock"></i> 8 Weeks</span><span><i class="fas fa-signal"></i> Beginner</span></div>
          <h3>Full-Stack Web Development</h3>
          <p>Master HTML, CSS, JavaScript, PHP & MySQL to build complete web applications from scratch.</p>
          <div class="course-footer">
            <div>
              <div class="course-stars">★★★★★ <span style="color:#9a8a6a;font-size:.72rem">(128)</span></div>
              <div class="course-price">RM 1500.0</div>
            </div>
            <button class="btn-enroll">Enroll Now</button>
          </div>
        </div>
      </div>
      <div class="course-card reveal" style="transition-delay:.1s">
        <div class="course-img">
          <div class="course-img-bg" style="background:none;padding:0">
            <img src="assets/images/design.jpg" alt="Design" style="width:100%;height:100%;object-fit:cover"/>
          </div>
          <span class="course-badge">Design</span>
        </div>
        <div class="course-body">
          <div class="course-meta"><span><i class="fas fa-clock"></i> 6 Weeks</span><span><i class="fas fa-signal"></i> Intermediate</span></div>
          <h3>UI/UX Design Fundamentals</h3>
          <p>Learn user research, wireframing, and prototyping to create outstanding digital experiences.</p>
          <div class="course-footer">
            <div>
              <div class="course-stars">★★★★★ <span style="color:#9a8a6a;font-size:.72rem">(96)</span></div>
              <div class="course-price">RM 1500.0</div>
            </div>
            <button class="btn-enroll">Enroll Now</button>
          </div>
        </div>
      </div>
      <div class="course-card reveal" style="transition-delay:.2s">
        <div class="course-img">
          <div class="course-img-bg" style="background:none;padding:0">
            <img src="assets/images/business.jpg" alt="Business" style="width:100%;height:100%;object-fit:cover"/>
          </div>
          <span class="course-badge">Business</span>
        </div>
        <div class="course-body">
          <div class="course-meta"><span><i class="fas fa-clock"></i> 4 Weeks</span><span><i class="fas fa-signal"></i> Beginner</span></div>
          <h3>Digital Marketing Mastery</h3>
          <p>From SEO and social media to paid ads — build a comprehensive digital marketing skill set.</p>
          <div class="course-footer">
            <div>
              <div class="course-stars">★★★★☆ <span style="color:#9a8a6a;font-size:.72rem">(74)</span></div>
              <div class="course-price">RM 1500.0</div>
            </div>
            <button class="btn-enroll">Enroll Now</button>
          </div>
        </div>
      </div>
    </div>
    <div class="view-more-wrap reveal">
      <a href="courses.php" class="btn-primary">View More Courses <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     REVIEWS
════════════════════════════════════════════════════════ -->
<section id="reviews">
  <div class="container">
    <div class="section-header reveal">
      <span class="section-tag">Testimonials</span>
      <h2 class="section-title">What Our Learners Say</h2>
      <div class="section-divider"></div>
    </div>

    <div class="reviews-carousel reveal">
      <div class="reviews-track" id="reviewsTrack">

        <div class="review-card">
          <div class="review-header">
            <div class="reviewer-avatar">AF</div>
            <div class="reviewer-meta">
              <h4>Ahmad Faris</h4>
              <div class="course-tag">Full-Stack Web Development</div>
            </div>
            <span class="role-pill">Student</span>
          </div>
          <div class="review-stars">★★★★★</div>
          <p class="review-text">EduSkill completely transformed my career path. The web development course was comprehensive, practical, and instructors were incredibly supportive throughout.</p>
        </div>

        <div class="review-card">
          <div class="review-header">
            <div class="reviewer-avatar">SN</div>
            <div class="reviewer-meta">
              <h4>Siti Nabilah</h4>
              <div class="course-tag">UI/UX Design Fundamentals</div>
            </div>
            <span class="role-pill">Student</span>
          </div>
          <div class="review-stars">★★★★★</div>
          <p class="review-text">The platform is very easy to navigate and course content is top-notch. I landed a UX designer role within 3 months of completing my course here!</p>
        </div>

        <div class="review-card">
          <div class="review-header">
            <div class="reviewer-avatar">TP</div>
            <div class="reviewer-meta">
              <h4>TechPro Academy</h4>
              <div class="course-tag">Digital Marketing Mastery</div>
            </div>
            <span class="role-pill provider">Provider</span>
          </div>
          <div class="review-stars">★★★★☆</div>
          <p class="review-text">As a training provider, EduSkill helped us reach thousands of learners we wouldn't have otherwise. The course management dashboard is intuitive and powerful.</p>
        </div>

        <div class="review-card">
          <div class="review-header">
            <div class="reviewer-avatar">RK</div>
            <div class="reviewer-meta">
              <h4>Rajesh Kumar</h4>
              <div class="course-tag">Full-Stack Web Development</div>
            </div>
            <span class="role-pill">Student</span>
          </div>
          <div class="review-stars">★★★★★</div>
          <p class="review-text">Best investment I've made in myself. The structured curriculum and real-world projects helped me build a portfolio that impressed every interviewer I met.</p>
        </div>

        <div class="review-card">
          <div class="review-header">
            <div class="reviewer-avatar">LH</div>
            <div class="reviewer-meta">
              <h4>LearnHub Malaysia</h4>
              <div class="course-tag">UI/UX Design Fundamentals</div>
            </div>
            <span class="role-pill provider">Provider</span>
          </div>
          <div class="review-stars">★★★★★</div>
          <p class="review-text">EduSkill made it seamless to list our courses and manage enrolments. The monthly enrolment report feature saves hours of manual work every month.</p>
        </div>

        <div class="review-card">
          <div class="review-header">
            <div class="reviewer-avatar">PM</div>
            <div class="reviewer-meta">
              <h4>Priya Menon</h4>
              <div class="course-tag">Digital Marketing Mastery</div>
            </div>
            <span class="role-pill">Student</span>
          </div>
          <div class="review-stars">★★★★☆</div>
          <p class="review-text">Really loved the flexibility of self-paced learning. The course material was up-to-date and practical assignments gave me real confidence to start freelancing.</p>
        </div>

      </div>

      <div class="slider-controls">
        <button class="slider-btn" id="revPrev" onclick="reviewSlide(-1)"><i class="fas fa-chevron-left"></i></button>
        <div class="slider-dots" id="revDots"></div>
        <button class="slider-btn" id="revNext" onclick="reviewSlide(1)"><i class="fas fa-chevron-right"></i></button>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     WRITE A REVIEW
════════════════════════════════════════════════════════ -->
<section id="write-review">
  <div class="container">
    <div class="section-header reveal">
      <span class="section-tag">Share Your Experience</span>
      <h2 class="section-title">Write a Review</h2>
      <div class="section-divider"></div>
      <p class="section-desc">Completed a course? Help fellow learners by sharing your honest feedback.</p>
    </div>
    <div class="review-form-wrap reveal">
      <div class="form-grid">
        <div class="form-group">
          <label>Your Name</label>
          <input type="text" id="rName" placeholder="E.g. Ahmad Faris"/>
        </div>
        <div class="form-group">
          <label>Course Name</label>
          <input type="text" id="rCourse" placeholder="E.g. UI/UX Design"/>
        </div>
        <div class="form-group">
          <label>Your Role</label>
          <select id="rRole">
            <option value="">— Choose —</option>
            <option value="Student">Student</option>
            <option value="Training Provider">Training Provider</option>
          </select>
        </div>
        <div class="form-group">
          <label>Rating</label>
          <div class="star-picker">
            <input type="radio" name="r" id="r5" value="5"><label for="r5">★</label>
            <input type="radio" name="r" id="r4" value="4"><label for="r4">★</label>
            <input type="radio" name="r" id="r3" value="3"><label for="r3">★</label>
            <input type="radio" name="r" id="r2" value="2"><label for="r2">★</label>
            <input type="radio" name="r" id="r1" value="1"><label for="r1">★</label>
          </div>
        </div>
      </div>
      <div class="form-group" style="margin-bottom:18px">
        <label>Your Review</label>
        <textarea id="rText" placeholder="Share what you liked, learned, or suggest improvements..."></textarea>
      </div>
      <button class="btn-submit" onclick="submitReview()">
        <i class="fas fa-paper-plane"></i> &nbsp;Submit Review
      </button>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     FOOTER
════════════════════════════════════════════════════════ -->
<footer>
  <div class="footer-inner">
    <div class="footer-brand">
      <h3><img src="assets/images/eduskill-logo.png" alt="EduSkill" style="height:22px;width:22px;object-fit:contain;vertical-align:middle;margin-right:4px"> EduSkill</h3>
      <p>A Ministry of Education initiative connecting professionals with quality training and upskilling opportunities nationwide.</p>
      <div class="footer-socials">
        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
        <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
        <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" class="social-btn"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="courses.php">All Courses</a></li>
        <li><a href="#reviews">Reviews</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>For Learners</h4>
      <ul>
        <li><a href="student/register.php">Student Registration</a></li>
        <li><a href="student/login.php">Student Login</a></li>
        <li><a href="courses.php">Browse Courses</a></li>
        <li><a href="#">Enrolment Guide</a></li>
        <li><a href="#">FAQs</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Contact Us</h4>
      <ul>
        <li><a href="#"><i class="fas fa-envelope" style="color:var(--primary-light);margin-right:5px"></i> support@eduskill.gov.my</a></li>
        <li><a href="#"><i class="fas fa-phone"   style="color:var(--primary-light);margin-right:5px"></i> +603-8000-1234</a></li>
        <li><a href="#"><i class="fas fa-map-marker-alt" style="color:var(--primary-light);margin-right:5px"></i> Putrajaya</a></li>
        <li><a href="#"><i class="fas fa-clock"   style="color:var(--primary-light);margin-right:5px"></i> Mon–Fri, 9am–5pm</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© 2025 EduSkill System · Ministry of Education</span>
    <span>Privacy Policy &nbsp;·&nbsp; Terms of Service</span>
  </div>
</footer>

<!-- Toast -->
<div class="toast" id="toast"><i class="fas fa-check-circle"></i><span id="toastMsg"></span></div>

<!-- ═══════════════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════════════ -->
<script>
/* ── Navbar scroll shadow ── */
window.addEventListener('scroll', () => {
  document.getElementById('navbar').classList.toggle('scrolled', scrollY > 10);
});

/* ── Active nav link ── */
const sections = ['home','about','who','courses','reviews','write-review'];
window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(id => {
    const el = document.getElementById(id);
    if (el && scrollY >= el.offsetTop - 100) current = id;
  });
  document.querySelectorAll('.nav-links a').forEach(a => {
    a.classList.toggle('active', a.getAttribute('href') === '#' + current);
  });
});

/* ── Hamburger ── */
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('open');
  mobileMenu.classList.toggle('open');
});
function closeMobile() {
  hamburger.classList.remove('open');
  mobileMenu.classList.remove('open');
}

/* ── Scroll reveal ── */
const revealObs = new IntersectionObserver((entries) => {
  entries.forEach((e, i) => {
    if (e.isIntersecting) {
      setTimeout(() => e.target.classList.add('visible'), i * 70);
      revealObs.unobserve(e.target);
    }
  });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

/* ── Counter animation ── */
function animateCounters() {
  document.querySelectorAll('.stat-number[data-target]').forEach(el => {
    const target = +el.dataset.target;
    let c = 0;
    const step = Math.ceil(target / 55);
    const iv = setInterval(() => {
      c = Math.min(c + step, target);
      el.textContent = c + '+';
      if (c >= target) clearInterval(iv);
    }, 22);
  });
}
new IntersectionObserver((entries) => {
  if (entries[0].isIntersecting) { animateCounters(); }
}, { threshold: 0.4 }).observe(document.querySelector('.stats-row'));

/* ── Review Carousel ── */
let revIdx = 0;

function getPerSlide() {
  if (window.innerWidth <= 540) return 1;
  if (window.innerWidth <= 860) return 2;
  return 3;
}

function buildRevDots() {
  const cards = document.querySelectorAll('#reviewsTrack .review-card');
  const pages = Math.ceil(cards.length / getPerSlide());
  const container = document.getElementById('revDots');
  container.innerHTML = '';
  for (let i = 0; i < pages; i++) {
    const d = document.createElement('div');
    d.className = 'dot' + (i === revIdx ? ' active' : '');
    d.onclick = () => goRevSlide(i);
    container.appendChild(d);
  }
}

function goRevSlide(idx) {
  const cards = document.querySelectorAll('#reviewsTrack .review-card');
  const per   = getPerSlide();
  const pages = Math.ceil(cards.length / per);
  revIdx = Math.max(0, Math.min(idx, pages - 1));

  // Width of one card + gap
  const card      = cards[0];
  const gap       = 20;
  const slideW    = card.offsetWidth + gap;
  const offset    = revIdx * per * slideW;

  document.getElementById('reviewsTrack').style.transform = `translateX(-${offset}px)`;

  // dots
  document.querySelectorAll('#revDots .dot').forEach((d, i) => d.classList.toggle('active', i === revIdx));

  // arrow states
  document.getElementById('revPrev').disabled = revIdx === 0;
  document.getElementById('revNext').disabled = revIdx >= pages - 1;
}

function reviewSlide(dir) { goRevSlide(revIdx + dir); }

// Init on load + resize
function initCarousel() {
  revIdx = 0;
  buildRevDots();
  goRevSlide(0);
}
window.addEventListener('load',   initCarousel);
window.addEventListener('resize', initCarousel);

/* ── Review submit ── */
function submitReview() {
  const name   = document.getElementById('rName').value.trim();
  const course = document.getElementById('rCourse').value.trim();
  const role   = document.getElementById('rRole').value;
  const text   = document.getElementById('rText').value.trim();
  const rEl    = document.querySelector('input[name="r"]:checked');

  if (!name || !course || !role || !text || !rEl) {
    showToast('Please fill in all fields and select a rating.', false); return;
  }

  const rating = +rEl.value;
  const stars  = '★'.repeat(rating) + '☆'.repeat(5 - rating);
  const init   = name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
  const isProvider = role === 'Training Provider';

  const card = document.createElement('div');
  card.className = 'review-card new';
  card.innerHTML = `
    <div class="review-header">
      <div class="reviewer-avatar">${init}</div>
      <div class="reviewer-meta">
        <h4>${name}</h4>
        <div class="course-tag">${course}</div>
      </div>
      <span class="role-pill${isProvider ? ' provider' : ''}">${isProvider ? 'Provider' : 'Student'}</span>
    </div>
    <div class="review-stars">${stars}</div>
    <p class="review-text">${text}</p>
  `;
  document.getElementById('reviewsTrack').appendChild(card);

  // reset form
  ['rName','rCourse','rText'].forEach(id => document.getElementById(id).value = '');
  document.getElementById('rRole').value = '';
  document.querySelectorAll('input[name="r"]').forEach(r => r.checked = false);

  // jump to last page to show new card
  const cards = document.querySelectorAll('#reviewsTrack .review-card');
  const pages = Math.ceil(cards.length / getPerSlide());
  initCarousel();
  setTimeout(() => goRevSlide(pages - 1), 50);
  showToast('Thank you! Your review has been added.', true);
}

/* ── Toast ── */
function showToast(msg, ok) {
  const t = document.getElementById('toast');
  t.querySelector('i').className = ok ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
  t.querySelector('i').style.color = ok ? '#4ade80' : '#fb923c';
  document.getElementById('toastMsg').textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3400);
}

// Redirect logged-in users to their dashboard
(function(){var r=localStorage.getItem("edu_role");if(r){var m={student:"student/dashboard.php",provider:"provider/dashboard.php",admin:"admin/dashboard.php"};if(m[r])window.location.href=m[r];}})();
</script>
</body>
</html>
