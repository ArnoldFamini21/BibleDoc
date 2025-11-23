(function() {
    'use strict';

    function initHeaderActions() {
        const searchBtn = document.querySelector('.header-search-toggle');
        const searchBar = document.querySelector('.header-search-bar');
        const closeSearch = document.querySelector('.search-close');
        const menuBtn = document.querySelector('.mobile-menu-toggle');
        const menuIcon = menuBtn ? menuBtn.querySelector('.menu-icon') : null;
        const primaryMenu = document.querySelector('.primary-menu');

        if (searchBtn && searchBar) {
            searchBtn.addEventListener('click', function() {
                searchBar.classList.add('active');
                setTimeout(() => searchBar.querySelector('input').focus(), 100);
            });
        }

        if (closeSearch && searchBar) {
            closeSearch.addEventListener('click', function() {
                searchBar.classList.remove('active');
            });
        }

        if (menuBtn && primaryMenu) {
            menuBtn.addEventListener('click', function() {
                primaryMenu.classList.toggle('active');
                if (primaryMenu.classList.contains('active')) {
                    if(menuIcon) menuIcon.textContent = '✕';
                    document.body.style.overflow = 'hidden'; // Lock scroll
                } else {
                    if(menuIcon) menuIcon.textContent = '☰';
                    document.body.style.overflow = '';
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeaderActions);
    } else {
        initHeaderActions();
    }
})();
