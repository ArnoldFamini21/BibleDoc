/**
 * Bibledoc Modern Theme JavaScript
 * Author: Pastor Arnold Famini
 * Version: 1.0.23
 * Description: Interactive features including mobile menu and search functionality
 */

(function() {
    'use strict';

    /**
     * Initialize all header actions and mobile navigation
     */
    function initHeaderActions() {
        // Desktop search bar elements
        const searchBtn = document.querySelector('.header-search-toggle');
        const searchBar = document.querySelector('.header-search-bar');
        const closeSearch = document.querySelector('.search-close');
        
        // Mobile menu elements
        const menuBtn = document.querySelector('.mobile-menu-toggle');
        const menuIcon = menuBtn ? menuBtn.querySelector('.menu-icon') : null;
        const primaryMenu = document.querySelector('.primary-menu');
        const mobileOverlay = document.querySelector('.mobile-overlay');
        
        // Mobile search modal elements
        const searchModal = document.querySelector('.mobile-search-modal');
        const searchModalClose = document.querySelector('.mobile-search-close');
        const searchModalInput = searchModal ? searchModal.querySelector('input[type="search"]') : null;

        /**
         * Desktop Header Search Toggle
         */
        if (searchBtn && searchBar) {
            searchBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // If on mobile, open mobile search modal instead
                if (window.innerWidth <= 1024) {
                    toggleMobileSearch();
                } else {
                    searchBar.classList.add('active');
                    setTimeout(() => {
                        const input = searchBar.querySelector('input');
                        if (input) input.focus();
                    }, 100);
                }
            });
        }

        if (closeSearch && searchBar) {
            closeSearch.addEventListener('click', function(e) {
                e.preventDefault();
                searchBar.classList.remove('active');
            });
        }

        /**
         * Mobile Menu Toggle
         */
        function toggleMenu() {
            if (!primaryMenu) return;
            
            primaryMenu.classList.toggle('active');
            mobileOverlay.classList.toggle('active');
            menuBtn.classList.toggle('active');
            
            if (primaryMenu.classList.contains('active')) {
                if (menuIcon) menuIcon.textContent = '✕';
                document.body.style.overflow = 'hidden';
            } else {
                if (menuIcon) menuIcon.textContent = '☰';
                document.body.style.overflow = '';
            }
        }

        function closeMenu() {
            if (!primaryMenu) return;
            
            primaryMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
            menuBtn.classList.remove('active');
            if (menuIcon) menuIcon.textContent = '☰';
            document.body.style.overflow = '';
        }

        if (menuBtn && primaryMenu) {
            menuBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMenu();
            });
        }

        // Close menu when clicking overlay
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function() {
                closeMenu();
                closeMobileSearch();
            });
        }

        // Close menu when clicking menu links
        if (primaryMenu) {
            const menuLinks = primaryMenu.querySelectorAll('a');
            menuLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    // Only close if it's not a parent menu item
                    if (!link.parentElement.classList.contains('menu-item-has-children')) {
                        closeMenu();
                    }
                });
            });
        }

        /**
         * Mobile Search Modal
         */
        function toggleMobileSearch() {
            if (!searchModal) return;
            
            searchModal.classList.toggle('active');
            
            if (searchModal.classList.contains('active')) {
                setTimeout(function() {
                    if (searchModalInput) searchModalInput.focus();
                }, 300);
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        function closeMobileSearch() {
            if (!searchModal) return;
            
            searchModal.classList.remove('active');
            document.body.style.overflow = '';
            if (searchModalInput) searchModalInput.value = '';
        }

        // Mobile search modal close button
        if (searchModalClose) {
            searchModalClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeMobileSearch();
            });
        }

        // Close search modal when clicking outside
        if (searchModal) {
            searchModal.addEventListener('click', function(e) {
                if (e.target === searchModal) {
                    closeMobileSearch();
                }
            });
        }

        /**
         * Keyboard Navigation
         */
        document.addEventListener('keydown', function(e) {
            // Escape key
            if (e.key === 'Escape' || e.keyCode === 27) {
                // Close desktop search bar
                if (searchBar && searchBar.classList.contains('active')) {
                    searchBar.classList.remove('active');
                }
                
                // Close mobile menu
                if (primaryMenu && primaryMenu.classList.contains('active')) {
                    closeMenu();
                }
                
                // Close mobile search modal
                if (searchModal && searchModal.classList.contains('active')) {
                    closeMobileSearch();
                }
            }
        });

        /**
         * Window Resize Handler
         */
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // Close mobile menu if window is resized to desktop size
                if (window.innerWidth > 1024) {
                    closeMenu();
                    closeMobileSearch();
                    
                    // Reset menu icon
                    if (menuIcon) menuIcon.textContent = '☰';
                }
            }, 250);
        });
    }

    /**
     * Initialize when DOM is ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeaderActions);
    } else {
        initHeaderActions();
    }

    /**
     * Back to Top Button (if it exists)
     */
    document.addEventListener('DOMContentLoaded', function() {
        const backToTop = document.querySelector('.back-to-top');
        
        if (backToTop) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('visible');
                } else {
                    backToTop.classList.remove('visible');
                }
            });
            
            backToTop.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    });

})();
