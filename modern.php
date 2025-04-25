<?php
require 'assets/class/database.class.php';
require 'assets/class/function.class.php';

$slug = $_GET['resume'] ?? '';
$resumes = $db->query("SELECT * FROM resumes WHERE (slug='$slug')");
$resume = $resumes->fetch_assoc();
if (!$resume) {
    $fn->redirect('myresumes.php');
}

$exps = $db->query("SELECT * FROM experiences WHERE (resume_id=" . $resume['id'] . ")");
$exps = $exps->fetch_all(1);

$edus = $db->query("SELECT * FROM educations WHERE (resume_id=" . $resume['id'] . ")");
$edus = $edus->fetch_all(1);

$skills = $db->query("SELECT * FROM skills WHERE (resume_id=" . $resume['id'] . ")");
$skills = $skills->fetch_all(1);

// Photo Path
$photoPath = "./uploads/" . $resume['photo'];
$photoSrc = (!empty($resume['photo']) && file_exists($photoPath)) ? $photoPath : "./assets/images/default-profile.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="icon" href="./assets/images/logo.png">
    <title><?= $resume['full_name'] . ' | ' . $resume['resume_title'] ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('./assets/images/background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            font-size: 12pt;
            font-family: 'Roboto', Arial, sans-serif;
            color: #333;
        }

        * {
            margin: 0;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            font-family: inherit;
            color: inherit;
        }

        .page {
            width: 21cm;
            height: 29.7cm;
            padding: 10px 20px 0 20px;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-radius: 0;
        }

        .extra {
            margin-bottom: 0;
        }

        .extra .w-100 {
            background-color: #333;
            padding: 8px;
            text-align: center;
        }

        .extra .btn {
            background-color: #fff;
            color: #333;
            border: none;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }

        .extra .btn:hover {
            background-color: #f1f1f1;
        }

        .extra .dropdown-toggle {
            background-color: #fff;
            color: #333;
        }

        .extra .dropdown-menu {
            background-color: #fff;
            border: 1px solid #e0e0e0;
        }

        .extra .dropdown-item {
            color: #333;
            font-size: 12px;
        }

        .extra .dropdown-item:hover {
            background-color: #f1f1f1;
        }

        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 8px;
        }

        .profile-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            margin: 0 auto 8px;
            display: block;
        }

        .header h1 {
            font-size: 1.8em;
            margin: 0;
            color: #1a73e8;
            font-weight: 500;
        }

        .header p {
            font-size: 1em;
            color: #5f6368;
            margin: 2px 0 0;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            padding: 0 5px;
            flex: 1;
        }

        .section {
            margin-bottom: 8px;
        }

        .section-title {
            font-size: 1.1em;
            color: #1a73e8;
            font-weight: 500;
            margin-bottom: 6px;
            padding-bottom: 3px;
            border-bottom: 1px solid #e0e0e0;
        }

        .section-content {
            line-height: 1.2;
            color: #333;
        }

        .contact-info p, .education-info p, .skills-info p, .languages-info p, .experience-info p, .hobbies-info p, .objective-info p, .declaration-info p {
            font-size: 0.9em;
            color: #5f6368;
            margin: 2px 0;
            line-height: 1.2;
        }

        .experience-item, .education-item {
            margin-bottom: 6px;
        }

        .experience-item h5, .education-item h5 {
            font-size: 1em;
            color: #333;
            margin: 0 0 4px 0;
        }

        .skills-list, .languages-list, .hobbies-list {
            list-style-type: none;
            padding: 0;
            gap: 5px;
            display: flex;
            flex-wrap: wrap;
        }

        .skills-list li, .languages-list li, .hobbies-list li {
            font-size: 0.9em;
            color: #333;
            padding: 3px 8px;
            background-color: #f5f5f5;
            border-radius: 10px;
            margin-bottom: 5px;
        }

        .objective {
            font-size: 0.9em;
            color: #333;
            margin-bottom: 6px;
            line-height: 1.2;
            padding: 8px;
            background-color: #f5f5f5;
            border-radius: 4px;
        }

        .declaration {
            font-size: 0.9em;
            color: #5f6368;
            line-height: 1.2;
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
                padding: 10px 20px 0 20px;
                box-shadow: none;
                border: none;
            }

            .extra {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar for Template Selection, Print, and Download Buttons -->
    <?php
    if ($fn->Auth() != false && $fn->Auth()['id'] == $resume['user_id']) {
        ?>
        <div class="extra">
            <div class="w-100 py-2 bg-dark d-flex justify-content-center gap-3 align-items-center">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Select Resume Template
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="resume.php?resume=<?= $slug ?>">Default</a></li>
                        <li><a class="dropdown-item" href="classic.php?resume=<?= $slug ?>">Classic</a></li>
                        <li><a class="dropdown-item" href="professional.php?resume=<?= $slug ?>">Professional</a></li>
                        <li><a class="dropdown-item" href="modern.php?resume=<?= $slug ?>">Modern</a></li>
                    </ul>
                </div>
                <?php
                $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                ?>
                <button class="btn btn-light btn-sm" id="print"><i class="bi bi-printer"></i> Print</button>
                <button class="btn btn-light btn-sm" id="downloadpdf"><i class="bi bi-file-earmark-pdf"></i> Download</button>
            </div>
        </div>
        <?php
    }
    ?>

    <!-- Resume Content -->
    <div class="page">
        <!-- Header with Profile Photo -->
        <div class="header">
            <img src="<?= htmlspecialchars($photoSrc, ENT_QUOTES, 'UTF-8') ?>" alt="Profile Photo" class="profile-photo">
            <h1><?= $resume['full_name'] ?></h1>
            <p><?= $resume['resume_title'] ?></p> <!-- Industry/Field below name -->
        </div>

        <!-- Main Content with Two-Column Layout -->
        <div class="main-content">
            <!-- Left Column (Personal Info) -->
            <div>
                <div class="section contact-info">
                    <h3 class="section-title">Contact</h3>
                    <div class="section-content">
                        <p><?= $resume['email_id'] ?></p>
                        <p>+91-<?= $resume['mobile_no'] ?></p> <!-- Updated to 10-digit format -->
                        <p><?= $resume['address'] ?></p>
                    </div>
                </div>

                <div class="section education-info">
                    <h3 class="section-title">Education</h3>
                    <div class="section-content">
                        <?php if ($edus): ?>
                            <?php foreach ($edus as $edu): ?>
                                <div class="education-item">
                                    <h5><?= $edu['course'] ?></h5>
                                    <p><?= $edu['institute'] ?> (<?= $edu['started'] ?> - <?= $edu['ended'] === 'Present' ? 'Present' : $edu['ended'] ?>)</p>
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
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No education listed.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="section skills-info">
                    <h3 class="section-title">Skills</h3>
                    <div class="section-content">
                        <ul class="skills-list">
                            <?php if ($skills): ?>
                                <?php foreach ($skills as $skill): ?>
                                    <li><?= $skill['skill'] ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>No skills listed.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="section languages-info">
                    <h3 class="section-title">Languages</h3>
                    <div class="section-content">
                        <ul class="languages-list">
                            <?php
                            if (!empty($resume['languages'])) {
                                $languages = explode(',', $resume['languages']);
                                foreach ($languages as $language) {
                                    ?>
                                    <li><?= trim($language) ?></li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li>No languages listed.</li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="section hobbies-info">
                    <h3 class="section-title">Hobbies</h3>
                    <div class="section-content">
                        <ul class="hobbies-list">
                            <?php
                            if (!empty($resume['hobbies'])) {
                                $hobbies = explode(',', $resume['hobbies']);
                                foreach ($hobbies as $hobby) {
                                    ?>
                                    <li><?= trim($hobby) ?></li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li>No hobbies listed.</li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column (Professional Info) -->
            <div>
                <div class="section objective-info">
                    <h3 class="section-title">Objective</h3>
                    <div class="section-content">
                        <p class="objective"><?= $resume['objective'] ?></p>
                    </div>
                </div>

                <div class="section experience-info">
                    <h3 class="section-title">Work Experience</h3>
                    <div class="section-content">
                        <?php if ($exps): ?>
                            <?php foreach ($exps as $exp): ?>
                                <div class="experience-item">
                                    <h5><?= $exp['position'] ?> | <?= $exp['company'] ?></h5>
                                    <p><?= $exp['started'] ?> - <?= $exp['ended'] ?></p>
                                    <p><?= $exp['job_desc'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No experience listed.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="section declaration-info">
                    <h3 class="section-title">Declaration</h3>
                    <div class="section-content">
                        <p class="declaration">
                            I hereby declare that the information provided above is true to the best of my knowledge and belief.
                        </p>
                        <p class="declaration">
                            Date: <?= date('d F, Y', $resume['updated_at']) ?>
                        </p>
                        <p class="declaration">
                            Place: <?= $resume['address'] ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script>
        $("#downloadpdf").click(function () {
            window.jsPDF = window.jspdf.jsPDF;
            var doc = new jsPDF({
                unit: 'mm',
                format: 'a4'
            });

            var page = document.querySelector('.page');

            doc.html(page, {
                callback: function (doc) {
                    doc.save('<?= $resume['full_name'] ?> - <?= $resume['resume_title'] ?>.pdf');
                },
                margin: [10, 20, 0, 20],
                x: 0,
                y: 0,
                width: 170,
                windowWidth: 800
            });
        });

        $("#print").click(function () {
            $(".extra").hide();
            window.print();
            setTimeout(() => {
                $(".extra").show();
            }, 500);
        });
    </script>
</body>
</html>