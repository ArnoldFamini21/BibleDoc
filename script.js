/**
 * Bibledoc Modern Theme Scripts
 */

(function() {
    'use strict';

    function initHeaderActions() {
        // Search Toggle
        const searchBtn = document.querySelector('.header-search-toggle');
        const searchBar = document.querySelector('.header-search-bar');
        const closeSearch = document.querySelector('.search-close');

        if (searchBtn && searchBar) {
            searchBtn.addEventListener('click', function() {
                searchBar.classList.add('active');
                // Focus input
                setTimeout(() => {
                    searchBar.querySelector('input').focus();
                }, 100);
            });
        }

        if (closeSearch && searchBar) {
            closeSearch.addEventListener('click', function() {
                searchBar.classList.remove('active');
            });
        }

        // Mobile Menu Toggle
        const menuBtn = document.querySelector('.mobile-menu-toggle');
        const menuIcon = menuBtn ? menuBtn.querySelector('.menu-icon') : null;
        const primaryMenu = document.querySelector('.primary-menu');

        if (menuBtn && primaryMenu) {
            menuBtn.addEventListener('click', function() {
                primaryMenu.classList.toggle('active');
                
                // Toggle Icon
                if (primaryMenu.classList.contains('active')) {
                    if(menuIcon) menuIcon.textContent = '✕';
                } else {
                    if(menuIcon) menuIcon.textContent = '☰';
                }
            });
        }
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeaderActions);
    } else {
        initHeaderActions();
    }

})();
