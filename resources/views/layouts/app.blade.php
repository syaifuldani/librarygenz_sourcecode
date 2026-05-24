<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LibraryGenz') }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full bg-cream-50 text-navy-900">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

            <!-- Sidebar Navigation -->
            @include('layouts.sidebar')

            <!-- Main Content Container -->
            <div class="flex-1 flex flex-col min-h-screen min-w-0 lg:ml-64">
                <!-- Top Navbar -->
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-cream-100/50 border-b border-cream-300 py-6 px-6 sm:px-8">
                        <div class="max-w-7xl">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>

                <!-- Footer -->
                <footer class="py-6 px-8 border-t border-cream-300 bg-cream-100/20 text-xs text-navy-400 text-center">
                    &copy; {{ date('Y') }} LibraryGenz. Warm Editorial Library Management.
                </footer>
            </div>
        </div>

        <!-- ============================================================
             TOAST NOTIFICATION SYSTEM (Alpine.js)
             Reads session flash: success, error, warning, info
        ============================================================ -->
        <div
            x-data="toastSystem()"
            class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none"
            style="max-width: 22rem;"
            aria-live="polite"
        >
            <template x-for="toast in toasts" :key="toast.id">
                <div
                    x-show="toast.visible"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-8"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-8"
                    :class="toastClass(toast.type)"
                    class="pointer-events-auto flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg border text-sm font-medium w-full"
                    role="alert"
                >
                    <!-- Icon -->
                    <span class="shrink-0 mt-0.5" x-html="toastIcon(toast.type)"></span>
                    <!-- Message -->
                    <span class="flex-1 text-xs leading-relaxed" x-text="toast.message"></span>
                    <!-- Close -->
                    <button @click="dismiss(toast.id)" class="shrink-0 opacity-60 hover:opacity-100 transition-opacity ml-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <!-- Confirmation Modal (global, triggered via Alpine) -->
        <div
            x-data="confirmModal()"
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @confirm-modal.window="show($event.detail)"
            class="fixed inset-0 z-[9998] flex items-center justify-center p-4"
            style="display:none;"
        >
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-navy-950/60 backdrop-blur-sm" @click="cancel()"></div>
            <!-- Dialog -->
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="relative bg-cream-50 border border-cream-300 rounded-2xl shadow-xl p-6 w-full max-w-sm z-10"
            >
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-coral-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-coral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-serif text-base font-bold text-navy-900" x-text="title"></h3>
                        <p class="text-xs text-navy-500 mt-1 leading-relaxed" x-text="message"></p>
                    </div>
                </div>
                <div class="flex gap-3 mt-6 justify-end">
                    <button @click="cancel()" class="px-4 py-2 text-xs font-bold border border-cream-300 rounded-lg text-navy-700 hover:bg-cream-200/50 transition-colors">
                        Batal
                    </button>
                    <button @click="confirm()" :class="dangerMode ? 'bg-coral-500 hover:bg-coral-600' : 'bg-navy-800 hover:bg-navy-900'" class="px-4 py-2 text-xs font-bold rounded-lg text-white transition-colors">
                        <span x-text="confirmLabel"></span>
                    </button>
                </div>
            </div>
        </div>

        @php
            $flashSuccess = session('success');
            $flashError   = session('error');
            $flashWarning = session('warning');
            $flashInfo    = session('info');
        @endphp

        <script>
            // Toast system
            function toastSystem() {
                return {
                    toasts: [],
                    counter: 0,
                    init() {
                        @if($flashSuccess) this.add('success', @js($flashSuccess)); @endif
                        @if($flashError)   this.add('error',   @js($flashError));   @endif
                        @if($flashWarning) this.add('warning', @js($flashWarning)); @endif
                        @if($flashInfo)    this.add('info',    @js($flashInfo));    @endif
                    },
                    add(type, message) {
                        if (this.toasts.some(t => t.message === message && t.visible)) {
                            return;
                        }
                        const id = ++this.counter;
                        this.toasts.push({ id, type, message, visible: true });
                        setTimeout(() => this.dismiss(id), 5000);
                    },
                    dismiss(id) {
                        const t = this.toasts.find(t => t.id === id);
                        if (t) t.visible = false;
                        setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 300);
                    },
                    toastClass(type) {
                        return {
                            success: 'bg-emerald-50 border-emerald-200 text-emerald-900',
                            error:   'bg-coral-50 border-coral-200 text-coral-900',
                            warning: 'bg-amber-50 border-amber-200 text-amber-900',
                            info:    'bg-blue-50 border-blue-200 text-blue-900',
                        }[type] || 'bg-cream-50 border-cream-300 text-navy-900';
                    },
                    toastIcon(type) {
                        const icons = {
                            success: '<svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                            error:   '<svg class="w-4 h-4 text-coral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                            warning: '<svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
                            info:    '<svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                        };
                        return icons[type] || icons.info;
                    }
                };
            }

            // Confirmation modal
            function confirmModal() {
                return {
                    open: false,
                    title: '',
                    message: '',
                    confirmLabel: 'Ya, Lanjutkan',
                    dangerMode: true,
                    _resolve: null,
                    _form: null,
                    show(detail) {
                        this.title        = detail.title   || 'Konfirmasi Tindakan';
                        this.message      = detail.message || 'Apakah Anda yakin?';
                        this.confirmLabel = detail.confirmLabel || 'Ya, Lanjutkan';
                        this.dangerMode   = detail.danger !== false;
                        this._form        = detail.form   || null;
                        this.open = true;
                    },
                    confirm() {
                        this.open = false;
                        if (this._form) {
                            setTimeout(() => this._form.submit(), 150);
                        }
                    },
                    cancel() { this.open = false; }
                };
            }

            // Helper: trigger confirm modal from any form
            function confirmAction(form, title, message, confirmLabel, danger) {
                window.dispatchEvent(new CustomEvent('confirm-modal', {
                    detail: { title, message, confirmLabel: confirmLabel || 'Ya, Lanjutkan', danger: danger !== false, form }
                }));
            }
        </script>
    </body>
</html>
