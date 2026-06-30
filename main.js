/* B. Service LP — main.js (WordPress) */
(function () {
  'use strict';
  var SERVICES = (window.B_DATA && window.B_DATA.services) ? window.B_DATA.services : [];
  var svcColor = {job:'var(--c-job)',site:'var(--c-site)',media:'var(--c-media)',film:'var(--c-film)',gbp:'var(--c-gbp)',ai:'var(--c-ai)'};
  var svcLabel = {job:'Boost JOB',site:'Boost SITE',media:'Boost MEDIA',film:'Boost FILM',gbp:'Boost GBP',ai:'Boost AI'};
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isTouch = window.matchMedia('(max-width:820px)').matches;

  /* ---- services switcher ---- */
  var svRail = document.getElementById('svRail');
  var svPanels = document.getElementById('svPanels');
  var panels = [], railBtns = [];
  if (svRail && svPanels && SERVICES.length) {
    SERVICES.forEach(function (s, i) {
      var btn = document.createElement('button');
      btn.innerHTML = '<span class="num">0' + (i + 1) + '</span>' + s.name;
      svRail.appendChild(btn);
      var p = document.createElement('div');
      p.className = 'sv-panel';
      p.innerHTML =
        '<span class="sv-bignum">0' + (i + 1) + '</span>' +
        '<span class="sv-tag" style="--svc:' + s.color + '">' + s.name + '<span class="role">／ ' + s.role + '</span></span>' +
        '<h3 class="sv-catch">' + s.catch + '</h3>' +
        '<p class="sv-body">' + s.body + '</p>' +
        '<div class="sv-feats">' + (s.feats || []).map(function (f) { return '<span>' + f + '</span>'; }).join('') + '</div>';
      svPanels.appendChild(p);
    });
    panels = [].slice.call(svPanels.children);
    railBtns = [].slice.call(svRail.children);
  }

  function setSvc(i) {
    if (!SERVICES[i]) return;
    var c = SERVICES[i].color;
    document.documentElement.style.setProperty('--svc', c);
    panels.forEach(function (p, k) { p.classList.toggle('on', k === i); });
    railBtns.forEach(function (b, k) { b.classList.toggle('on', k === i); });
    var g = document.getElementById('svGlow');
    if (g) g.style.background = 'radial-gradient(circle,' + c + ' 0%,transparent 62%)';
  }

  /* ---- cases: filter + modal (server-rendered) ---- */
  var caseGrid = document.getElementById('caseGrid');
  var caseFilter = document.getElementById('caseFilter');
  var cards = caseGrid ? [].slice.call(caseGrid.querySelectorAll('.case-card')) : [];

  if (caseFilter && cards.length) {
    var present = {};
    cards.forEach(function (c) { present[c.dataset.svc] = true; });
    var filters = [{ k: '', l: 'すべて' }];
    ['job','site','media','film','gbp','ai'].forEach(function (k) {
      if (present[k]) filters.push({ k: k, l: svcLabel[k].replace('Boost ', '') });
    });
    filters.forEach(function (f, i) {
      var b = document.createElement('button');
      b.textContent = f.l;
      if (i === 0) b.classList.add('on');
      b.onclick = function () {
        caseFilter.querySelectorAll('button').forEach(function (x) { x.classList.remove('on'); });
        b.classList.add('on');
        cards.forEach(function (c) { c.style.display = (!f.k || c.dataset.svc === f.k) ? '' : 'none'; });
      };
      caseFilter.appendChild(b);
    });
  }

  var modal = document.getElementById('modal');
  function openModal(d) {
    var color = svcColor[d.svc] || 'var(--blue)';
    modal.style.setProperty('--cc', color);
    var mThumb = document.getElementById('mThumb');
    if (d.thumb) { mThumb.style.backgroundImage = 'url(' + d.thumb + ')'; mThumb.style.backgroundSize = 'cover'; mThumb.textContent = ''; }
    else { mThumb.style.backgroundImage = ''; mThumb.style.background = 'linear-gradient(135deg,' + color + ',var(--ink))'; mThumb.textContent = (d.company || '').slice(0, 1); }
    var mSvc = document.getElementById('mSvc');
    mSvc.querySelector('span').textContent = d.label || svcLabel[d.svc];
    mSvc.style.color = color;
    mSvc.querySelector('i').style.background = color;
    document.getElementById('mInd').textContent = [d.ind, d.area].filter(Boolean).join('・');
    document.getElementById('mName').textContent = d.company || '';
    document.getElementById('mDesc').textContent = d.desc || '';
    var res = document.getElementById('mRes');
    if (d.res) { res.style.display = ''; res.textContent = '成果：' + d.res;
      res.style.background = 'color-mix(in srgb,' + color + ' 12%,transparent)';
      res.style.borderColor = 'color-mix(in srgb,' + color + ' 35%,transparent)';
    } else res.style.display = 'none';
    var link = document.getElementById('mLink');
    if (d.url) { link.style.display = 'inline-flex'; link.href = d.url; link.style.color = color; } else link.style.display = 'none';
    modal.classList.add('open'); document.body.style.overflow = 'hidden';
  }
  function closeModal() { if (!modal) return; modal.classList.remove('open'); document.body.style.overflow = ''; }
  cards.forEach(function (c) {
    c.addEventListener('click', function () {
      openModal({ svc: c.dataset.svc, company: c.dataset.company, ind: c.dataset.ind, area: c.dataset.area,
        res: c.dataset.res, desc: c.dataset.desc, url: c.dataset.url, label: c.dataset.label, thumb: c.dataset.thumb });
    });
  });
  if (modal) {
    document.getElementById('modalX').onclick = closeModal;
    document.getElementById('modalBd').onclick = closeModal;
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });
  }

  /* ---- voice carousel ---- */
  var vt = document.getElementById('voiceTrack');
  if (vt) {
    var vn = document.getElementById('vNext'), vp = document.getElementById('vPrev');
    if (vn) vn.onclick = function () { vt.scrollBy({ left: vt.clientWidth * 0.7, behavior: 'smooth' }); };
    if (vp) vp.onclick = function () { vt.scrollBy({ left: -vt.clientWidth * 0.7, behavior: 'smooth' }); };
    var dr = false, sx = 0, sl = 0;
    vt.addEventListener('pointerdown', function (e) { dr = true; sx = e.clientX; sl = vt.scrollLeft; vt.classList.add('drag'); });
    window.addEventListener('pointerup', function () { dr = false; vt.classList.remove('drag'); });
    window.addEventListener('pointermove', function (e) { if (dr) vt.scrollLeft = sl - (e.clientX - sx); });
  }

  /* ---- floaters ---- */
  var floaters = document.getElementById('floaters');
  if (floaters && SERVICES.length) {
    SERVICES.forEach(function (s, i) {
      var sp = document.createElement('span');
      sp.textContent = s.name;
      sp.style.left = (8 + (i * 15) % 80) + '%';
      sp.style.top = (15 + (i * 23) % 70) + '%';
      floaters.appendChild(sp);
    });
  }

  /* ---- reveal ---- */
  var io = new IntersectionObserver(function (es) {
    es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
  }, { threshold: 0.15 });
  document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });

  var flowIo = new IntersectionObserver(function (es) {
    es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in'); flowIo.unobserve(e.target); } });
  }, { threshold: 0.4 });
  document.querySelectorAll('.flow-row').forEach(function (el) { flowIo.observe(el); });

  /* ---- nav ---- */
  var nav = document.getElementById('nav');
  window.addEventListener('scroll', function () { nav.classList.toggle('scrolled', window.scrollY > 40); }, { passive: true });
  var navToggle = document.getElementById('navtoggle'), navLinks = document.getElementById('navlinks');
  if (navToggle) {
    navToggle.onclick = function () { navToggle.classList.toggle('open'); navLinks.classList.toggle('open'); };
    navLinks.querySelectorAll('a').forEach(function (a) { a.onclick = function () { navToggle.classList.remove('open'); navLinks.classList.remove('open'); }; });
  }

  /* ---- counters ---- */
  function runCounters() {
    document.querySelectorAll('.cnt').forEach(function (el) {
      var to = +el.dataset.to, t0 = performance.now(), dur = 1600;
      function step(t) { var p = Math.min((t - t0) / dur, 1), e = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.round(to * e); if (p < 1) requestAnimationFrame(step); }
      requestAnimationFrame(step);
    });
  }
  var counted = false, achEl = document.getElementById('ach');
  if (achEl) new IntersectionObserver(function (es) {
    es.forEach(function (e) { if (e.isIntersecting && !counted) { counted = true; runCounters(); } });
  }, { threshold: 0.4 }).observe(achEl);

  /* ---- GSAP ---- */
  window.addEventListener('load', function () {
    var h1lines = document.querySelectorAll('#heroH1 .ln > span');
    if (window.gsap) {
      if (!reduce) gsap.to(h1lines, { y: '0%', duration: 1.1, ease: 'power3.out', stagger: 0.12, delay: 0.15 });
      else gsap.set(h1lines, { y: '0%' });
    }

    if (window.gsap && window.ScrollTrigger) {
      gsap.registerPlugin(ScrollTrigger);

      if (!reduce) {
        gsap.utils.toArray('.aurora').forEach(function (a) {
          var pr = parseFloat(a.dataset.par) || 0.1;
          gsap.to(a, { yPercent: pr * 100, ease: 'none', scrollTrigger: { trigger: '#top', start: 'top top', end: 'bottom top', scrub: true } });
        });
        gsap.utils.toArray('#floaters span').forEach(function (s, i) {
          gsap.to(s, { y: (i % 2 ? -60 : 60), x: (i % 2 ? 30 : -30), ease: 'none', scrollTrigger: { trigger: '#top', start: 'top top', end: 'bottom top', scrub: true } });
        });
      }

      var servicesSec = document.getElementById('services');
      if (panels.length) {
        setSvc(0);
        if (!reduce && !isTouch) {
          var steps = SERVICES.length, cur = 0;
          ScrollTrigger.create({
            trigger: '#services', start: 'top top',
            end: function () { return '+=' + (steps * window.innerHeight); },
            pin: '#svStage', scrub: 0.4,
            onUpdate: function (self) {
              var i = Math.max(0, Math.min(steps - 1, Math.floor(self.progress * steps)));
              if (i !== cur) { cur = i; setSvc(i); }
            }
          });
          railBtns.forEach(function (b, i) {
            b.onclick = function () {
              var top = servicesSec.offsetTop + (i + 0.5) / steps * (steps * window.innerHeight);
              window.scrollTo({ top: top, behavior: 'smooth' });
            };
          });
        } else {
          servicesSec.classList.add('stacked');
          panels.forEach(function (p) { p.classList.add('on'); });
          var so = new IntersectionObserver(function (es) {
            es.forEach(function (e) { if (e.isIntersecting) {
              var idx = panels.indexOf(e.target);
              if (idx > -1) document.documentElement.style.setProperty('--svc', SERVICES[idx].color);
            } });
          }, { threshold: 0.5 });
          panels.forEach(function (p) { so.observe(p); });
        }
      }
      ScrollTrigger.refresh();
    }

    if (!reduce && !isTouch) {
      document.querySelectorAll('.mag').forEach(function (el) {
        el.addEventListener('pointermove', function (e) {
          var r = el.getBoundingClientRect();
          var x = e.clientX - r.left - r.width / 2, y = e.clientY - r.top - r.height / 2;
          el.style.transform = 'translate(' + x * 0.25 + 'px,' + y * 0.35 + 'px)';
        });
        el.addEventListener('pointerleave', function () { el.style.transform = ''; });
      });
    }
  });
})();
