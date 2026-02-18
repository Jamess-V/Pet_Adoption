<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Log Detail - ADOPET Staff</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/careLogsDetail.css">
</head>
<body>
    <nav>
        <div class="nav-left">
            <div class="logo">
                <img src="../Image/PetLogo.png" alt="Pet Adoption Logo">
            </div>
            <ul class="nav-links">
                <li><a href="staff.html">Home</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <a href="../user/signup.html" class="btn btn-signup">Sign Up</a>
            <a href="../user/login.html" class="btn btn-login">Login</a>
        </div>
    </nav>
    <div class="staff-container">
        <aside class="sidebar">
            <button class="sidebar-btn" onclick="window.location.href='staff.html'">
                <svg viewBox="0 0 20 20">
                    <rect x="3" y="3" width="6" height="6" rx="1"/>
                    <rect x="11" y="3" width="6" height="6" rx="1"/>
                    <rect x="3" y="11" width="6" height="6" rx="1"/>
                    <rect x="11" y="11" width="6" height="6" rx="1"/>
                </svg>
                Dashboard
            </button>
            <button class="sidebar-btn" onclick="window.location.href='petManagement.html'">
                <svg viewBox="0 0 20 20">
                    <path d="M10 3C7.5 3 5.5 5 5.5 7.5C5.5 8.5 5.8 9.4 6.3 10.1C4.4 11 3 13 3 15.5V17H17V15.5C17 13 15.6 11 13.7 10.1C14.2 9.4 14.5 8.5 14.5 7.5C14.5 5 12.5 3 10 3Z"/>
                </svg>
                Pet Management
            </button>
            <button class="sidebar-btn">
                <svg viewBox="0 0 20 20">
                    <path d="M10 2C5.6 2 2 5.6 2 10C2 14.4 5.6 18 10 18C14.4 18 18 14.4 18 10C18 5.6 14.4 2 10 2ZM10 16C6.7 16 4 13.3 4 10C4 6.7 6.7 4 10 4C13.3 4 16 6.7 16 10C16 13.3 13.3 16 10 16Z"/>
                    <path d="M10 6C9.4 6 9 6.4 9 7V10.4L11.3 12.7C11.7 13.1 12.3 13.1 12.7 12.7C13.1 12.3 13.1 11.7 12.7 11.3L11 9.6V7C11 6.4 10.6 6 10 6Z"/>
                </svg>
                Medical Records
            </button>
            <button class="sidebar-btn active" onclick="window.location.href='careLogs.html'">
                <svg viewBox="0 0 20 20">
                    <rect x="4" y="3" width="12" height="14" rx="1" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="7" y1="7" x2="13" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="7" y1="10" x2="13" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="7" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Daily Pet Care Logs
            </button>
            <button class="sidebar-btn" onclick="window.location.href='shelterAppointment.html'">
                <svg viewBox="0 0 20 20">
                    <path d="M10 9C11.7 9 13 7.7 13 6C13 4.3 11.7 3 10 3C8.3 3 7 4.3 7 6C7 7.7 8.3 9 10 9Z"/>
                    <path d="M10 11C6.7 11 4 13.7 4 17H16C16 13.7 13.3 11 10 11Z"/>
                </svg>
                Meet & Greet
            </button>
            <button class="sidebar-btn">
                <svg viewBox="0 0 20 20">
                    <path d="M14 3H6C4.9 3 4 3.9 4 5V15C4 16.1 4.9 17 6 17H14C15.1 17 16 16.1 16 15V5C16 3.9 15.1 3 14 3Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="8" y1="7" x2="12" y2="7" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="10" x2="12" y2="10" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="8" y1="13" x2="10" y2="13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Applications
            </button>
        </aside>

        <main class="care-log-detail-content">
            <div class="detail-header">
                <button class="back-btn" onclick="window.location.href='careLogs.html'">
                    <svg viewBox="0 0 20 20">
                        <path d="M15 10H5M5 10L10 5M5 10L10 15" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                    Back to Care Logs
                </button>
                <h2>Care Log Detail</h2>
            </div>

            <div class="detail-container">
                <div class="pet-header-section">
                    <img src="../Image/Golden-Retriever.jpg" alt="Max" class="pet-detail-avatar">
                    <div class="pet-header-info">
                        <h3>Max</h3>
                        <p class="pet-type">Dog • Golden Retriever</p>
                        <span class="activity-badge feeding">Feeding</span>
                    </div>
                </div>

                <div class="log-info-card">
                    <div class="info-row">
                        <div class="info-label">Date & Time</div>
                        <div class="info-value">February 4, 2026 • 10:15 AM</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Activity Type</div>
                        <div class="info-value">Feeding</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Staff Member</div>
                        <div class="info-value">Sarah Johnson</div>
                    </div>
                </div>

                <div class="log-description-card">
                    <h4>Description</h4>
                    <p>Fed morning meal. Ate well, finished entire portion. Max showed good appetite and energy levels. The food was the regular dry kibble mixed with wet food as per his feeding schedule. Water bowl was also refilled and cleaned.</p>
                </div>

                <div class="log-notes-card">
                    <h4>Additional Notes</h4>
                    <p>Max appeared in good health and spirits. No unusual behavior observed. Will continue monitoring eating habits and energy levels throughout the day. Next scheduled feeding at 6:00 PM.</p>
                </div>

                <div class="log-actions">
                    <button class="action-btn secondary" onclick="window.location.href='careLogs.html'">Close</button>
                    <button class="action-btn primary" onclick="editLog()">Edit Log</button>
                </div>
            </div>
        </main>
    </div>

    <script>
        function editLog() {
            alert('Edit functionality would open an edit form');
        }
    </script>
</body>
</html>