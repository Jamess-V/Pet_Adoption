<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Applications - ADOPET Manager</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/adoptionApp.css">
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

        
        <main class="adoption-app-content">
            <h2>Adoption Application</h2>
            <p class="subtitle">User Details</p>

            
            <div class="application-list">
                
                <div class="application-card">
                    <div class="card-content">
                        <h3 class="applicant-name">Lando Reyes</h3>
                        <div class="applicant-info">
                            <div class="info-row">
                                <p><strong>Age:</strong> 28</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Gender:</strong> Male</p>
                                <p><strong>Email:</strong> lando.reyes@example.com</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Phone Number:</strong> +66 123456789</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Home Address:</strong> 123/45 Sukhumvit Rd, Khlong Tan Nuea, Watthana, Bangkok</p>
                            </div>
                            <div class="reason-section">
                                <p><strong>Reason for Adoption:</strong> Looking for companionship and wants to give a stray dog a loving home</p>
                            </div>
                            <div class="preferred-pets">
                                <p><strong>Preferred Pets:</strong> Golden Retriever, Labrador, Beagle</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <span class="status-badge pending">Pending</span>
                        <button class="view-details-btn" onclick="window.location.href='adoptionAppDetail.html'">View more Details</button>
                    </div>
                </div>

                
                <div class="application-card">
                    <div class="card-content">
                        <h3 class="applicant-name">Mira Sullivan</h3>
                        <div class="applicant-info">
                            <div class="info-row">
                                <p><strong>Age:</strong> 34</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Gender:</strong> Female</p>
                                <p><strong>Email:</strong> mira@example.com</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Phone Number:</strong> +66 12344235</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Home Address:</strong> 56/3 Nimmanhaemin Rd, Suthep, Mueang Chiang Mai, Chiang Mai</p>
                            </div>
                            <div class="reason-section">
                                <p><strong>Reason for Adoption:</strong> Wants a companion animal to get warmth in a new household</p>
                            </div>
                            <div class="preferred-pets">
                                <p><strong>Preferred Pets:</strong> Persian cat, Siamese cat, Scottish fold, Ragdoll, prefers pets that need special time at home</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <span class="status-badge approved">Approved</span>
                        <button class="view-details-btn" onclick="window.location.href='adoptionAppDetail.html'">View more Details</button>
                    </div>
                </div>

                
                <div class="application-card">
                    <div class="card-content">
                        <h3 class="applicant-name">Ethan Ward</h3>
                        <div class="applicant-info">
                            <div class="info-row">
                                <p><strong>Age:</strong> 45</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Gender:</strong> Male</p>
                                <p><strong>Email:</strong> Ethan@example.com</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Phone Number:</strong> +66 9876543</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Home Address:</strong> 101/7 Moo 1 Thep Krasattri Rd, Si Sunthon, Thalang, Phuket</p>
                            </div>
                            <div class="reason-section">
                                <p><strong>Reason for Adoption:</strong> Works from home and wants a companion to avoid loneliness. Wants an intelligent, friendly pet</p>
                            </div>
                            <div class="preferred-pets">
                                <p><strong>Preferred Pets:</strong> German Shepherd, Golden Retriever, Border Collie, prefers active playful dogs</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <span class="status-badge pending">Pending</span>
                        <button class="view-details-btn" onclick="window.location.href='adoptionAppDetail.html'">View more Details</button>
                    </div>
                </div>

                
                <div class="application-card">
                    <div class="card-content">
                        <h3 class="applicant-name">Sarah Chen</h3>
                        <div class="applicant-info">
                            <div class="info-row">
                                <p><strong>Age:</strong> 29</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Gender:</strong> Female</p>
                                <p><strong>Email:</strong> sarah.chen@example.com</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Phone Number:</strong> +60 11223344</p>
                            </div>
                            <div class="info-row">
                                <p><strong>Home Address:</strong> 321 Garden Lane, Shah Alam</p>
                            </div>
                            <div class="reason-section">
                                <p><strong>Reason for Adoption:</strong> Experienced pet owner looking to adopt a rescue animal and provide a forever home</p>
                            </div>
                            <div class="preferred-pets">
                                <p><strong>Preferred Pets:</strong> Labrador, Beagle Mix, British Shorthair</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <span class="status-badge approved">Approved</span>
                        <button class="view-details-btn" onclick="window.location.href='adoptionAppDetail.html'">View more Details</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>