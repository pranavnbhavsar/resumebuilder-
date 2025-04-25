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

        .resume {
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            box-sizing: border-box;
            overflow: hidden;
        }

        .left-column {
            width: 32%;
            padding: 0 8px 0 0;
            border-right: 1px solid #555;
        }

        .right-column {
            width: 68%;
            padding: 0 0 0 8px;
        }

        .photo {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            overflow: hidden;
            margin: 10px auto 12px;
            border: 1px solid #555;
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
            margin: 0 0 6px 0;
        }

        h2 {
            font-size: 18px;
            font-weight: 600;
            color: #000;
            margin: 12px 0 6px 0;
            border-bottom: 1px solid #555;
            padding-bottom: 3px;
        }

        .contact-info p, .personal-details ul li, .skills ul li, .languages ul li, .hobbies ul li,
        .education p, .work-experience p, .work-experience ul li, .declaration p {
            font-size: 14px;
            color: #000;
            margin: 4px 0;
            line-height: 1.3;
        }

        .resume-title {
            font-size: 16px;
            margin: 0 0 12px 0;
        }

        .personal-details ul, .skills ul, .languages ul, .hobbies ul, .work-experience ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .work-experience ul {
            list-style-type: disc;
            padding-left: 15px;
            margin: 4px 0;
        }

        .education h3, .work-experience h3 {
            font-size: 16px;
            font-weight: 600;
            color: #000;
            margin: 6px 0 4px 0;
        }

        .navbar {
            background-color: #333;
            padding: 8px;
            margin-bottom: 0;
            text-align: center;
        }

        .navbar a {
            color: #fff;
            margin: 0 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .navbar button {
            background-color: #fff;
            color: #333;
            border: none;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 14px;
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

            .resume {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 15px;
                box-shadow: none;
            }

            .navbar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="resume.php?resume=<?= $slug ?>">Default</a>
        <a href="classic.php?resume=<?= $slug ?>">Classic</a>
        <a href="professional.php?resume=<?= $slug ?>">Professional</a>
        <a href="modern.php?resume=<?= $slug ?>">Modern</a>
        <button onclick="window.print()">Print Resume</button>
        <button onclick="downloadResume()">Download Resume</button>
    </div>

    <div class="resume">
        <div class="left-column">
            <div class="photo">
                <img src="<?= htmlspecialchars($photoSrc, ENT_QUOTES, 'UTF-8') ?>" alt="Profile Photo">
            </div>
            <div class="contact-info">
                <h2>Contact</h2>
                <p>Phone: +91-<?= $resume['mobile_no'] ?></p>
                <p>Email: <?= $resume['email_id'] ?></p>
                <p>Address: <?= $resume['address'] ?></p>
            </div>
            <div class="personal-details">
                <h2>Personal Details</h2>
                <ul>
                    <li>Date of Birth: <?= date('d F Y', strtotime($resume['dob'])) ?></li>
                    <li>Gender: <?= $resume['gender'] ?></li>
                    <li>Nationality: <?= $resume['nationality'] ?></li>
                    <li>Marital Status: <?= $resume['marital_status'] ?></li>
                </ul>
            </div>
            <div class="skills">
                <h2>Skills</h2>
                <ul>
                    <?php if ($skills): ?>
                        <?php foreach ($skills as $skill): ?>
                            <li><?= $skill['skill'] ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No skills listed.</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="languages">
                <h2>Languages</h2>
                <ul>
                    <?php
                    if (!empty($resume['languages'])) {
                        $languages = explode(',', $resume['languages']);
                        foreach ($languages as $language) {
                            echo "<li>" . trim($language) . "</li>";
                        }
                    } else {
                        echo "<li>No languages listed.</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="hobbies">
                <h2>Hobbies</h2>
                <ul>
                    <?php
                    if (!empty($resume['hobbies'])) {
                        $hobbies = explode(',', $resume['hobbies']);
                        foreach ($hobbies as $hobby) {
                            echo "<li>" . trim($hobby) . "</li>";
                        }
                    } else {
                        echo "<li>No hobbies listed.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="right-column">
            <h1><?= $resume['full_name'] ?></h1>
            <p class="resume-title"><?= $resume['resume_title'] ?></p>
            <div class="profile">
                <h2>Objective</h2>
                <p><?= $resume['objective'] ?></p>
            </div>
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
                    <p>No education listed.</p>
                <?php endif; ?>
            </div>
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
            <div class="declaration">
                <h2>Declaration</h2>
                <p>I hereby declare that the information provided above is true to the best of my knowledge and belief.</p>
                <p>Date: <?= date('d F Y', $resume['updated_at']) ?></p>
                <p>Place: <?= $resume['address'] ?></p>
            </div>
        </div>
    </div>

    <script>
        function downloadResume() {
            const element = document.querySelector('.resume');
            const opt = {
                margin: 15,
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