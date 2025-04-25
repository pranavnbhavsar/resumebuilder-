<?php
require 'assets/class/database.class.php';
require 'assets/class/function.class.php';

// Initialize the database connection (assuming database.class.php provides a $db object)
$db = new Database(); // Adjust this based on your class implementation

$slug = $_GET['resume'] ?? '';
// Use mysqli query directly or update database.class.php to handle prepared statements correctly
$resumes = $db->query("SELECT * FROM resumes WHERE slug = '$slug'"); // Simple query for now, but use prepared statement for security
$resume = $resumes->fetch_assoc();
if (!$resume) {
    $fn->redirect('myresumes.php');
}

// Fetch experiences, educations, and skills using similar mysqli queries
$exps = $db->query("SELECT * FROM experiences WHERE resume_id = " . $resume['id']);
$exps = $exps->fetch_all(MYSQLI_ASSOC);

$edus = $db->query("SELECT * FROM educations WHERE resume_id = " . $resume['id']);
$edus = $edus->fetch_all(MYSQLI_ASSOC);

$skills = $db->query("SELECT * FROM skills WHERE resume_id = " . $resume['id']);
$skills = $skills->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="./assets/images/logo.png" onerror="this.src='./assets/images/default-logo.png';">
    <title><?= htmlspecialchars($resume['full_name'] . ' | ' . $resume['resume_title']) ?></title>
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
            width: 21cm; /* A4 width */
            height: 29.7cm; /* A4 height - exact fit for single page */
            margin: 0 auto;
            padding: 15px; /* Balanced margins for professional look */
            background: linear-gradient(135deg, #ffffff 70%, #e6f3ff 100%); /* Creative gradient background */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-radius: 8px;
            position: relative;
        }

        /* Decorative Element */
        .page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #3498db, #e74c3c);
            border-radius: 8px 8px 0 0;
        }

        /* Navbar Styles */
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
            border: 1px solid #e0e0e0;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            border-radius: 20px;
        }

        .extra .btn:hover {
            background-color: #f1f1f1;
            border-color: #3498db;
            color: #3498db;
        }

        .extra .dropdown-toggle {
            background-color: #fff;
            color: #333;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
        }

        .extra .dropdown-menu {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .extra .dropdown-item {
            color: #333;
            font-size: 12px;
            padding: 8px 16px;
        }

        .extra .dropdown-item:hover {
            background-color: #f1f1f1;
            color: #3498db;
        }

        /* Header Section */
        .header {
            text-align: center;
            padding: 20px 0 10px;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 15px;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 50px;
            height: 2px;
            background: #3498db;
            transform: translateX(-50%);
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #3498db;
            margin: 0 auto 15px;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.3);
            display: block;
        }

        .header h1 {
            font-size: 2.2em; /* Larger, attractive font */
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 1.1em;
            color: #7f8c8d;
            margin: 5px 0 0;
            font-style: italic;
        }

        /* Main Content */
        .main-content {
            display: grid;
            grid-template-columns: 1fr 2fr; /* Creative two-column layout */
            gap: 15px;
            padding: 0 5px;
            flex: 1;
        }

        .section {
            margin-bottom: 10px; /* Reduced for tighter fit */
        }

        .section-title {
            font-size: 1.3em; /* Larger, bold title */
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px; /* Reduced for tighter fit */
            padding-bottom: 5px;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background: #3498db;
        }

        .section-content {
            line-height: 1.4; /* Tighter for full page use */
            color: #333;
        }

        .contact-info, .education-info, .skills-info, .languages-info, .hobbies-info {
            background: rgba(255, 255, 255, 0.9);
            padding: 10px; /* Reduced for tighter fit */
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .experience-info, .objective-info, .declaration-info {
            background: rgba(255, 255, 255, 0.9);
            padding: 10px; /* Reduced for tighter fit */
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .contact-info p, .education-info p, .skills-info p, .languages-info p, .hobbies-info p, 
        .experience-info p, .objective-info p, .declaration-info p {
            font-size: 12px; /* Reduced for tighter fit */
            color: #7f8c8d;
            margin: 4px 0; /* Reduced margin for tighter spacing */
            line-height: 1.4;
        }

        .experience-item, .education-item {
            margin-bottom: 8px; /* Reduced for tighter fit */
        }

        .experience-item h5, .education-item h5 {
            font-size: 1em; /* Reduced for tighter fit */
            color: #2c3e50;
            margin: 0 0 4px 0; /* Reduced margin */
            font-weight: 600;
        }

        .skills-list, .languages-list, .hobbies-list {
            list-style-type: none;
            padding: 0;
            gap: 6px; /* Reduced gap for tighter fit */
            display: flex;
            flex-wrap: wrap;
        }

        .skills-list li, .languages-list li, .hobbies-list li {
            font-size: 12px; /* Reduced for tighter fit */
            color: #333;
            padding: 4px 10px; /* Reduced padding */
            background: #3498db;
            color: #fff;
            border-radius: 15px;
            display: flex;
            align-items: center;
            margin-bottom: 6px; /* Reduced margin */
        }

        .skills-list li::before, .languages-list li::before, .hobbies-list li::before {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-right: 6px; /* Reduced margin */
            font-size: 10px; /* Reduced for tighter fit */
        }

        .objective {
            font-size: 12px; /* Reduced for tighter fit */
            color: #2c3e50;
            margin-bottom: 8px; /* Reduced margin */
            line-height: 1.4;
            padding: 10px; /* Reduced padding */
            background: linear-gradient(135deg, #f5f9ff, #e6f3ff);
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .declaration {
            font-size: 12px; /* Reduced for tighter fit */
            color: #7f8c8d;
            line-height: 1.4;
        }

        /* Print and Display Settings for A4 */
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
                padding: 15px; /* Maintain margins for print */
                box-shadow: none;
                border: none;
                background: #fff; /* Remove gradient for print */
            }

            .extra {
                display: none; /* Hide the navbar */
            }

            .page::before {
                display: none; /* Hide decorative element */
            }

            .header::after, .section-title::after {
                display: none; /* Hide decorative lines */
            }

            .skills-list li::before, .languages-list li::before, .hobbies-list li::before {
                display: none; /* Hide icons for print */
            }

            .sidebar {
                background-color: #f0f0f0; /* Ensure gray background prints */
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
                <!-- Dropdown for Template Selection -->
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Select Resume Template
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="resume.php?resume=<?= $slug ?>">Default</a></li>
                        <li><a class="dropdown-item" href="classic.php?resume=<?= $slug ?>">Classic</a></li>
                        <li><a class="dropdown-item" href="professional.php?resume=<?= $slug ?>">Professional</a></li>
                        <li><a class="dropdown-item" href="modern.php?resume=<?= $slug ?>">Modern</a></li>
                        <li><a class="dropdown-item" href="creative.php?resume=<?= $slug ?>">Creative</a></li>
                    </ul>
                </div>

                <!-- Download and Print Buttons -->
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
        <!-- Sidebar (Left Column) -->
        <div class="sidebar">
            <div>
                <h3>Contact</h3>
                <p>Email: <?= htmlspecialchars($resume['email_id']) ?></p>
                <p>Phone: +91-<?= htmlspecialchars($resume['mobile_no']) ?></p>
                <p>Address: <?= htmlspecialchars($resume['address']) ?></p>
                <p>LinkedIn: <?= htmlspecialchars($resume['linkedin'] ?? 'Not provided') ?></p>

                <h3>Education</h3>
                <?php
                if ($edus) {
                    foreach ($edus as $edu) {
                        ?>
                        <p><strong><?= htmlspecialchars($edu['course']) ?></strong> | <?= htmlspecialchars($edu['institute']) ?> (<?= htmlspecialchars($edu['started']) ?> - <?= htmlspecialchars($edu['ended']) ?>)</p>
                        <?php
                    }
                } else {
                    echo "<p>No education listed.</p>";
                }
                ?>

                <h3>Skills</h3>
                <ul>
                    <?php
                    if ($skills) {
                        foreach ($skills as $skill) {
                            ?>
                            <li><?= htmlspecialchars($skill['skill']) ?></li>
                            <?php
                        }
                    } else {
                        echo "<p>No skills listed.</p>";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Main Content (Right Column) -->
        <div class="main-content">
            <!-- Header with Profile Photo -->
            <div class="header">
                <?php
                $photoPath = "./uploads/" . $resume['photo'];
                $photoSrc = (!empty($resume['photo']) && file_exists($photoPath)) ? $photoPath : "./assets/images/default-profile.png";
                ?>
                <img src="<?= htmlspecialchars($photoSrc, ENT_QUOTES, 'UTF-8') ?>" alt="Profile Photo" class="profile-photo">
                <h1><?= htmlspecialchars($resume['full_name']) ?></h1>
                <p><?= htmlspecialchars($resume['resume_title']) ?></p>
            </div>

            <div class="section">
                <h3 class="section-title">Objective</h3>
                <div class="section-content">
                    <p class="objective">
                        <?= htmlspecialchars($resume['objective']) ?>
                    </p>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Work Experience</h3>
                <div class="section-content">
                    <?php
                    if ($exps) {
                        foreach ($exps as $exp) {
                            ?>
                            <div class="experience-item">
                                <h5><?= htmlspecialchars($exp['position']) ?> | <?= htmlspecialchars($exp['company']) ?></h5>
                                <p><?= htmlspecialchars($exp['started']) ?> - <?= htmlspecialchars($exp['ended']) ?></p>
                                <p><?= htmlspecialchars($exp['job_desc']) ?></p>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>No experience listed.</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Declaration</h3>
                <div class="section-content">
                    <p class="declaration">
                        I hereby declare that the information provided above is true to the best of my knowledge and can be supported by relevant documents as and when required.
                    </p>
                    <p class="declaration">Date: <?= htmlspecialchars(date('d F, Y', $resume['updated_at'])) ?></p>
                    <p class="declaration">Place: <?= htmlspecialchars($resume['address']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas for Background and Font Selection -->
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="background" style="height:50vh" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title w-100" id="offcanvasBottomLabel">Change Background</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body w-100">
            <div class="d-flex w-100 gap-2 flex-wrap justify-content-center">
                <?php
                for ($i = 1; $i < 22; $i++) {
                    ?>
                    <div class="tile rounded shadow-sm border" data-background="tile<?= $i ?>.png" style="width:100px; height:100px; background-size:cover; background-image:url(./assets/images/tiles/tile<?= $i ?>.png)"></div>
                    <?php
                }
                ?>
                <div class="tile rounded shadow-sm border" data-background="tile23.jpg" style="width:100px; height:100px; background-size:cover; background-image:url(./assets/images/tiles/tile23.jpg)"></div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="font" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel">Change Font</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <select class="form-control" id="font">
                <option value="Arial, sans-serif" <?=$resume['font'] == 'Arial, sans-serif' ? 'selected' : ''?>>System Font (Arial)</option>
                <option value="'Poppins', sans-serif" style="font-family:'Poppins', sans-serif" <?=$resume['font'] == "'Poppins', sans-serif" ? 'selected' : ''?>>'Poppins', sans-serif</option>
                <option value="'Caveat', cursive" style="font-family:'Caveat', sans-serif" <?=$resume['font'] == "'Caveat', cursive" ? 'selected' : ''?>>'Caveat', cursive</option>
                <option value="'Dancing Script', cursive" style="font-family:'Dancing Script', sans-serif" <?=$resume['font'] == "'Dancing Script', cursive" ? 'selected' : ''?>>'Dancing Script', cursive</option>
                <option value="'Exo', sans-serif" style="font-family:'Exo', sans-serif" <?=$resume['font'] == "'Exo', sans-serif" ? 'selected' : ''?>>'Exo', sans-serif</option>
                <option value="'Fuggles', cursive" style="font-family:'Fuggles', sans-serif" <?=$resume['font'] == "'Fuggles', cursive" ? 'selected' : ''?>>'Fuggles', cursive</option>
                <option value="'Gloria Hallelujah', cursive" style="font-family:'Gloria Hallelujah', sans-serif" <?=$resume['font'] == "'Gloria Hallelujah', cursive" ? 'selected' : ''?>>'Gloria Hallelujah', cursive</option>
                <option value="'Mooli', sans-serif" style="font-family:'Mooli', sans-serif" <?=$resume['font'] == "'Mooli', sans-serif" ? 'selected' : ''?>>'Mooli', sans-serif</option>
                <option value="'Nunito', sans-serif" style="font-family:'Nunito', sans-serif" <?=$resume['font'] == "'Nunito', sans-serif" ? 'selected' : ''?>>'Nunito', sans-serif</option>
                <option value="'Zilla Slab', serif" style="font-family:'Zilla Slab', sans-serif" <?=$resume['font'] == "'Zilla Slab', serif" ? 'selected' : ''?>>'Zilla Slab', serif</option>
            </select>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>

    <script>
        $("#downloadpdf").click(function () {
            window.jsPDF = window.jspdf.jsPDF;
            var doc = new jsPDF({
                unit: 'mm',
                format: 'a4' // Explicitly set to A4 format
            });

            var page = document.querySelector('.page');

            doc.html(page, {
                callback: function (doc) {
                    doc.save('<?= htmlspecialchars($resume['full_name']) ?> - <?= htmlspecialchars($resume['resume_title']) ?>.pdf');
                },
                margin: [15, 15, 15, 15], // Uniform 15mm margins for A4
                x: 0,
                y: 0,
                width: 180, // Adjusted width to account for margins (210mm - 30mm total margin)
                windowWidth: 800
            });
        });

        $("#font").change(function () {
            let font = $(this).find(":selected").val();
            $(".page").css('font-family', font);

            $.ajax({
                url: 'actions/changefont.action.php',
                method: 'post',
                data: {
                    resume_id: <?= $resume['id'] ?>,
                    font: font
                },
                success: function (res) {
                    console.log(res);
                },
                error: function (res) {
                    console.log(res);
                    alert('Font is not updated');
                }
            });
        });

        $(".tile").click(function () {
            let tile = $(this).data('background');
            $("body").css('background-image', 'url(./assets/images/tiles/' + tile + ')');

            $.ajax({
                url: 'actions/changeback.action.php',
                method: 'post',
                data: {
                    resume_id: <?= $resume['id'] ?>,
                    background: tile
                },
                success: function (res) {
                    console.log(res);
                },
                error: function (res) {
                    console.log(res);
                    alert('Background is not updated');
                }
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