<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Details - ADOPET Manager</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/staff.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/petReportDetail.css">
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
            <button class="sidebar-btn active">
                <svg viewBox="0 0 20 20">
                    <path d="M10 3C7.5 3 5.5 5 5.5 7.5C5.5 8.5 5.8 9.4 6.3 10.1C4.4 11 3 13 3 15.5V17H17V15.5C17 13 15.6 11 13.7 10.1C14.2 9.4 14.5 8.5 14.5 7.5C14.5 5 12.5 3 10 3Z"/>
                </svg>
                Pet Report
            </button>
            <button class="sidebar-btn" onclick="window.location.href='adoptionApp.html'">
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

        
        <main class="pet-detail-content">
            <div class="detail-header">
                <h2>Pet Details</h2>
                <button class="edit-btn" onclick="window.location.href='editPetReport.html'">Edit</button>
            </div>

            <div class="detail-container">
                <div class="detail-left">
                    
                    <div class="detail-section">
                        <h3 class="pet-name">Max</h3>
                        <p class="pet-breed">Golden Retriever</p>
                        <div class="basic-info">
                            <p><strong>Species:</strong> Dog</p>
                            <p><strong>Gender:</strong> Male</p>
                            <p><strong>Age:</strong> 2 years</p>
                            <p><strong>Size:</strong> Large</p>
                            <p><strong>Weight:</strong> 30kg</p>
                            <p><strong>Color:</strong> Golden</p>
                        </div>
                    </div>

                    
                    <div class="detail-section">
                        <h3 class="section-title">Health & Medical</h3>
                        <div class="section-content">
                            <p><strong>Vaccination Status:</strong> Fully vaccinated</p>
                            <p><strong>Spayed/Neutered:</strong> Yes</p>
                            <p><strong>Medical Conditions:</strong> None</p>
                            <p><strong>Last Vet Checkup:</strong> 2 Nov 2025</p>
                        </div>
                    </div>

                    
                    <div class="detail-section">
                        <h3 class="section-title">Behavior & Temperament</h3>
                        <div class="section-content">
                            <p><strong>Personality:</strong> Friendly, gentle, great with children, loves attention</p>
                            <p><strong>Training:</strong> House-trained, knows basic commands (sit, stay, come)</p>
                            <p><strong>Energy Level:</strong> Medium-high</p>
                            <p><strong>Compatibility:</strong> Good with other dogs, unsure with cats</p>
                        </div>
                    </div>

                    
                    <div class="detail-section">
                        <h3 class="section-title">Shelter Information</h3>
                        <div class="section-content">
                            <p><strong>Date of Rescue:</strong> 15 Aug 2023</p>
                            <p><strong>Current Status:</strong> Available for adoption</p>
                        </div>
                    </div>
                </div>

                <div class="detail-right">
                    <img src="../Image/Golden-Retriever.jpg" alt="Max" class="pet-detail-photo">
                </div>
            </div>
        </main>
    </div>
</body>
</html>