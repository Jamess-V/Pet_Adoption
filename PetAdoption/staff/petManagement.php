<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Management - ADOPET Staff</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/petManagement.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/search.css">
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
            <button class="sidebar-btn active">
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
            <button class="sidebar-btn" onclick="window.location.href='careLogs.html'">
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
        <main class="pet-management-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0; color: #333; font-size: 24px;">Pet Management</h2>
                <button class="action-btn primary" onclick="window.location.href='addNewPet.html'" style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 14px;">
                    <svg viewBox="0 0 20 20">
                        <line x1="10" y1="5" x2="10" y2="15" stroke="currentColor" stroke-width="2"/>
                        <line x1="5" y1="10" x2="15" y2="10" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Add New Pet
                </button>
            </div>
            <div class="search-container">
                <svg viewBox="0 0 18 18">
                    <circle cx="7" cy="7" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <line x1="11" y1="11" x2="16" y2="16" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <input type="text" placeholder="Search pets..." id="searchInput">
            </div>
            <div class="pet-list-container">
                <div class="pet-item">
                    <div class="pet-info-section">
                        <img src="../Image/Golden-Retriever.jpg" alt="Max" class="pet-avatar">
                        <div class="pet-details">
                            <h3>Max</h3>
                            <p>Dog • Golden Retriever</p>
                        </div>
                        <span class="status-badge available">Available</span>
                    </div>
                    <div class="pet-actions">
                        <button class="action-btn-small" onclick="window.location.href='editPet.html'">
                            <svg viewBox="0 0 16 16">
                                <path d="M2 11L2 14L5 14L12 7L9 4L2 11Z"/>
                                <path d="M13 3L14 4L12 6L11 5L13 3Z"/>
                            </svg>
                            Edit
                        </button>
                        <button class="action-btn-small">
                            <svg viewBox="0 0 16 16">
                                <path d="M8 1C4.1 1 1 4.1 1 8C1 11.9 4.1 15 8 15C11.9 15 15 11.9 15 8C15 4.1 11.9 1 8 1ZM8 13C5.2 13 3 10.8 3 8C3 5.2 5.2 3 8 3C10.8 3 13 5.2 13 8C13 10.8 10.8 13 8 13Z"/>
                                <path d="M9 5H7V9H9V5Z"/>
                                <rect x="7" y="10" width="2" height="2"/>
                            </svg>
                            Medical
                        </button>
                        <button class="action-btn-small" onclick="window.location.href='careLogsDetail.html'">
                            <svg viewBox="0 0 16 16">
                                <rect x="3" y="2" width="10" height="12" rx="1" stroke="currentColor" stroke-width="1.2" fill="none"/>
                                <line x1="5" y1="5" x2="11" y2="5" stroke="currentColor" stroke-width="1.2"/>
                                <line x1="5" y1="8" x2="11" y2="8" stroke="currentColor" stroke-width="1.2"/>
                                <line x1="5" y1="11" x2="8" y2="11" stroke="currentColor" stroke-width="1.2"/>
                            </svg>
                            Care Log
                        </button>
                    </div>
                </div>

                <div class="pet-item">
                    <div class="pet-info-section">
                        <img src="../Image/Scottish_cat.jpg" alt="Luna" class="pet-avatar">
                        <div class="pet-details">
                            <h3>Luna</h3>
                            <p>Cat • Siamese</p>
                        </div>
                        <span class="status-badge pending">Pending</span>
                    </div>
                    <div class="pet-actions">
                        <button class="action-btn-small">
                            <svg viewBox="0 0 16 16">
                                <path d="M2 11L2 14L5 14L12 7L9 4L2 11Z"/>
                                <path d="M13 3L14 4L12 6L11 5L13 3Z"/>
                            </svg>
                            Edit
                        </button>
                        <button class="action-btn-small">
                            <svg viewBox="0 0 16 16">
                                <path d="M8 1C4.1 1 1 4.1 1 8C1 11.9 4.1 15 8 15C11.9 15 15 11.9 15 8C15 4.1 11.9 1 8 1ZM8 13C5.2 13 3 10.8 3 8C3 5.2 5.2 3 8 3C10.8 3 13 5.2 13 8C13 10.8 10.8 13 8 13Z"/>
                                <path d="M9 5H7V9H9V5Z"/>
                                <rect x="7" y="10" width="2" height="2"/>
                            </svg>
                            Medical
                        </button>
                        <button class="action-btn-small" onclick="window.location.href='careLogsDetail.html'">
                            <svg viewBox="0 0 16 16">
                                <rect x="3" y="2" width="10" height="12" rx="1" stroke="currentColor" stroke-width="1.2" fill="none"/>
                                <line x1="5" y1="5" x2="11" y2="5" stroke="currentColor" stroke-width="1.2"/>
                                <line x1="5" y1="8" x2="11" y2="8" stroke="currentColor" stroke-width="1.2"/>
                                <line x1="5" y1="11" x2="8" y2="11" stroke="currentColor" stroke-width="1.2"/>
                            </svg>
                            Care Log
                        </button>
                    </div>
                </div>

                <div class="pet-item">
                    <div class="pet-info-section">
                        <img src="../Image/german-shepherd-2-3.jpg" alt="Charlie" class="pet-avatar">
                        <div class="pet-details">
                            <h3>Charlie</h3>
                            <p>Dog • German Shepherd</p>
                        </div>
                        <span class="status-badge available">Available</span>
                    </div>
                    <div class="pet-actions">
                        <button class="action-btn-small">
                            <svg viewBox="0 0 16 16">
                                <path d="M2 11L2 14L5 14L12 7L9 4L2 11Z"/>
                                <path d="M13 3L14 4L12 6L11 5L13 3Z"/>
                            </svg>
                            Edit
                        </button>
                        <button class="action-btn-small">
                            <svg viewBox="0 0 16 16">
                                <path d="M8 1C4.1 1 1 4.1 1 8C1 11.9 4.1 15 8 15C11.9 15 15 11.9 15 8C15 4.1 11.9 1 8 1ZM8 13C5.2 13 3 10.8 3 8C3 5.2 5.2 3 8 3C10.8 3 13 5.2 13 8C13 10.8 10.8 13 8 13Z"/>
                                <path d="M9 5H7V9H9V5Z"/>
                                <rect x="7" y="10" width="2" height="2"/>
                            </svg>
                            Medical
                        </button>
                        <button class="action-btn-small" onclick="window.location.href='careLogsDetail.html'">
                            <svg viewBox="0 0 16 16">
                                <rect x="3" y="2" width="10" height="12" rx="1" stroke="currentColor" stroke-width="1.2" fill="none"/>
                                <line x1="5" y1="5" x2="11" y2="5" stroke="currentColor" stroke-width="1.2"/>
                                <line x1="5" y1="8" x2="11" y2="8" stroke="currentColor" stroke-width="1.2"/>
                                <line x1="5" y1="11" x2="8" y2="11" stroke="currentColor" stroke-width="1.2"/>
                            </svg>
                            Care Log
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
