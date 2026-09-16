{{-- Premium Design System for "ES-SCHOOLS" Brand --}}
<style>
    /* ============================================
       PREMIUM DESIGN SYSTEM - "ES-SCHOOLS"
       ============================================ */
    
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    :root {
        /* Brand Colors - Premium Education Tech Palette */
        --brand-primary: #2563eb;           /* Trust Blue */
        --brand-primary-dark: #1e40af;     /* Deep Blue */
        --brand-primary-light: #3b82f6;     /* Light Blue */
        --brand-secondary: #7c3aed;         /* Purple Accent */
        --brand-accent: #06b6d4;           /* Cyan */
        --brand-success: #10b981;          /* Success Green */
        --brand-warning: #f59e0b;          /* Warning Amber */
        --brand-danger: #ef4444;           /* Error Red */
        --brand-info: #3b82f6;             /* Info Blue */
        
        /* Neutral Palette */
        --neutral-50: #f8fafc;
        --neutral-100: #f1f5f9;
        --neutral-200: #e2e8f0;
        --neutral-300: #cbd5e1;
        --neutral-400: #94a3b8;
        --neutral-500: #64748b;
        --neutral-600: #475569;
        --neutral-700: #334155;
        --neutral-800: #1e293b;
        --neutral-900: #0f172a;
        
        /* Typography */
        --font-heading: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        
        /* Spacing Scale */
        --space-1: 0.25rem;   /* 4px */
        --space-2: 0.5rem;    /* 8px */
        --space-3: 0.75rem;    /* 12px */
        --space-4: 1rem;      /* 16px */
        --space-5: 1.25rem;    /* 20px */
        --space-6: 1.5rem;     /* 24px */
        --space-8: 2rem;       /* 32px */
        --space-10: 2.5rem;    /* 40px */
        --space-12: 3rem;      /* 48px */
        --space-16: 4rem;      /* 64px */
        --space-20: 5rem;      /* 80px */
        
        /* Border Radius */
        --radius-sm: 0.375rem;   /* 6px */
        --radius: 0.5rem;        /* 8px */
        --radius-md: 0.75rem;    /* 12px */
        --radius-lg: 1rem;       /* 16px */
        --radius-xl: 1.5rem;     /* 24px */
        --radius-2xl: 2rem;      /* 32px */
        --radius-full: 9999px;
        
        /* Shadows - Premium Elevation System */
        --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        --shadow-2xl: 0 30px 60px -12px rgba(0, 0, 0, 0.3);
        
        /* Transitions */
        --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
        --transition-base: 200ms cubic-bezier(0.4, 0, 0.2, 1);
        --transition-slow: 300ms cubic-bezier(0.4, 0, 0.2, 1);
        --transition-slower: 500ms cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Base Typography */
    body {
        font-family: var(--font-body);
        color: var(--neutral-800);
        line-height: 1.6;
        font-size: 0.9375rem;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: var(--font-heading);
        font-weight: 700;
        line-height: 1.2;
        color: var(--neutral-900);
        letter-spacing: -0.02em;
    }
    
    /* Premium Card Component */
    .premium-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid var(--neutral-200);
        overflow: hidden;
        transition: all var(--transition-base);
        position: relative;
    }
    
    .premium-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        border-color: var(--neutral-300);
    }
    
    .premium-card-header {
        padding: var(--space-6) var(--space-6);
        border-bottom: 1px solid var(--neutral-200);
        background: linear-gradient(to bottom, var(--neutral-50), white);
    }
    
    .premium-card-body {
        padding: var(--space-6);
    }
    
    /* Premium Stat Card */
    .premium-stat-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: var(--space-6);
        box-shadow: var(--shadow);
        border: 1px solid var(--neutral-200);
        transition: all var(--transition-base);
        position: relative;
        overflow: hidden;
    }
    
    .premium-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--brand-primary), var(--brand-secondary));
    }
    
    .premium-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }
    
    .premium-stat-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: var(--space-4);
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
        color: white;
        box-shadow: var(--shadow-md);
    }
    
    .premium-stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--neutral-900);
        line-height: 1;
        margin-bottom: var(--space-2);
        font-family: var(--font-heading);
    }
    
    .premium-stat-label {
        font-size: 0.875rem;
        color: var(--neutral-600);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    /* Premium Button */
    .premium-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-2);
        padding: 0.75rem 1.5rem;
        font-size: 0.9375rem;
        font-weight: 600;
        font-family: var(--font-heading);
        border-radius: var(--radius);
        border: none;
        cursor: pointer;
        transition: all var(--transition-base);
        text-decoration: none;
        position: relative;
        overflow: hidden;
        min-height: 44px;
    }
    
    .premium-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .premium-btn:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .premium-btn-primary {
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-primary-dark));
        color: white;
        box-shadow: var(--shadow-md);
    }
    
    .premium-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    .premium-btn-primary:active {
        transform: translateY(0);
    }
    
    /* Premium Input */
    .premium-input {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        font-family: var(--font-body);
        border: 2px solid var(--neutral-300);
        border-radius: var(--radius);
        background: white;
        transition: all var(--transition-base);
        min-height: 44px;
    }
    
    .premium-input:focus {
        outline: none;
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    
    .animate-slide-in {
        animation: slideIn 0.5s ease-out;
    }
    
    .animate-scale-in {
        animation: scaleIn 0.3s ease-out;
    }
    
    /* Loading Skeleton */
    .skeleton {
        background: linear-gradient(90deg, var(--neutral-200) 25%, var(--neutral-100) 50%, var(--neutral-200) 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    
    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .premium-stat-value {
            font-size: 1.75rem;
        }
        
        .premium-card-body {
            padding: var(--space-4);
        }
        
        .premium-stat-card {
            padding: var(--space-4);
        }
    }
</style>
