/* ═══════════════════════════════════════════
   Roadbard — theme management
   shared/theme.js
   ═══════════════════════════════════════════ */
(function () {
  'use strict';

  var KEY = 'roadbard-theme';

  function applyPref(pref) {
    if (pref === 'light' || pref === 'dark') {
      document.documentElement.setAttribute('data-theme', pref);
    } else {
      // 'system' — remove manual override; CSS media query takes over
      document.documentElement.removeAttribute('data-theme');
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    var sel = document.getElementById('theme-select');
    if (!sel) return;

    // Sync select to stored preference
    var stored = 'system';
    try { stored = localStorage.getItem(KEY) || 'system'; } catch (e) {}
    sel.value = stored;

    // Handle manual changes
    sel.addEventListener('change', function () {
      var pref = this.value;
      try { localStorage.setItem(KEY, pref); } catch (e) {}
      applyPref(pref);
    });
  });

  // Re-evaluate when OS preference changes (only matters in system mode)
  try {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
      try {
        var stored = localStorage.getItem(KEY);
        if (!stored || stored === 'system') {
          applyPref('system');
        }
      } catch (e) {}
    });
  } catch (e) {}

}());
