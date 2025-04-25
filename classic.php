<?php
require 'assets/class/database.class.php';
require 'assets/class/function.class.php';

$slug = $_GET['resume'] ?? '';
$resumes = $db->query("SELECT * FROM resumes WHERE (slug='$slug') ");
$resume = $resumes->fetch_assoc();
if (!$resume) {
    $fn->redirect('myresumes.php');
}

$exps = $db->query("SELECT * FROM experiences WHERE (resume_id=" . $resume['id'] . ") ");
$exps = $exps->fetch_all(1);

$edus = $db->query("SELECT * FROM educations WHERE (resume_id=" . $resume['id'] . ") ");
$edus = $edus->fetch_all(1);

$skills = $db->query("SELECT * FROM skills WHERE (resume_id=" . $resume['id'] . ") ");
$skills = $skills->fetch_all(1);

// Photo Path
$photoPath = "./uploads/" . $resume['photo'];
$photoSrc = (!empty($resume['photo']) && file_exists($photoPath)) ? $photoPath : "./assets/images/default-profile.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title><?= $resume['full_name'] . ' | ' . $resume['resume_title'] ?></title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: #000;
            margin: 0;
            padding: 0;
            background-image: url('./assets/images/background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }

        .page {
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            overflow: hidden;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            padding: 5px 0;
        }

        .photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
            border: 1px solid #3498db;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        h1 {
            font-size: 28px;
            font-weight: 600;
            color: #000;
            margin: 0 0 2px 0;
        }

        .resume-title {
            font-size: 14px;
            margin: 0 0 8px 0;
        }

        h2 {
            font-size: 20px;
            font-weight: 600;
            color: #000;
            margin: 8px 0 4px 0;
            border-bottom: 1px solid #3498db;
            padding-bottom: 3px;
        }

        .contact-info, .personal-details, .profile, .education, .skills, .work-experience, .languages {
            margin-bottom: 8px;
            padding: 5px;
        }

        .contact-info p, .personal-details ul li, .profile p, .education p, .work-experience p, .skills ul li, .languages ul li, .work-experience ul li {
            font-size: 12px;
            color: #000;
            margin: 2px 0;
            line-height: 1.2;
        }

        .education h3, .work-experience h3 {
            font-size: 16px;
            font-weight: 600;
            color: #000;
            margin: 4px 0 2px 0;
        }

        .personal-details ul, .skills ul, .languages ul, .work-experience ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .work-experience ul {
            list-style-type: disc;
            padding-left: 15px;
            margin: 2px 0;
        }

        .navbar {
            background-color: #3498db;
            padding: 8px;
            margin-bottom: 0;
            text-align: center;
        }

        .navbar a {
            color: #fff;
            margin: 0 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .navbar button {
            background-color: #fff;
            color: #3498db;
            border: none;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }

        .navbar button:hover {
            background-color: #f1f1f1;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: #fff;
            }

            .page {
                width: 21cm;
                height: 29.7cm;
                margin: 0;
                padding: 10px;
                box-shadow: none;
                border: none;
            }

            .navbar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar for Template Switching, Download, and Print -->
    <div class="navbar">
        <a href="resume.php?resume=<?= $slug ?>">Default</a>
        <a href="classic.php?resume=<?= $slug ?>">Classic</a>
        <a href="professional.php?resume=<?= $slug ?>">Professional</a>
        <a href="modern.php?resume=<?= $slug ?>">Modern</a>
        <button onclick="window.print()">Print Resume</button>
        <button onclick="downloadResume()">Download Resume</button>
    </div>

    <div class="page">
        <!-- Header with Photo and Name -->
        <div class="header">
            <div class="photo">
                <img src="<?= htmlspecialchars($photoSrc, ENT_QUOTES, 'UTF-8') ?>" alt="Profile Photo" id="profile-photo">
            </div>
            <div>
                <h1><?= $resume['full_name'] ?></h1>
                <p class="resume-title"><?= $resume['resume_title'] ?></p> <!-- Industry/Field below name -->
            </div>
        </div>

        <!-- Personal Details -->
        <div class="personal-details">
            <h2>Personal Details</h2>
            <ul>
                <li>Date of Birth: <?= date('d F Y', strtotime($resume['dob'])) ?></li>
                <li>Gender: <?= $resume['gender'] ?></li>
                <li>Nationality: <?= $resume['nationality'] ?></li>
                <li>Marital Status: <?= $resume['marital_status'] ?></li>
                <li>Hobbies: <?= $resume['hobbies'] ?></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="contact-info">
            <h2>Contact</h2>
            <p>Phone: +91-<?= $resume['mobile_no'] ?></p> <!-- Updated to 10-digit format -->
            <p>Email: <?= $resume['email_id'] ?></p>
            <p>Address: <?= $resume['address'] ?></p>
        </div>

        <!-- Profile Section -->
        <div class="profile">
            <h2>Objective</h2>
            <p><?= $resume['objective'] ?></p>
        </div>

        <!-- Education Section -->
        <div class="education">
            <h2>Education</h2>
            <?php if ($edus): ?>
                <?php foreach ($edus as $edu): ?>
                    <h3><?= $edu['course'] ?></h3>
                    <p><?= $edu['institute'] ?> | <?= $edu['started'] ?> – <?= $edu['ended'] === 'Present' ? 'Present' : $edu['ended'] ?></p>
                    <?php if (!empty($edu['grade_type']) && !empty($edu['grade'])): ?>
                        <p>
                            <?php
                            if ($edu['grade_type'] == 'grade') echo "Grade: ";
                            elseif ($edu['grade_type'] == 'marks') echo "Marks: ";
                            elseif ($edu['grade_type'] == 'cgpa') echo "CGPA: ";
                            ?>
                            <?= $edu['grade'] ?><?= $edu['grade_type'] == 'marks' ? '%' : '' ?>
                        </p>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No education details provided.</p>
            <?php endif; ?>
        </div>

        <!-- Skills Section -->
        <div class="skills">
            <h2>Skills</h2>
            <ul>
                <?php if ($skills): ?>
                    <?php foreach ($skills as $skill): ?>
                        <li><?= $skill['skill'] ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No skills provided.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Work Experience Section -->
        <div class="work-experience">
            <h2>Work Experience</h2>
            <?php if ($exps): ?>
                <?php foreach ($exps as $exp): ?>
                    <h3><?= $exp['position'] ?></h3>
                    <p><?= $exp['company'] ?> | <?= $exp['started'] ?> – <?= $exp['ended'] ?></p>
                    <ul>
                        <li><?= $exp['job_desc'] ?></li>
                    </ul>
                <?php endforeach; ?>
            <?php else: ?>
                <p>I am a Fresher.</p>
            <?php endif; ?>
        </div>

        <!-- Languages Section -->
        <div class="languages">
            <h2>Languages</h2>
            <ul>
                <?php
                $languages = explode(',', $resume['languages']);
                foreach ($languages as $language):
                ?>
                    <li><?= trim($language) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Script for Downloading Resume -->
    <script>
        function downloadResume() {
            const element = document.querySelector('.page');
            const opt = {
                margin: 10,
                filename: '<?= $resume['full_name'] ?>_Resume.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2pdf: { 
                    scale: 2, 
                    useCORS: true, 
                    logging: false,
                    width: 794,
                    height: 1123
                },
                jsPDF: { 
                    unit: 'mm', 
                    format: 'a4', 
                    orientation: 'portrait' 
                }
            };

            html2pdf()
                .set(opt)
                .from(element)
                .save()
                .catch(err => console.error('Error generating PDF:', err));
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</body>
</html>