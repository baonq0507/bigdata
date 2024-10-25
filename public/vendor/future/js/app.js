import Cookies from 'js-cookie';

let navbarSearch = document.querySelector('.navbar-search');

if (navbarSearch) {
    let input = navbarSearch.querySelector('input');
    let result = navbarSearch.querySelector('.form-results');
    let resultForceDisplay = false;

    if (input && result) { // Ensure both elements exist before attaching event listeners
        function showResult() {
            result.classList.add('d-block');
            result.classList.remove('d-none');
        }

        function hideResult() {
            if (!resultForceDisplay) {
                result.classList.remove('d-block');
                result.classList.add('d-none');
            }
        }

        input.addEventListener('focus', showResult);
        result.addEventListener('mouseover', () => {
            resultForceDisplay = true;
            showResult();
        });

        result.addEventListener('click', () => {
            resultForceDisplay = true;
            showResult();
        });

        document.addEventListener('click', (e) => {
            const isClickInside = input.contains(e.target) || result.contains(e.target);
            if (!isClickInside) {
                resultForceDisplay = false;
                hideResult();
            }
        });
    }
}

if (!Cookies.get("sidebarState")) {
    Cookies.set("sidebarState", "expanded", {
        expires: 7,
        sameSite: 'Lax'
    });
}

const collapseMenuBtn = document.getElementById('btn-collapse-menu');
const sidebarWrapper = document.getElementById('sidebar-wrapper');
const pageWrapper = document.getElementById('page-wrapper');

if (collapseMenuBtn && sidebarWrapper && pageWrapper) { // Check all elements before using them
    collapseMenuBtn.addEventListener('click', function () {
        sidebarWrapper.classList.toggle('state-collapsed');
        pageWrapper.classList.toggle('state-collapsed');
        this.classList.toggle('state-collapsed');

        if (sidebarWrapper.classList.contains('state-collapsed')) {
            Cookies.set("sidebarState", "collapsed", {
                expires: 7,
                sameSite: 'Lax'
            });
        } else {
            console.log(Cookies.set("sidebarState", "expanded", {
                expires: 7,
                sameSite: 'Lax'
            }))
        }
    });
}
document.addEventListener('DOMContentLoaded', function () {
    var darkModeToggle = document.getElementById('dark-mode-toggle');
    var lightModeToggle = document.getElementById('light-mode-toggle');

    function setTheme(theme) {
        document.body.setAttribute('data-bs-theme', theme);
        localStorage.setItem('tablerTheme', theme);
    }

    darkModeToggle.addEventListener('click', function (event) {
        event.preventDefault(); // Ngăn không cho URL thay đổi
        setTheme('dark');
    });

    lightModeToggle.addEventListener('click', function (event) {
        event.preventDefault(); // Ngăn không cho URL thay đổi
        setTheme('light');
    });

    // Load theme hiện tại từ localStorage
    var currentTheme = localStorage.getItem('tablerTheme') || 'light';
    setTheme(currentTheme);
});
