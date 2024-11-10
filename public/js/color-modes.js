/*!
 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
 * Copyright 2011-2024 The Bootstrap Authors
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 */

(() => {
  'use strict';

  /**
   * Retrieves the stored theme from localStorage.
   *
   * @returns {string|null} The stored theme, or null if not set.
   */
  const getStoredTheme = () => localStorage.getItem('theme');

  /**
   * Stores the given theme in localStorage.
   *
   * @param {string} theme - The theme to store.
   */
  const setStoredTheme = theme => localStorage.setItem('theme', theme);

  /**
   * Determines the preferred theme based on stored theme or system preference.
   *
   * @returns {string} The preferred theme ('dark' or 'light').
   */
  const getPreferredTheme = () => {
    const storedTheme = getStoredTheme();
    if (storedTheme) {
      return storedTheme;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  };

  /**
   * Sets the theme by updating the `data-bs-theme` attribute on the document element.
   *
   * @param {string} theme - The theme to set ('auto', 'dark', or 'light').
   */
  const setTheme = theme => {
    if (theme === 'auto') {
      document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'));
    } else {
      document.documentElement.setAttribute('data-bs-theme', theme);
    }
  };

  // Set the initial theme based on the preferred theme
  setTheme(getPreferredTheme());

  /**
   * Updates the active theme display and accessibility attributes.
   *
   * @param {string} theme - The active theme.
   * @param {boolean} [focus=false] - Whether to focus the theme switcher element.
   */
  const showActiveTheme = (theme, focus = false) => {

    //-------------------------------------------------------------------------
    // Custom code to change the theme icon in TeamCal Neo
    //
    const myActiveThemeIcon = document.querySelector('.theme-icon-active');
    myActiveThemeIcon.className = '';
    switch (theme) {
      case 'light':
        myActiveThemeIcon.classList.add('theme-icon-active', 'bi-sun-fill');
        break;
      case 'dark':
        myActiveThemeIcon.classList.add('theme-icon-active', 'bi-moon-stars-fill');
        break;
      default:
        myActiveThemeIcon.classList.add('theme-icon-active', 'bi-circle-half');
        break;
    }
    // End custom code
    //-------------------------------------------------------------------------

    const themeSwitcher = document.querySelector('#bd-theme');
    if (!themeSwitcher) {
      return;
    }

    const themeSwitcherText = document.querySelector('#bd-theme-text');
    const activeThemeIcon = document.querySelector('.theme-icon-active use');
    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`);
    const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href');

    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
      element.classList.remove('active');
      element.setAttribute('aria-pressed', 'false');
    });
    btnToActive.classList.add('active');
    btnToActive.setAttribute('aria-pressed', 'true');
    activeThemeIcon.setAttribute('href', svgOfActiveBtn);
    const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`;
    themeSwitcher.setAttribute('aria-label', themeSwitcherLabel);

    if (focus) {
      themeSwitcher.focus();
    }
  };

  // Listen for changes in the system's color scheme preference
  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const storedTheme = getStoredTheme();
    if (storedTheme !== 'light' && storedTheme !== 'dark') {
      setTheme(getPreferredTheme());
    }
  });

  // Initialize theme switcher on DOMContentLoaded
  window.addEventListener('DOMContentLoaded', () => {
    showActiveTheme(getPreferredTheme());

    document.querySelectorAll('[data-bs-theme-value]')
      .forEach(toggle => {
        toggle.addEventListener('click', () => {
          const theme = toggle.getAttribute('data-bs-theme-value');
          setStoredTheme(theme);
          setTheme(theme);
          showActiveTheme(theme, true);
        });
      });
  });
})();
