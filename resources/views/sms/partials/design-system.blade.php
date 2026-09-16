{{-- SMS Design System - Shared Styles --}}
<style>
    /* ============================================
       SMS DESIGN SYSTEM
       ============================================ */
    
    /* ES-SCHOOLS Brand Colors - Deep Navy + Fresh Green */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');
    
    :root {
        /* Brand Colors - Deep Navy + Fresh Green */
        --sms-primary: #1e3a8a;           /* Deep Navy Blue */
        --sms-primary-dark: #1e40af;      /* Navy Dark */
        --sms-primary-light: #3b82f6;     /* Navy Light */
        --sms-accent: #10b981;            /* Fresh Green */
        --sms-accent-dark: #059669;       /* Green Dark */
        --sms-accent-light: #34d399;      /* Green Light */
        --sms-secondary: #10b981;         /* Green (Secondary) */
        --sms-success: #10b981;           /* Success Green */
        --sms-warning: #f59e0b;           /* Warning Amber */
        --sms-danger: #ef4444;            /* Error Red */
        --sms-info: #3b82f6;              /* Info Blue */
        
        --sms-gray-50: #f9fafb;
        --sms-gray-100: #f3f4f6;
        --sms-gray-200: #e5e7eb;
        --sms-gray-300: #d1d5db;
        --sms-gray-400: #9ca3af;
        --sms-gray-500: #6b7280;
        --sms-gray-600: #4b5563;
        --sms-gray-700: #374151;
        --sms-gray-800: #1f2937;
        --sms-gray-900: #111827;
        
        --sms-white: #ffffff;
        --sms-shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --sms-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --sms-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --sms-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --sms-shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        
        --sms-radius-sm: 0.375rem;
        --sms-radius: 0.5rem;
        --sms-radius-md: 0.75rem;
        --sms-radius-lg: 1rem;
        --sms-radius-xl: 1.5rem;
        
        --sms-spacing-xs: 0.5rem;
        --sms-spacing-sm: 0.75rem;
        --sms-spacing: 1rem;
        --sms-spacing-md: 1.5rem;
        --sms-spacing-lg: 2rem;
        --sms-spacing-xl: 3rem;
    }
    
    /* Premium Typography - Poppins + Inter */
    .sms-body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--sms-gray-800);
        line-height: 1.7;
        font-size: 1rem;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    
    .sms-h1 {
        font-size: 2.25rem;
        font-weight: 800;
        line-height: 1.2;
        color: var(--sms-gray-900);
        letter-spacing: -0.02em;
    }
    
    .sms-h2 {
        font-size: 1.875rem;
        font-weight: 700;
        line-height: 1.3;
        color: var(--sms-gray-900);
        letter-spacing: -0.01em;
    }
    
    .sms-h3 {
        font-size: 1.5rem;
        font-weight: 600;
        line-height: 1.4;
        color: var(--sms-gray-900);
    }
    
    .sms-h4 {
        font-size: 1.25rem;
        font-weight: 600;
        line-height: 1.4;
        color: var(--sms-gray-900);
    }
    
    .sms-text-sm {
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    .sms-text-xs {
        font-size: 0.75rem;
        line-height: 1.5;
    }
    
    /* Cards */
    .sms-card {
        background: var(--sms-white);
        border-radius: var(--sms-radius-lg);
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
        transition: all 0.2s ease;
    }
    
    .sms-card:hover {
        box-shadow: var(--sms-shadow-md);
    }
    
    .sms-card-header {
        padding: var(--sms-spacing-md) var(--sms-spacing-lg);
        border-bottom: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .sms-card-body {
        padding: var(--sms-spacing-lg);
    }
    
    .sms-card-footer {
        padding: var(--sms-spacing-md) var(--sms-spacing-lg);
        border-top: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
    }
    
    /* Stat Cards */
    .sms-stat-card {
        background: var(--sms-white);
        border-radius: var(--sms-radius-lg);
        padding: var(--sms-spacing-lg);
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .sms-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--sms-primary), var(--sms-accent));
    }
    
    .sms-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--sms-shadow-lg);
    }
    
    .sms-stat-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--sms-radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: var(--sms-spacing);
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        color: var(--sms-white);
    }
    
    .sms-stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1;
        margin-bottom: var(--sms-spacing-xs);
    }
    
    .sms-stat-label {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
        font-weight: 500;
    }
    
    /* Buttons */
    .sms-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: var(--sms-spacing-xs);
        padding: 0.625rem 1.25rem;
        font-size: 0.9375rem;
        font-weight: 600;
        border-radius: var(--sms-radius);
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .sms-btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: var(--sms-white);
        box-shadow: var(--sms-shadow-sm);
    }
    
    .sms-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: var(--sms-shadow-md);
    }
    
    .sms-btn-secondary {
        background: var(--sms-white);
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-300);
    }
    
    .sms-btn-secondary:hover {
        background: var(--sms-gray-50);
        border-color: var(--sms-gray-400);
    }
    
    .sms-btn-lg {
        padding: 0.875rem 1.75rem;
        font-size: 1rem;
    }
    
    /* Tables */
    .sms-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9375rem;
    }
    
    .sms-table thead {
        background: var(--sms-gray-50);
    }
    
    .sms-table th {
        padding: var(--sms-spacing) var(--sms-spacing-md);
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--sms-gray-200);
    }
    
    .sms-table td {
        padding: var(--sms-spacing-md);
        border-bottom: 1px solid var(--sms-gray-200);
        color: var(--sms-gray-800);
    }
    
    .sms-table tbody tr {
        transition: background 0.15s ease;
    }
    
    .sms-table tbody tr:hover {
        background: var(--sms-gray-50);
    }
    
    .sms-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* Badges */
    .sms-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
    }
    
    .sms-badge-success {
        background: #d1fae5;
        color: #065f46;
    }
    
    .sms-badge-warning {
        background: #fef3c7;
        color: #92400e;
    }
    
    .sms-badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .sms-badge-info {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .sms-badge-primary {
        background: #e0e7ff;
        color: #3730a3;
    }
    
    /* Empty States */
    .sms-empty-state {
        text-align: center;
        padding: var(--sms-spacing-xl) var(--sms-spacing-lg);
        color: var(--sms-gray-500);
    }
    
    .sms-empty-state-icon {
        font-size: 3rem;
        color: var(--sms-gray-300);
        margin-bottom: var(--sms-spacing);
    }
    
    .sms-empty-state-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        margin-bottom: var(--sms-spacing-xs);
    }
    
    .sms-empty-state-text {
        font-size: 0.9375rem;
        color: var(--sms-gray-500);
    }
    
    /* Grids */
    .sms-grid {
        display: grid;
        gap: var(--sms-spacing-lg);
    }
    
    .sms-grid-2 {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
    
    .sms-grid-3 {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
    
    .sms-grid-4 {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    /* Page Header */
    .sms-page-header {
        background: white;
        padding: 1.25rem 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        margin: -1rem -1rem 1.5rem -1rem;
        border-radius: 0;
    }
    
    .sms-page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }
    
    .sms-page-subtitle {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
        line-height: 1.5;
    }
    
    /* Touch-friendly buttons */
    .sms-btn,
    button,
    .btn {
        min-height: 44px;
        min-width: 44px;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }
    
    .sms-btn:active {
        transform: scale(0.98);
    }
    
    /* Responsive */
    @media (min-width: 640px) {
        .sms-page-header {
            padding: 1.5rem 1.5rem;
            margin: -1rem -1.5rem 2rem -1.5rem;
            border-radius: 0;
        }
        
        .sms-page-title {
            font-size: 1.75rem;
        }
        
        .sms-page-subtitle {
            font-size: 0.9375rem;
        }
    }
    
    @media (min-width: 768px) {
        .sms-page-header {
            padding: 2rem;
            margin: -2rem -2rem 2rem -2rem;
            border-radius: 0;
        }
        
        .sms-page-title {
            font-size: 1.875rem;
        }
    }
    
    @media (max-width: 768px) {
        .sms-h1 {
            font-size: 1.75rem;
        }
        
        .sms-h2 {
            font-size: 1.375rem;
        }
        
        .sms-stat-value {
            font-size: 1.75rem;
        }
        
        .sms-table {
            font-size: 0.8125rem;
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .sms-table th,
        .sms-table td {
            padding: 0.625rem 0.5rem;
            white-space: nowrap;
        }
        
        .sms-grid-2,
        .sms-grid-3,
        .sms-grid-4 {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        /* Mobile-friendly cards */
        .sms-card,
        .sms-stat-card {
            padding: 1.25rem;
            border-radius: 12px;
        }
        
        /* Mobile-friendly forms */
        .sms-form-input,
        .sms-form-select,
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        input[type="password"],
        select,
        textarea {
            min-height: 44px;
            font-size: 16px; /* Prevents zoom on iOS */
            padding: 0.75rem;
        }
    }
    
    @media (max-width: 480px) {
        .sms-page-title {
            font-size: 1.375rem;
        }
        
        .sms-page-subtitle {
            font-size: 0.8125rem;
        }
    }
    
    /* Touch-friendly interactions for all devices */
    a, button, .sms-btn, .btn, input[type="button"], input[type="submit"], 
    input[type="checkbox"], input[type="radio"], label {
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }
    
    a:active, button:active, .sms-btn:active, .btn:active {
        transform: scale(0.98);
        transition: transform 0.1s;
    }
    
    /* Smooth scrolling */
    html {
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }
    
    /* Prevent horizontal scroll */
    body {
        overflow-x: hidden;
        width: 100%;
    }
</style>
