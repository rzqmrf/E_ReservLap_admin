<nav class="navbar">
    <div class="logo">reserv</div>
    <ul class="nav-links">
        <li><a href="/">Home</a></li>
        <li><a href="/about">About</a></li>
        <li><a href="/features">Features</a></li>
        <li><a href="/contact">Contact</a></li>

        {{-- Dropdown Admin --}}
        <li class="dropdown">
            <a href="#" class="dropdown-toggle">
                Admin ▾
            </a>
            <ul class="dropdown-menu">
                <li><a href="/users-page">👤 Users</a></li>
                <li><a href="/fields">🏟️ Fields</a></li>
            </ul>
        </li>
    </ul>
</nav>

<style>
/* ── DROPDOWN ────────────────────────────────────────── */
.dropdown {
    position: relative;
}

.dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 6px;
    min-width: 160px;
    box-shadow: var(--shadow-lg);
    list-style: none;
    z-index: 200;

    /* animasi */
    opacity: 0;
    transform: translateY(-8px);
    transition: opacity var(--transition), transform var(--transition);
}

/* segitiga kecil di atas dropdown */
.dropdown-menu::before {
    content: '';
    position: absolute;
    top: -6px;
    right: 16px;
    width: 10px;
    height: 10px;
    background: var(--surface);
    border-left: 1px solid var(--border);
    border-top: 1px solid var(--border);
    transform: rotate(45deg);
}

.dropdown:hover .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

.dropdown-menu li a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 14px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-2);
    border-radius: var(--radius-sm);
    transition: background var(--transition), color var(--transition);
}

.dropdown-menu li a:hover {
    background: var(--primary-lt);
    color: var(--primary-dk);
}

/* rotasi arrow saat hover */
.dropdown:hover .dropdown-toggle {
    color: var(--primary-dk);
    background: var(--primary-lt);
}
</style>
