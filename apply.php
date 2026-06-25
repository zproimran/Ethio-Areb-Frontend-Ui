<?php
// apply.php - Complete Rebranded Job Application Form
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/db_config.php';

// Get database connection
$conn = getDB();

$settings = getSettings();
$message = '';
$error = '';
$success = false;

// Get services for dropdown
$services = getServices();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = sanitize($_POST['first_name'] ?? '');
    $last_name = sanitize($_POST['last_name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $date_of_birth = sanitize($_POST['date_of_birth'] ?? '');
    $gender = sanitize($_POST['gender'] ?? '');
    $nationality = sanitize($_POST['nationality'] ?? '');
    $current_location = sanitize($_POST['current_location'] ?? '');
    $position_applied = sanitize($_POST['position_applied'] ?? '');
    $experience_years = intval($_POST['experience_years'] ?? 0);
    $current_salary = floatval($_POST['current_salary'] ?? 0);
    $expected_salary = floatval($_POST['expected_salary'] ?? 0);
    $availability_date = sanitize($_POST['availability_date'] ?? '');
    $education_level = sanitize($_POST['education_level'] ?? '');
    $skills = sanitize($_POST['skills'] ?? '');
    $languages = sanitize($_POST['languages'] ?? '');
    $certifications = sanitize($_POST['certifications'] ?? '');
    $referees = sanitize($_POST['referees'] ?? '');
    $cover_letter = sanitize($_POST['cover_letter'] ?? '');
    
    // Validate
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($position_applied)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Handle Resume Upload
        $resume = '';
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = UPLOAD_PATH . 'applications/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $resume = uploadFile($_FILES['resume'], $uploadDir, ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']);
            if (!$resume) {
                $error = 'Error uploading resume. Please upload PDF, DOC, or image files only.';
            }
        } else {
            $error = 'Please upload your resume/CV.';
        }
        
        // Handle Photo Upload
        $photo = '';
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = UPLOAD_PATH . 'applications/';
            $photo = uploadFile($_FILES['photo'], $uploadDir, ['jpg', 'jpeg', 'png']);
            if (!$photo) {
                $error = 'Error uploading photo. Please upload JPG or PNG files only.';
            }
        }
        
        if (empty($error)) {
            $stmt = $conn->prepare("INSERT INTO job_applications 
                (first_name, last_name, email, phone, date_of_birth, gender, nationality, 
                current_location, position_applied, experience_years, current_salary, expected_salary, 
                availability_date, resume, cover_letter, photo, education_level, skills, languages, 
                certifications, referees, ip_address, user_agent) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $ip = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            
            $stmt->bind_param("sssssssssiidsssssssssss", 
                $first_name, $last_name, $email, $phone, $date_of_birth, $gender, $nationality,
                $current_location, $position_applied, $experience_years, $current_salary, $expected_salary,
                $availability_date, $resume, $cover_letter, $photo, $education_level, $skills, $languages,
                $certifications, $referees, $ip, $user_agent
            );
            
            if ($stmt->execute()) {
                $success = true;
                $message = 'Your application has been submitted successfully! We will contact you soon.';
            } else {
                $error = 'Error submitting application. Please try again.';
            }
        }
    }
}

include 'header.php';
?>

