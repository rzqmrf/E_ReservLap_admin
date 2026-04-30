@extends('layouts.user')

@section('styles')
<style>
    .profile-header {
        background: var(--white);
        padding: 40px 20px;
        text-align: center;
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
        box-shadow: var(--shadow);
        margin-bottom: 30px;
    }

    .avatar-wrapper {
        width: 100px;
        height: 100px;
        background: var(--primary-light);
        border-radius: 50%;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 40px;
        border: 4px solid var(--white);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .profile-header h2 {
        font-size: 22px;
        margin-bottom: 5px;
    }

    .profile-header p {
        font-size: 14px;
        color: var(--text-gray);
    }

    .profile-menu {
        padding: 0 20px;
    }

    .menu-group {
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
    }

    .menu-item-row {
        display: flex;
        align-items: center;
        padding: 18px 20px;
        text-decoration: none;
        color: var(--text-dark);
        border-bottom: 1px solid #f7f7f7;
        transition: background 0.3s;
    }

    .menu-item-row:last-child { border-bottom: none; }
    .menu-item-row:active { background: #f9f9f9; }

    .menu-item-row i {
        width: 35px;
        font-size: 18px;
        color: var(--primary);
    }

    .menu-item-row span {
        flex-grow: 1;
        font-size: 15px;
        font-weight: 500;
    }

    .menu-item-row .fa-chevron-right {
        font-size: 12px;
        color: #CBD5E0;
    }

    .logout-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 15px;
        background: #FFF5F5;
        color: #F56565;
        border: none;
        border-radius: 15px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div class="profile-header">
    <div class="avatar-wrapper">
        <i class="fa-solid fa-user"></i>
    </div>
    <h2>{{ Auth::user()->name }}</h2>
    <p>{{ Auth::user()->email }}</p>
    <div class="badge badge-success" style="margin-top: 10px;">{{ ucfirst(Auth::user()->role) }}</div>
</div>

<div class="profile-menu">
    <div class="menu-group">
        <a href="#" class="menu-item-row">
            <i class="fa-solid fa-user-pen"></i>
            <span>Edit Profil</span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <a href="#" class="menu-item-row">
            <i class="fa-solid fa-bell"></i>
            <span>Notifikasi</span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <a href="#" class="menu-item-row">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Keamanan Akun</span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>

    <div class="menu-group">
        <a href="#" class="menu-item-row">
            <i class="fa-solid fa-circle-question"></i>
            <span>Bantuan & FAQ</span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <a href="#" class="menu-item-row">
            <i class="fa-solid fa-circle-info"></i>
            <span>Tentang Aplikasi</span>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Keluar Akun</span>
        </button>
    </form>
</div>
@endsection