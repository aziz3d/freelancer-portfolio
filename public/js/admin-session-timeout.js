
class AdminSessionTimeout {
    constructor() {
        this.timeoutDuration = 30 * 60 * 1000;
        this.warningTime = 5 * 60 * 1000;
        this.warningShown = false;
        this.lastActivity = Date.now();
        this.warningModal = null;
        this.countdownInterval = null;
        
        this.init();
    }
    
    init() {
        
        if (!window.location.pathname.startsWith('/admin') || 
            window.location.pathname === '/admin/login') {
            return;
        }
        
        this.createWarningModal();
        this.bindEvents();
        this.startTimer();
    }
    
    createWarningModal() {
        const modal = document.createElement('div');
        modal.id = 'session-timeout-modal';
        modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden';
        modal.innerHTML = `
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Session Expiring Soon</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            Your admin session will expire in <span id="countdown-timer" class="font-bold text-red-600">5:00</span> due to inactivity.
                        </p>
                        <p class="text-xs text-gray-400 mt-2">
                            Click "Stay Logged In" to extend your session, or you'll be automatically logged out for security.
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button id="extend-session-btn" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Stay Logged In
                        </button>
                        <button id="logout-now-btn" class="mt-2 px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Logout Now
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        this.warningModal = modal;
        
        
        document.getElementById('extend-session-btn').addEventListener('click', () => {
            this.extendSession();
        });
        
        document.getElementById('logout-now-btn').addEventListener('click', () => {
            this.logoutNow();
        });
    }
    
    bindEvents() {
        
        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
        
        events.forEach(event => {
            document.addEventListener(event, () => {
                this.updateActivity();
            }, true);
        });
    }
    
    updateActivity() {
        this.lastActivity = Date.now();
        
       
        if (this.warningShown) {
            this.hideWarning();
        }
    }
    
    startTimer() {
        setInterval(() => {
            const now = Date.now();
            const timeSinceActivity = now - this.lastActivity;
            const timeUntilExpiry = this.timeoutDuration - timeSinceActivity;
            
            
            if (timeUntilExpiry <= this.warningTime && !this.warningShown) {
                this.showWarning(timeUntilExpiry);
            }
            
            
            if (timeUntilExpiry <= 0) {
                this.autoLogout();
            }
        }, 1000);
    }
    
    showWarning(timeLeft) {
        this.warningShown = true;
        this.warningModal.classList.remove('hidden');
        
       
        this.startCountdown(timeLeft);
    }
    
    hideWarning() {
        this.warningShown = false;
        this.warningModal.classList.add('hidden');
        
        if (this.countdownInterval) {
            clearInterval(this.countdownInterval);
        }
    }
    
    startCountdown(timeLeft) {
        const updateCountdown = () => {
            const minutes = Math.floor(timeLeft / 60000);
            const seconds = Math.floor((timeLeft % 60000) / 1000);
            const display = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            const timer = document.getElementById('countdown-timer');
            if (timer) {
                timer.textContent = display;
                
                
                if (timeLeft <= 60000) {
                    timer.className = 'font-bold text-red-700 animate-pulse';
                } else if (timeLeft <= 120000) {
                    timer.className = 'font-bold text-red-600';
                } else {
                    timer.className = 'font-bold text-red-600';
                }
            }
            
            timeLeft -= 1000;
            
            if (timeLeft < 0) {
                clearInterval(this.countdownInterval);
                this.autoLogout();
            }
        };
        
        updateCountdown();
        this.countdownInterval = setInterval(updateCountdown, 1000);
    }
    
    extendSession() {
        
        fetch('/admin/extend-session', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.lastActivity = Date.now();
                this.hideWarning();
                
               
                this.showNotification('Session extended successfully!', 'success');
            }
        })
        .catch(error => {
            console.error('Error extending session:', error);
            this.showNotification('Failed to extend session. Please refresh the page.', 'error');
        });
    }
    
    logoutNow() {
        window.location.href = '/admin/logout';
    }
    
    autoLogout() {
        this.showNotification('Session expired. Redirecting to login...', 'error');
        setTimeout(() => {
            window.location.href = '/admin/login';
        }, 2000);
    }
    
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
            type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' :
            type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
            'bg-blue-100 text-blue-800 border border-blue-200'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <span>${message}</span>
                <button class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
       
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }
}


document.addEventListener('DOMContentLoaded', () => {
    new AdminSessionTimeout();
});