<style>
    /* ============================================================
    BRAND COLORS - From Logo Analysis
    ============================================================ */
    :root {
        --primary-blue: #2D6FB7;
        --primary-blue-dark: #1a4f8a;
        --secondary-turquoise: #12A9C6;
        --accent-green: #6CC04A;
        --gold: #D4AF37;
        --dark: #1F2937;
        --gray: #6B7280;
        --light-gray: #F8FAFC;
        --white: #FFFFFF;
        --brand-gradient: linear-gradient(135deg, #2D6FB7, #12A9C6);
        --gold-gradient: linear-gradient(135deg, #D4AF37, #f5d76e);
    }

    /* ============================================================
    APPLY HERO - Brand Colors
    ============================================================ */
    .apply-hero {
        background: var(--brand-gradient);
        padding: 120px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .apply-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .apply-hero .hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .apply-hero .hero-particles span {
        position: absolute;
        display: block;
        width: 20px;
        height: 20px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
        animation: float 15s infinite;
    }

    .apply-hero .hero-particles span:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; width: 30px; height: 30px; }
    .apply-hero .hero-particles span:nth-child(2) { top: 30%; right: 15%; animation-delay: 2s; width: 40px; height: 40px; }
    .apply-hero .hero-particles span:nth-child(3) { bottom: 20%; left: 10%; animation-delay: 4s; width: 25px; height: 25px; }
    .apply-hero .hero-particles span:nth-child(4) { bottom: 30%; right: 25%; animation-delay: 6s; width: 35px; height: 35px; }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
        25% { transform: translateY(-30px) rotate(90deg); opacity: 0.6; }
        50% { transform: translateY(-60px) rotate(180deg); opacity: 0.3; }
        75% { transform: translateY(-30px) rotate(270deg); opacity: 0.6; }
    }

    .apply-hero .hero-badge {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        color: white;
        padding: 8px 24px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        margin-bottom: 1.5rem;
    }

    .apply-hero .hero-badge i {
        margin-right: 8px;
        color: var(--gold);
    }

    .apply-hero h1 {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .apply-hero h1 .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .apply-hero p {
        font-size: 1.25rem;
        color: rgba(255,255,255,0.85);
    }

    /* ============================================================
    FORM SECTIONS - Brand Colors
    ============================================================ */
    .form-section {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 4px 30px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .form-section:hover {
        border-color: rgba(18, 169, 198, 0.15);
        box-shadow: 0 8px 40px rgba(45, 111, 183, 0.06);
    }

    .form-section .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark);
        font-family: 'Poppins', sans-serif;
        margin-bottom: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--gold);
        display: inline-block;
    }

    .form-section .section-title .icon {
        color: var(--secondary-turquoise);
        margin-right: 8px;
    }

    .form-section .section-desc {
        color: var(--gray);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    /* ============================================================
    FORM CONTROLS - Brand Colors
    ============================================================ */
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #D1D5DB;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        background: white;
        color: var(--dark);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(45, 111, 183, 0.1);
    }

    .form-control.error {
        border-color: #EF4444;
    }

    .form-control.success {
        border-color: var(--accent-green);
    }

    .form-control::placeholder {
        color: #9CA3AF;
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .form-label .required {
        color: #EF4444;
        margin-left: 2px;
    }

    .form-hint {
        font-size: 0.75rem;
        color: #9CA3AF;
        margin-top: 0.25rem;
    }

    /* ============================================================
    FILE UPLOAD - Brand Colors
    ============================================================ */
    .file-upload-wrapper {
        position: relative;
        border: 2px dashed #D1D5DB;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: var(--light-gray);
    }

    .file-upload-wrapper:hover {
        border-color: var(--primary-blue);
        background: rgba(45, 111, 183, 0.02);
    }

    .file-upload-wrapper.dragover {
        border-color: var(--secondary-turquoise);
        background: rgba(18, 169, 198, 0.04);
    }

    .file-upload-wrapper .icon {
        font-size: 2.5rem;
        color: var(--gold);
        margin-bottom: 0.5rem;
    }

    .file-upload-wrapper .text {
        color: var(--gray);
        font-size: 0.9rem;
    }

    .file-upload-wrapper .text strong {
        color: var(--primary-blue);
    }

    .file-upload-wrapper input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-wrapper .file-name {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: var(--primary-blue);
        font-weight: 500;
    }

    .file-upload-wrapper .file-size {
        font-size: 0.75rem;
        color: #9CA3AF;
        margin-top: 0.25rem;
    }

    /* ============================================================
    SUBMIT BUTTON - Brand Colors
    ============================================================ */
    .submit-btn {
        width: 100%;
        padding: 16px;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 12px;
        background: var(--brand-gradient);
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 25px rgba(45, 111, 183, 0.3);
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 45px rgba(45, 111, 183, 0.4);
    }

    .submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .submit-btn .spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* ============================================================
    SUCCESS BOX - Brand Colors
    ============================================================ */
    .success-box {
        text-align: center;
        padding: 3rem 2rem;
    }

    .success-box .icon {
        font-size: 4rem;
        color: var(--accent-green);
        margin-bottom: 1rem;
        animation: successPulse 1s ease;
    }

    @keyframes successPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .success-box h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .success-box p {
        color: var(--gray);
        font-size: 1.05rem;
    }

    .success-box .btn-home {
        background: var(--brand-gradient);
        color: white;
        padding: 12px 32px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(45, 111, 183, 0.3);
        margin-top: 1rem;
    }

    .success-box .btn-home:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 35px rgba(45, 111, 183, 0.4);
    }

    /* ============================================================
    ALERTS - Brand Colors
    ============================================================ */
    .alert-success-custom {
        background: #D1FAE5;
        border: 1px solid #A7F3D0;
        color: #065F46;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-success-custom i {
        color: var(--accent-green);
        font-size: 1.2rem;
    }

    .alert-error-custom {
        background: #FEE2E2;
        border: 1px solid #FCA5A5;
        color: #991B1B;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-error-custom i {
        color: #EF4444;
        font-size: 1.2rem;
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .apply-hero h1 { font-size: 2.5rem; }
        .apply-hero p { font-size: 1rem; }
        .form-section { padding: 1.5rem; }
        .form-section .section-title { font-size: 1.1rem; }
        .apply-hero { padding: 100px 0 40px; }
        .file-upload-wrapper { padding: 1.5rem; }
        .submit-btn { font-size: 1rem; padding: 14px; }
    }

    @media (max-width: 480px) {
        .apply-hero h1 { font-size: 2rem; }
        .form-section { padding: 1rem; }
        .form-control { font-size: 0.85rem; padding: 10px 12px; }
        .file-upload-wrapper .icon { font-size: 2rem; }
        .file-upload-wrapper .text { font-size: 0.8rem; }
        .success-box h2 { font-size: 1.4rem; }
    }

    /* Form header */
    .form-header {
        background: var(--brand-gradient);
        padding: 1.25rem 2rem;
        border-bottom: 3px solid var(--gold);
    }

    .form-header h2 {
        color: white;
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
    }

    .form-header p {
        color: rgba(255,255,255,0.8);
        font-size: 0.9rem;
        margin: 0;
    }

    .form-header p .highlight-text {
        color: var(--gold);
        font-weight: 600;
    }

    /* Section title override */
    .section-title .highlight {
        background: var(--gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

<!-- ========================================== -->
<!-- APPLY HERO - REBRANDED -->
<!-- ========================================== -->
<section class="apply-hero">
    <div class="hero-particles">
        <span></span><span></span><span></span><span></span>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <div class="hero-badge" data-aos="fade-up">
            <i class="fas fa-paper-plane"></i>Apply Now
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" data-aos="fade-up" data-aos-delay="100">
            Start Your <span class="highlight">Journey</span>
        </h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Take the first step towards international employment opportunities
        </p>
    </div>
</section>

<!-- ========================================== -->
<!-- APPLICATION FORM - REBRANDED -->
<!-- ========================================== -->
<section class="py-20 bg-[#F8FAFC]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        <?php if ($success): ?>
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-green-100" data-aos="fade-up">
            <div class="success-box">
                <div class="icon"><i class="fas fa-check-circle"></i></div>
                <h2>Application Submitted Successfully!</h2>
                <p><?php echo $message; ?></p>
                <div class="mt-6">
                    <a href="<?php echo SITE_URL; ?>" class="btn-home">
                        <i class="fas fa-home mr-2"></i>Return Home
                    </a>
                </div>
            </div>
        </div>
        <?php else: ?>

        <!-- Error Message -->
        <?php if ($error): ?>
        <div class="alert-error-custom" data-aos="fade-up">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <!-- Application Form -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up">
            <div class="form-header">
                <h2><i class="fas fa-file-alt mr-2"></i>Application Form</h2>
                <p>Please fill in all required fields marked with <span class="highlight-text">*</span></p>
            </div>

            <form method="POST" action="" enctype="multipart/form-data" class="p-8 space-y-6" id="applicationForm">

                <!-- Personal Information -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-user icon"></i>Personal Information</h3>
                    <p class="section-desc">Tell us about yourself</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">First Name <span class="required">*</span></label>
                            <input type="text" name="first_name" required class="form-control" placeholder="Enter your first name">
                        </div>
                        <div>
                            <label class="form-label">Last Name <span class="required">*</span></label>
                            <input type="text" name="last_name" required class="form-control" placeholder="Enter your last name">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <input type="email" name="email" required class="form-control" placeholder="your@email.com">
                        </div>
                        <div>
                            <label class="form-label">Phone Number <span class="required">*</span></label>
                            <input type="tel" name="phone" required class="form-control" placeholder="+251 9XX XXX XXX">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Nationality</label>
                            <input type="text" name="nationality" class="form-control" placeholder="e.g., Ethiopian">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Current Location</label>
                        <input type="text" name="current_location" class="form-control" placeholder="City, Country">
                    </div>
                </div>

                <!-- Employment Details -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-briefcase icon"></i>Employment Details</h3>
                    <p class="section-desc">Tell us about your work experience</p>

                    <div>
                        <label class="form-label">Position Applied For <span class="required">*</span></label>
                        <select name="position_applied" required class="form-control">
                            <option value="">Select a position</option>
                            <?php foreach ($services as $service): ?>
                            <option value="<?php echo htmlspecialchars($service['name']); ?>"><?php echo htmlspecialchars($service['name']); ?></option>
                            <?php endforeach; ?>
                            <option value="Other">Other (Specify below)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="form-label">Experience (Years)</label>
                            <input type="number" name="experience_years" class="form-control" min="0" max="50" placeholder="0">
                        </div>
                        <div>
                            <label class="form-label">Current Salary (USD)</label>
                            <input type="number" name="current_salary" class="form-control" step="100" placeholder="0">
                        </div>
                        <div>
                            <label class="form-label">Expected Salary (USD)</label>
                            <input type="number" name="expected_salary" class="form-control" step="100" placeholder="0">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Availability Date</label>
                        <input type="date" name="availability_date" class="form-control">
                    </div>
                </div>

                <!-- Education & Skills -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-graduation-cap icon"></i>Education & Skills</h3>
                    <p class="section-desc">Tell us about your qualifications</p>

                    <div>
                        <label class="form-label">Education Level</label>
                        <select name="education_level" class="form-control">
                            <option value="">Select</option>
                            <option value="High School">High School</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Bachelor's Degree">Bachelor's Degree</option>
                            <option value="Master's Degree">Master's Degree</option>
                            <option value="PhD">PhD</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Skills (comma separated)</label>
                        <input type="text" name="skills" class="form-control" placeholder="e.g., HTML, CSS, Project Management">
                    </div>

                    <div>
                        <label class="form-label">Languages (comma separated)</label>
                        <input type="text" name="languages" class="form-control" placeholder="e.g., English, Amharic, Arabic">
                    </div>

                    <div>
                        <label class="form-label">Certifications</label>
                        <textarea name="certifications" rows="3" class="form-control" placeholder="List your certifications and licenses"></textarea>
                    </div>

                    <div>
                        <label class="form-label">References</label>
                        <textarea name="referees" rows="3" class="form-control" placeholder="Name, Company, Contact of 2-3 referees"></textarea>
                    </div>

                    <div>
                        <label class="form-label">Cover Letter</label>
                        <textarea name="cover_letter" rows="5" class="form-control" placeholder="Tell us about yourself and why you're the right candidate"></textarea>
                    </div>
                </div>

                <!-- Documents -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-file icon"></i>Documents</h3>
                    <p class="section-desc">Upload your documents</p>

                    <div>
                        <label class="form-label">Resume/CV <span class="required">*</span></label>
                        <div class="file-upload-wrapper" id="resumeUpload">
                            <div class="icon"><i class="fas fa-file-pdf"></i></div>
                            <div class="text">
                                <strong>Click to upload</strong> or drag and drop<br>
                                <span class="text-xs">PDF, DOC, DOCX, JPG, PNG (Max 5MB)</span>
                            </div>
                            <input type="file" name="resume" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <div class="file-name" id="resumeFileName"></div>
                            <div class="file-size" id="resumeFileSize"></div>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Passport/ID Photo</label>
                        <div class="file-upload-wrapper" id="photoUpload">
                            <div class="icon"><i class="fas fa-id-card"></i></div>
                            <div class="text">
                                <strong>Click to upload</strong> or drag and drop<br>
                                <span class="text-xs">JPG, PNG (Max 2MB)</span>
                            </div>
                            <input type="file" name="photo" accept=".jpg,.jpeg,.png">
                            <div class="file-name" id="photoFileName"></div>
                            <div class="file-size" id="photoFileSize"></div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="submit-btn" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        <span>Submit Application</span>
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-3">
                        <i class="fas fa-lock mr-1"></i> Your information is secure and will not be shared
                    </p>
                </div>

            </form>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload display with size
    document.querySelectorAll('.file-upload-wrapper input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const fileName = file ? file.name : '';
            const fileSize = file ? (file.size / 1024 / 1024).toFixed(2) + ' MB' : '';
            const displayName = this.parentElement.querySelector('.file-name');
            const displaySize = this.parentElement.querySelector('.file-size');
            
            if (displayName) {
                displayName.textContent = fileName ? '📎 ' + fileName : '';
                displayName.style.color = fileName ? '#2D6FB7' : '';
            }
            if (displaySize) {
                displaySize.textContent = fileSize ? 'Size: ' + fileSize : '';
                displaySize.style.display = fileSize ? 'block' : 'none';
            }
            
            // Add success class
            if (file) {
                this.parentElement.style.borderColor = '#6CC04A';
                this.parentElement.style.background = 'rgba(108, 192, 74, 0.04)';
            } else {
                this.parentElement.style.borderColor = '#D1D5DB';
                this.parentElement.style.background = '#F8FAFC';
            }
        });
    });
    
    // Drag and drop functionality
    document.querySelectorAll('.file-upload-wrapper').forEach(wrapper => {
        wrapper.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        wrapper.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        
        wrapper.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            const input = this.querySelector('input[type="file"]');
            if (input && e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
    
    // Form validation
    const form = document.getElementById('applicationForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner spinner"></i> Submitting...';
            
            // Re-enable after 10 seconds if something goes wrong
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Application';
            }, 10000);
        });
    }
    
    // Phone number formatting (basic)
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    }
});
</script>

<?php include 'footer.php'; ?>