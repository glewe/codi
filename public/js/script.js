/*!
 * @package LeAF CI4
 * @since 4.0.0
 * @author George Lewe <george@lewe.com>
 * @copyright Copyright (c) 2024 by George Lewe
 * @link https://www.lewe.com
 */
const sidebarToggle = document.querySelector('.sidebar-toggle');

if (sidebarToggle) {
  sidebarToggle.addEventListener('click', function() {
    const eleSidebar = document.querySelector('#sidebar');
    const eleNavbar = document.querySelector('#navbar');
    const eleMain = document.querySelector('#main');

    if (eleSidebar) {
      eleSidebar.classList.toggle('expand');
    }
    if (eleNavbar) {
      eleNavbar.classList.toggle('expand');
    }
    if (eleMain) {
      eleMain.classList.toggle('expand');
    }
  });
}
