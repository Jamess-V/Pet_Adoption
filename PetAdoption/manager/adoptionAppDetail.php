<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details - ADOPET Manager</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/adoptionAppDetail.css">
</head>
<body>
    
    <nav>
        <div class="nav-left">
            <div class="logo">
                <img src="../Image/PetLogo.png" alt="Pet Adoption Logo">
            </div>
            <ul class="nav-links">
                <li><a href="manager.html">Home</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <a href="../user/signup.html" class="btn btn-signup">Sign Up</a>
            <a href="../user/login.html" class="btn btn-login">Login</a>
        </div>
    </nav>

    
    <div class="staff-container">
        
        <aside class="sidebar">
            <button class="sidebar-btn" onclick="window.location.href='manager.html'">
                <svg viewBox="0 0 20 20">
                    <rect x="3" y="4" width="14" height="3" rx="0.5"/>
                    <rect x="3" y="9" width="14" height="3" rx="0.5"/>
                    <rect x="3" y="14" width="14" height="3" rx="0.5"/>
                </svg>
                Overall Report
            </button>
            <button class="sidebar-btn" onclick="window.location.href='petReport.html'">
                <svg viewBox="0 0 20 20">
                    <path d="M10 3C7.5 3 5.5 5 5.5 7.5C5.5 8.5 5.8 9.4 6.3 10.1C4.4 11 3 13 3 15.5V17H17V15.5C17 13 15.6 11 13.7 10.1C14.2 9.4 14.5 8.5 14.5 7.5C14.5 5 12.5 3 10 3Z"/>
                </svg>
                Pet Report
            </button>
            <button class="sidebar-btn active">
                <svg viewBox="0 0 20 20">
                    <path d="M14 3H6C4.9 3 4 3.9 4 5V15C4 16.1 4.9 17 6 17H14C15.1 17 16 16.1 16 15V5C16 3.9 15.1 3 14 3Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="8" y1="7" x2="12" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="10" x2="12" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Application Status
            </button>
            <button class="sidebar-btn" onclick="window.location.href='staffManagement.html'">
                <svg viewBox="0 0 20 20">
                    <path d="M10 2L3 6V10C3 14.5 6 18.5 10 19C14 18.5 17 14.5 17 10V6L10 2Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <polyline points="7,10 9,12 13,8" stroke="currentColor" stroke-width="1.5" fill="none"/>
                </svg>
                Staff
            </button>
            <button class="sidebar-btn">
                <svg viewBox="0 0 20 20">
                    <path d="M10 2C5.6 2 2 5.6 2 10C2 14.4 5.6 18 10 18C14.4 18 18 14.4 18 10C18 5.6 14.4 2 10 2ZM10 16C6.7 16 4 13.3 4 10C4 6.7 6.7 4 10 4C13.3 4 16 6.7 16 10C16 13.3 13.3 16 10 16Z"/>
                    <path d="M10 6C9.4 6 9 6.4 9 7V10.4L11.3 12.7C11.7 13.1 12.3 13.1 12.7 12.7C13.1 12.3 13.1 11.7 12.7 11.3L11 9.6V7C11 6.4 10.6 6 10 6Z"/>
                </svg>
                Medical & Vaccination
            </button>
        </aside>

        
        <main class="app-detail-content">
            
            <div id="actionNotification" class="action-notification">
                <svg viewBox="0 0 24 24" class="check-icon">
                    <path d="M20 6L9 17l-5-5" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span id="notificationText"></span>
            </div>

            <div class="detail-container">
                <h2 class="applicant-name">Lando Reyes</h2>

                
                <div class="detail-section">
                    <div class="info-grid">
                        <div class="info-item">
                            <p><strong>Age:</strong> 28</p>
                        </div>
                        <div class="info-item">
                            <p><strong>Gender:</strong> Male</p>
                        </div>
                        <div class="info-item">
                            <p><strong>Email:</strong> lando.reyes@example.com</p>
                        </div>
                        <div class="info-item">
                            <p><strong>Phone Number:</strong> +66 123456789</p>
                        </div>
                        <div class="info-item full-width">
                            <p><strong>Address:</strong> 123/45 Sukhumvit Rd, Khlong Tan Nuea, Watthana, Bangkok</p>
                        </div>
                        <div class="info-item">
                            <p><strong>Occupation:</strong> Software Developer at HorizonTech</p>
                        </div>
                        <div class="info-item">
                            <p><strong>Marital Status:</strong> Single</p>
                        </div>
                        <div class="info-item full-width">
                            <p><strong>Living Situation:</strong> Renting a pet-friendly, two-bedroom apartment</p>
                        </div>
                    </div>
                </div>

                
                <div class="detail-section">
                    <h3 class="section-title">Motivation for Adoption</h3>
                    <div class="section-content">
                        <p><strong>Reason for Adoption:</strong> Seeking companionship and wants to provide a rescue animal with a stable, loving home</p>
                        <p><strong>Preferred Pets:</strong> Medium-sized dog or calm cat; open to adopting seniors or special-needs animals</p>
                        <p><strong>Commitment:</strong> Willing to attend training classes, follow adoption guidelines, do regular vet checkups</p>
                    </div>
                </div>

                
                <div class="detail-section">
                    <h3 class="section-title">Experience & Preparedness</h3>
                    <div class="section-content">
                        <p><strong>Previous Pet Experience:</strong> Owned a mixed-breed dog for 10 years (from puppy to senior), handled:</p>
                        <ul class="experience-list">
                            <li>End-of-life care</li>
                            <li>Behavioral grooming</li>
                            <li>Leash training</li>
                            <li>Basic obedience commands</li>
                            <li>Administering medication</li>
                        </ul>
                    </div>
                </div>

                
                <div class="action-buttons">
                    <button class="approve-btn" onclick="handleApprove()">Approve</button>
                    <button class="decline-btn" onclick="handleDecline()">Decline</button>
                </div>
            </div>
        </main>
    </div>

    <script>
        function handleApprove() {
            showNotification('Approved', 'approve');
        }

        function handleDecline() {
            showNotification('Declined', 'decline');
        }

        function showNotification(message, type) {
            const notification = document.getElementById('actionNotification');
            const notificationText = document.getElementById('notificationText');
            notificationText.textContent = message;
            notification.className = 'action-notification show ' + type;
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    window.location.href = 'adoptionApp.html';
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>