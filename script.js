/**
 * Bibledoc Modern Theme Scripts
 */

(function() {
    'use strict';

    // Mobile Menu Toggle
    function initMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const primaryMenu = document.querySelector('.primary-menu');

        if (mobileToggle && primaryMenu) {
            mobileToggle.addEventListener('click', function() {
                primaryMenu.classList.toggle('active');
                this.setAttribute('aria-expanded', 
                    this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
                );
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.nav-menu-wrapper') && !event.target.closest('.mobile-menu-toggle')) {
                    primaryMenu.classList.remove('active');
                    if (mobileToggle) {
                        mobileToggle.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        }
    }

    // Dark Mode Toggle
    function initDarkMode() {
        const darkModeToggle = document.querySelector('.dark-mode-toggle');
        const body = document.body;
        const html = document.documentElement;

        // Check for saved dark mode preference
        const darkMode = localStorage.getItem('darkMode');
        if (darkMode === 'enabled') {
            body.classList.add('dark-mode');
            html.classList.add('dark-mode');
            if (darkModeToggle) {
                darkModeToggle.textContent = '☀️';
            }
        }

        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', function() {
                const isDarkMode = body.classList.contains('dark-mode');

                if (isDarkMode) {
                    // Turn off dark mode
                    body.classList.remove('dark-mode');
                    html.classList.remove('dark-mode');
                    body.removeAttribute('data-theme');
                    html.removeAttribute('data-theme');
                    darkModeToggle.textContent = '🌙';
                    localStorage.setItem('darkMode', 'disabled');
                } else {
                    // Turn on dark mode
                    body.classList.add('dark-mode');
                    html.classList.add('dark-mode');
                    body.setAttribute('data-theme', 'dark');
                    html.setAttribute('data-theme', 'dark');
                    darkModeToggle.textContent = '☀️';
                    localStorage.setItem('darkMode', 'enabled');
                }

                // Force immediate repaint using multiple techniques
                requestAnimationFrame(function() {
                    // Force style recalculation
                    void document.body.offsetHeight;

                    // Force repaint on all major containers
                    const containers = document.querySelectorAll('body, .main-navigation, .hero-section, .site-footer, .post-card, article, .widget, .post-content');
                    containers.forEach(function(el) {
                        if (el) {
                            el.style.display = 'none';
                            void el.offsetHeight;
                            el.style.display = '';
                        }
                    });
                });
            });
        }
    }

    // Back to Top Button
    function initBackToTop() {
        const backToTop = document.querySelector('.back-to-top');
        
        if (!backToTop) return;

        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        // Scroll to top on click
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Reading Progress Bar
    function initReadingProgress() {
        const progressBar = document.querySelector('.reading-progress');
        
        if (!progressBar) return;

        window.addEventListener('scroll', function() {
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollPercent = (scrollTop / (documentHeight - windowHeight)) * 100;
            
            progressBar.style.width = scrollPercent + '%';
        });
    }

    // Filter and Sort
    function initFilterSort() {
        const filterSelect = document.querySelector('.filter-select');
        const sortSelect = document.querySelector('.sort-select');

        if (filterSelect) {
            filterSelect.addEventListener('change', function() {
                const category = this.value;
                const currentUrl = new URL(window.location.href);
                
                if (category === 'all') {
                    currentUrl.searchParams.delete('post_category');
                } else {
                    currentUrl.searchParams.set('post_category', category);
                }
                
                window.location.href = currentUrl.toString();
            });
        }

        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sort = this.value;
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('post_sort', sort);
                window.location.href = currentUrl.toString();
            });
        }
    }

    // View Toggle
    function initViewToggle() {
        const gridViewBtn = document.querySelector('.view-grid');
        const listViewBtn = document.querySelector('.view-list');
        const postsGrid = document.querySelector('.posts-grid');

        if (!gridViewBtn || !listViewBtn || !postsGrid) return;

        // Check for saved view preference
        const savedView = localStorage.getItem('viewMode');
        if (savedView === 'list') {
            postsGrid.classList.add('list-view');
            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
        }

        gridViewBtn.addEventListener('click', function() {
            postsGrid.classList.remove('list-view');
            this.classList.add('active');
            listViewBtn.classList.remove('active');
            localStorage.setItem('viewMode', 'grid');
        });

        listViewBtn.addEventListener('click', function() {
            postsGrid.classList.add('list-view');
            this.classList.add('active');
            gridViewBtn.classList.remove('active');
            localStorage.setItem('viewMode', 'list');
        });
    }

    // Lazy Load Images
    function initLazyLoad() {
        const images = document.querySelectorAll('img[data-src]');
        
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(function(img) {
            imageObserver.observe(img);
        });
    }

    // Smooth Scroll for Anchor Links
    function initSmoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (href === '#') return;
                
                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    // Sticky Header
    function initStickyHeader() {
        const header = document.querySelector('.main-navigation');
        if (!header) return;

        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > lastScroll && currentScroll > 100) {
                // Scrolling down
                header.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                header.style.transform = 'translateY(0)';
            }

            lastScroll = currentScroll;
        });
    }

    // Social Share Popup
    function initSocialShare() {
        const shareLinks = document.querySelectorAll('.social-share a');
        
        shareLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                const width = 600;
                const height = 400;
                const left = (screen.width - width) / 2;
                const top = (screen.height - height) / 2;
                
                window.open(
                    url,
                    'share',
                    'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top
                );
            });
        });
    }

    // Search Enhancement
    function initSearchEnhancement() {
        const searchInput = document.querySelector('.search-input');
        
        if (!searchInput) return;

        // Add loading state
        const searchForm = searchInput.closest('form');
        if (searchForm) {
            searchForm.addEventListener('submit', function() {
                searchInput.setAttribute('disabled', 'disabled');
                searchInput.value = 'Searching...';
            });
        }

        // Clear button
        if (searchInput.value) {
            const clearBtn = document.createElement('button');
            clearBtn.type = 'button';
            clearBtn.className = 'search-clear';
            clearBtn.innerHTML = '×';
            clearBtn.setAttribute('aria-label', 'Clear search');
            
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                searchInput.focus();
                this.remove();
            });
            
            searchInput.parentNode.appendChild(clearBtn);
        }

        searchInput.addEventListener('input', function() {
            const clearBtn = this.parentNode.querySelector('.search-clear');
            if (this.value && !clearBtn) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'search-clear';
                btn.innerHTML = '×';
                btn.setAttribute('aria-label', 'Clear search');
                
                btn.addEventListener('click', function() {
                    searchInput.value = '';
                    searchInput.focus();
                    this.remove();
                });
                
                this.parentNode.appendChild(btn);
            } else if (!this.value && clearBtn) {
                clearBtn.remove();
            }
        });
    }

    // Accessibility: Skip to Content
    function initSkipLink() {
        const skipLink = document.querySelector('.skip-link');
        
        if (skipLink) {
            skipLink.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.setAttribute('tabindex', '-1');
                    target.focus();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }
    }

    // Initialize all functions when DOM is ready
    function init() {
        initMobileMenu();
        initDarkMode();
        initBackToTop();
        initReadingProgress();
        initFilterSort();
        initViewToggle();
        initLazyLoad();
        initSmoothScroll();
        initStickyHeader();
        initSocialShare();
        initSearchEnhancement();
        initSkipLink();
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
