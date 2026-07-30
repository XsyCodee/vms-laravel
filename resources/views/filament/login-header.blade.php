{{-- Inject CSRF token — fix for empty data-csrf on Livewire --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    // Force Livewire to re-read CSRF
    document.addEventListener('livewire:init', () => {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        if (token && (!window.Livewire || !window.Livewire.csrf)) {
            Livewire.csrf = token;
        }
    });
    // Also patch the meta tag if it's empty
    document.addEventListener('DOMContentLoaded', () => {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta && !meta.content && typeof Livewire !== 'undefined') {
            Livewire.csrf = '{{ csrf_token() }}';
        }
    });
</script>

{{-- Logo Header --}}
<div style="text-align: center; margin-bottom: 28px;">
    <div style="
        width: 56px; height: 56px; border-radius: 14px;
        background: linear-gradient(135deg, #7C3AED 0%, #6366F1 100%);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
        box-shadow: 0 4px 16px rgba(124, 58, 237, 0.3);
    ">
        <span style="color: #fff; font-size: 24px; font-weight: 800;">V</span>
    </div>
    <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
        ProDC <span style="color: #7C3AED;">VMS</span>
    </h1>
    <p style="font-size: 14px; color: #64748b; margin: 0;">
        Sign in to your enterprise dashboard
    </p>
</div>

<style>
    .fi-simple-layout {
        background-image: url('/background_login.jpg') !important;
        background-size: cover !important;
        background-position: center !important;
        position: relative !important;
    }
    .fi-simple-layout::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(circle, rgba(15, 23, 42, 0.5) 0%, rgba(15, 23, 42, 0.85) 100%);
        pointer-events: none; z-index: 0;
    }
    .fi-simple-main {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(20px) !important;
        border-radius: 20px !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
        position: relative !important; z-index: 1 !important;
        padding: 40px !important;
    }
    .fi-btn.fi-btn-primary {
        background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%) !important;
        border-radius: 10px !important; font-weight: 700 !important;
        box-shadow: 0 2px 8px rgba(124,58,237,.25) !important;
        transition: all .2s ease !important;
    }
    .fi-btn.fi-btn-primary:hover {
        box-shadow: 0 4px 16px rgba(124,58,237,.35) !important;
        transform: translateY(-1px) !important;
    }
    .fi-input:focus-within {
        --tw-ring-color: #A78BFA !important;
        border-color: #7C3AED !important;
    }
    .fi-simple-header { display: none !important; }
</style>
